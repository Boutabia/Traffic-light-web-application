
@extends('master')

@section('title')
{{ trans('messages.title') }}
@endsection

@section('langmenu')
    @parent
@endsection

@section('heading')
    <h2>{{ trans('messages.heading') }}
        <small> - {{ trans('messages.statistics') }}</small></h2>
@endsection

@section('navbar')
    <ul class="nav nav-pills">
        <li><a href="/index">{{ trans('messages.live') }}</a></li>
        <li><a href="/history">{{ trans('messages.history') }}</a></li>
    <!--  <li class="active"><a href="/stats">{{ trans('messages.statistics') }}</a></li> -->
    </ul>
@endsection

@section('content')

  <script type="text/javascript" src="js/chart.js"></script>

  <div class="row">
      <div class="col-xs-offset-1 col-xs-10">
          <p>{{ trans('messages.chartHeading') }}
              <script type="text/javascript">
                  function getQueryString(name) {
                      var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
                      var r = window.location.search.substr(1).match(reg);
                      if (r != null) return unescape(r[2]); return null;
                  }
                  var time = getQueryString("time");
                  document.write(time)
              </script></p>
      </div>
      <div class="col-xs-offset-1 col-xs-10">
          <h4>{{ trans('messages.statsAmount') }}</h4>
          <canvas id="amount" style="width:100%;height:250px"></canvas>
      </div>
      <div class="col-xs-offset-1 col-xs-10">
          <h4>{{ trans('messages.statsTime') }}</h4>
          <canvas id="time" style="width:100%;height:250px"></canvas>
      </div>
      <div class="col-xs-offset-1 col-xs-10">
          <h4>{{ trans('messages.statsQueue') }}</h4>
          <canvas id="queue" style="width:100%;height:250px"></canvas>
      </div>
      <div class="col-xs-offset-1 col-xs-10">
          <h4>{{ trans('messages.statsCount') }}</h4>
          <canvas id="count" style="width:100%;height:250px"></canvas>
      </div>
  </div>
  <script type="text/javascript">
      function getQueryString(name) {
          var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
          var r = window.location.search.substr(1).match(reg);
          if (r != null) return unescape(r[2]); return null;
      }
      var date = getQueryString("date"),
          time = getQueryString("time"),
          device = getQueryString("device"),
          detector = getQueryString("detector");
      var request=$.get('/dataFunctionAmount/'+device+'/'+ detector+'/'+date+'/'+time);
      request.done(function(response) {
         var amount1 =  response[0].trafficAmount;
         var amount2 =  response[1].trafficAmount;
          var amount3 =  response[2].trafficAmount;
          var amount4 =  response[3].trafficAmount;
          var amount5 =  response[4].trafficAmount;
          var amount6 =  response[5].trafficAmount;
          var amount7 =  response[6].trafficAmount;
         var date1 = response[7];
         var date2 = response[8];
          var date3 = response[9];
          var date4 = response[10];
          var date5 = response[11];
          var date6 = response[12];
          var date7 = response[13];
          var amount = document.getElementById('amount').getContext('2d');
          var lineChart = new Chart(amount);
          var data = {
              labels : [date7,date6,date5,date4,date3,date2,date1],
              datasets : [
                  {
                      fillColor : "rgba(220,220,220,0.5)",
                      strokeColor : "rgba(220,220,220,1)",
                      pointColor : "rgba(220,220,220,1)",
                      pointStrokeColor : "#fff",
                      data : [amount7,amount6,amount5,amount4,amount3,amount2,amount1]
                  }

              ]
          }
          lineChart.Line(data);
      });

      var request=$.get('/dataFunctionTime/'+device+'/'+ detector+'/'+date+'/'+time);
      request.done(function(response) {
          var waiting1 =  response[0].avgWaitingTime;
          var waiting2 =  response[1].avgWaitingTime;
          var waiting3 =  response[2].avgWaitingTime;
          var waiting4 =  response[3].avgWaitingTime;
          var waiting5 =  response[4].avgWaitingTime;
          var waiting6 =  response[5].avgWaitingTime;
          var waiting7 =  response[6].avgWaitingTime;
          var date1 = response[7];
          var date2 = response[8];
          var date3 = response[9];
          var date4 = response[10];
          var date5 = response[11];
          var date6 = response[12];
          var date7 = response[13];
          var queue1 = response[14].queueLength;
          var queue2 = response[15].queueLength;
          var queue3 = response[16].queueLength;
          var queue4 = response[17].queueLength;
          var queue5 = response[18].queueLength;
          var queue6 = response[19].queueLength;
          var queue7 = response[20].queueLength;
          var count1 = response[21].vehicleCount;
          var count2 = response[22].vehicleCount;
          var count3 = response[23].vehicleCount;
          var count4 = response[24].vehicleCount;
          var count5 = response[25].vehicleCount;
          var count6 = response[26].vehicleCount;
          var count7 = response[27].vehicleCount;

          var time = document.getElementById('time').getContext('2d');
          var lineChart = new Chart(time);
          var data = {
              labels : [date7,date6,date5,date4,date3,date2,date1],
              datasets : [

                  {
                      fillColor : "rgba(151,187,205,0.5)",
                      strokeColor : "rgba(151,187,205,1)",
                      pointColor : "rgba(151,187,205,1)",
                      pointStrokeColor : "#fff",
                      data : [waiting7,waiting6,waiting5,waiting4,waiting3,waiting2,waiting1]
                  }
              ]
          }
          lineChart.Line(data);

          var queue = document.getElementById('queue').getContext('2d');
          var lineChart2 = new Chart(queue);
          var data2 = {
              labels : [date7,date6,date5,date4,date3,date2,date1],
              datasets : [

                  {
                      fillColor : "rgba(255, 0, 0, 0.4)",
                      strokeColor : "rgba(255, 0, 0, 0.6)",
                      pointColor : "rgba(255, 0, 0, 0.6)",
                      pointStrokeColor : "#fff",
                      data : [queue7,queue6,queue5,queue4,queue3,queue2,queue1]
                  }
              ]
          }
          lineChart2.Line(data2);

          var count = document.getElementById('count').getContext('2d');
          var lineChart3 = new Chart(count);
          var data3 = {
              labels : [date7,date6,date5,date4,date3,date2,date1],
              datasets : [

                  {
                      fillColor : "rgba(0,238,118,0.5)",
                      strokeColor : "rgba(0,238,118,1)",
                      pointColor : "rgba(0,238,118,1)",
                      pointStrokeColor : "#fff",
                      data : [count7,count6,count5,count4,count3,count2,count1]
                  }
              ]
          }
          lineChart3.Line(data3);
      });



  </script>

@endsection
