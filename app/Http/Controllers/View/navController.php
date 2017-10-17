<?php

namespace App\Http\Controllers\View;

use Cookie;
use App\Http\Controllers\Controller;

class navController extends Controller
{
    public function toIndex()
    {
        $locale = Cookie::get('lang');
        app() -> setLocale($locale);
    //------Creating a date and time variables in the correct format in order to use them in query url to get a specific data and time------
        $date = date('Y-m-d');
        $time =  date('H:i',strtotime('-1 minute'));
        $url = 'http://193.185.142.46/TrafficlightdataService/rest/get-traffic-queue-length-and-wait-time?historyMinutes=1&date='.$date.'&time='.$time;
//----------Sending the queries------------
    //---------- the first query is for traffic queue length and average waiting time and vehicle count---------
    //-------we get the query result in a variable then we decode it using json_decode()

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    $avgWaitingTimeQuery = curl_exec($ch);
    curl_close($ch);
    $avgWaitingTimeData=json_decode($avgWaitingTimeQuery);
//----------------------------------------
    //---------- the second query is for traffic amount per hour---------
    //-------we get the query result in a variable then we decode it using json_decode()
    $ch1 = curl_init();
    curl_setopt($ch1, CURLOPT_URL, 'http://193.185.142.46/TrafficlightdataService/rest/get-traffic-amount?historyMinutes=1&date='.$date.'&time='.$time);
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch1, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    $trafficAmountQuery = curl_exec($ch1);
    curl_close($ch1);
    $trafficAmountData=json_decode($trafficAmountQuery);
//-----------------------------------------
    //----- Open the csv file where there are coordinates and directions for the devices------ 
    $file = fopen("coordinates_v2.csv","r");
    $csv = array_map('str_getcsv', file('coordinates_v2.csv'));  // ---- change the file data to an array  
    $size = sizeof ($csv);
    $merge_data = array(); // this array is created to contain data coming from three sources, $avgWaitingTimeQuery, csv file and  $trafficAmountQuery.    
   
   //we put the needed data in the a varialble, this is necessary because of the way the data is structured.
   
    $avgWaitingTimeVar= $avgWaitingTimeData->results; 
    $trafficAmountVar= $trafficAmountData->results;
    // the following is verification mechanism since the API response is not always full of data.
    $avgWaitingTimeCount = count($avgWaitingTimeVar);
//    echo $avgWaitingTimeCount;
    $trafficAmountCount = count($trafficAmountVar);
//    echo " ". $trafficAmountCount;

   //------ the below is 3 for nested loops, the first level is getting the device and detector from the $avgWaitingTimeVar and looking it up in the $csv variable(second loop), if there is match we look the traffic amount for the same device and detector.
   for ($i=0;$i<$avgWaitingTimeCount  ;$i++ ){   //for avrage waiting time.
         $found = false;// the variable $found is used to break out of the loop when the match is found
       for($k = 1;$k<$size ; $k++ ){  //for csv file.		   
		    if($found)
			   break;
		   
		    for($j=0;$j<$trafficAmountCount;$j++){ //for traffic amount.
    
                 if(($avgWaitingTimeVar[$i]->device == $csv[$k][0]) && ($avgWaitingTimeVar[$i]->detector == $csv[$k][1]) && ($trafficAmountVar[$j]->device == $csv[$k][0]) && ($trafficAmountVar[$j]->detector == $csv[$k][1]) )
                    {
           
            
                         $merge_data[$i]=array('device'=>$csv[$k][0],'detector'=>$csv[$k][1],'lat'=>$csv[$k][2],'long'=>$csv[$k][3],'avgtime'=>$avgWaitingTimeVar[$i]->avgWaitTime,'tAmount'=>$trafficAmountVar[$j]->trafficAmount, 'direction' =>$csv[$k][4],'queueLength'=>$avgWaitingTimeVar[$i]->queueLength, 'vehicleCount'=>$avgWaitingTimeVar[$i]->vehicleCount);
                         $found = true;
                         break;
           }
		  }
        
     }
     
   }
   
  
   
   //----the formed array is encoded in json in order to be sent and used in the index blade
    $data=json_encode($merge_data);
       return view('index')->with(array('lang' => $locale,'json' => $data));
    }


     //----- Getting the coordinates from CSV file and sending the to History blade
    public function toHistory()
    {
        $file = fopen("coordinates_v2.csv","r");
        $csv = array_map('str_getcsv', file('coordinates_v2.csv'));    
        $size = sizeof ($csv);
        $locale = Cookie::get('lang');
        app() -> setLocale($locale);
        return view('history',['coord' =>json_encode($csv)]);
        
    }

    //----- Handling requests from the Markers to get the average waiting time and traffic amount data from a specific date.

    public function toDataFunction($device,$detector,$formatted,$time) {
        $locale = Cookie::get('lang');
        app() -> setLocale($locale);
     
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://193.185.142.46/TrafficlightdataService/rest/get-traffic-queue-length-and-wait-time?device='.$device.'&detector='.$detector.'&date='.$formatted.'&time='.$time.'&historyMinutes=1');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    $avgTimeQuery = curl_exec($ch);
    curl_close($ch);
    $avgTimeJsonData=json_decode($avgTimeQuery);//---puting the decoded data in a variable so it can used
    $avgTimeVar=$avgTimeJsonData->results;//-- taking the needed data from the query result

    $ch1 = curl_init();
    curl_setopt($ch1, CURLOPT_URL, 'http://193.185.142.46/TrafficlightdataService/rest/get-traffic-amount?device='.$device.'&detector='.$detector.'&date='.$formatted.'&time='.$time.'&historyMinutes=1');
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch1, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    $trafficAmountQuery = curl_exec($ch1);
    curl_close($ch1);
    $trafficAmountJsonData=json_decode($trafficAmountQuery);
    $trafficAmountVar= $trafficAmountJsonData->results;

    $merge_data = array(); //-- created to put the end result in it.
    
   
   //---if we get a response from the API we put the data in the array otherwise we put generic message "data not available"

    if ($trafficAmountVar !=null )   
       $merge_data[0]=array('trafficAmount'=>$trafficAmountVar[0]->trafficAmount);
    else 
        $merge_data[0]=array('trafficAmount'=>trans('messages.no data available'));
    if($avgTimeVar !=null) 
      $merge_data[1]=array('avgWaitingTime'=>$avgTimeVar[0]->avgWaitTime,'queueLength'=>$avgTimeVar[0]->queueLength,'vehicleCount'=>$avgTimeVar[0]->vehicleCount);
    else  $merge_data[1]=array('avgWaitingTime'=>trans('messages.no data available'), 'queueLength'=>trans('messages.no data available'), 'vehicleCount'=> trans('messages.no data available'));
        return $merge_data;
    }

    //----Getting the data for the lean more feature by querying the API 7 times to get the data for the 7 previous days.
    //--- the arguments for this function are chosen by the user, He choses a marker on the map and a date and time from datetimepicker, and that information is sent to back end.


//---- this is to handle the traffic amount query
    public function toDataFunctionAmount($device,$detector,$date,$time) {

        $day = -(strtotime(date('Y-m-d'))-strtotime($date))/86400;
        $merge_data1 = array();

        for($x=0;$x<=6;$x++){
            $date = date('Y-m-d',strtotime($day.'day'));
            $ch1 = curl_init();
            curl_setopt($ch1, CURLOPT_URL, 'http://193.185.142.46/TrafficlightdataService/rest/get-traffic-amount?device='.$device.'&detector='.$detector.'&date='.$date.'&time='.$time.'&historyMinutes=1');
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch1, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
            $trafficAmountQuery = curl_exec($ch1);
            curl_close($ch1);
            $trafficAmountJsonData=json_decode($trafficAmountQuery);
            $trafficAmountVar= $trafficAmountJsonData->results;
            if ($trafficAmountVar !=null )    $merge_data1[$x]=array('trafficAmount'=>$trafficAmountVar[0]->trafficAmount);
            else $merge_data1[$x]=array('trafficAmount'=>0);
            $merge_data1[$x+7]= $date;
            $day = $day - 1;
        }

        return $merge_data1;
    }



    //-- this is for handling average waiting time query
    public function toDataFunctionTime($device,$detector,$date,$time) {

        $day = -(strtotime(date('Y-m-d'))-strtotime($date))/86400;
        $merge_data1 = array();

        for($x=0;$x<=6;$x++){
            $date = date('Y-m-d',strtotime($day.'day'));
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://193.185.142.46/TrafficlightdataService/rest/get-traffic-queue-length-and-wait-time?device='.$device.'&detector='.$detector.'&date='.$date.'&time='.$time.'&historyMinutes=1');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
            $avgTimeQuery = curl_exec($ch);
            curl_close($ch);
            $avgTimeJsonData=json_decode($avgTimeQuery);
            $avgTimeVar=$avgTimeJsonData->results;
            if($avgTimeVar !=null) {
                $merge_data1[$x]=array('avgWaitingTime'=>$avgTimeVar[0]->avgWaitTime);
                $merge_data1[$x+14]= array('queueLength'=>$avgTimeVar[0]->queueLength);
                $merge_data1[$x+21]= array('vehicleCount'=>$avgTimeVar[0]->vehicleCount);
            }
            else  {
                $merge_data1[$x]=array('avgWaitingTime'=>0);
                $merge_data1[$x+14]= array('queueLength'=>0);
                $merge_data1[$x+21]= array('vehicleCount'=>0);
            }
            $merge_data1[$x+7]= $date;

            $day = $day - 1;
        }

        return $merge_data1;
    }



    public function toStats()
    {
        $locale = Cookie::get('lang');
        app() -> setLocale($locale);
        return view('stats');
    }


    public function setEnglishLang(){
        $lang = Cookie::forever('lang','en');
        return back() -> withCookie($lang);
    }
    public function setFinnishLang(){
        $lang = Cookie::forever('lang','fi');
        return back() -> withCookie($lang);
    }
    public function setFrenchLang(){
        $lang = Cookie::forever('lang','fr');
        return back() -> withCookie($lang);
    }
}
