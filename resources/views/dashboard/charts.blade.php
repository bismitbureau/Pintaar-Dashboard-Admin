@extends('layout/dashboard/base')

@section('title', 'Chart')

@section('extra-fonts')

@endsection

@section('prerender-js')
  <script src="{{ asset('lib/AdminLTE-2.4.18/bower_components/moment/min/moment.min.js') }}"></script>
  <script src="{{ asset('lib/Chart.js-2.8.0/dist/Chart.min.js') }}"></script>
  <script src="{{ asset('lib/Chart.js-2.8.0/samples/utils.js') }}"></script>
@endsection

@section('extra-css')
  <style>
    canvas {
      -moz-user-select: none;
      -webkit-user-select: none;
      -ms-user-select: none;
    }
  </style>
@endsection

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
  	<div style="width:1000px">
  		<canvas id="chart1"></canvas>
  	</div>
  	<br>
  	<br>
  	Chart Type:
  	<select id="type">
  		<option value="line">Line</option>
  		<option value="bar">Bar</option>
  	</select>
  	<button id="update">update</button>
  </section>
  </div>
@endsection

@section('extra-js')
  <script>
    function randomNumber(min, max) {
      return Math.random() * (max - min) + min;
    }

    function randomBar(date, lastClose) {
      var open = randomNumber(lastClose * 0.95, lastClose * 1.05).toFixed(2);
      var close = randomNumber(open * 0.95, open * 1.05).toFixed(2);
      return {
        t: date.valueOf(),
        y: close
      };
    }

    var dateFormat = 'MMMM DD YYYY';
    var date = moment('April 01 2017', dateFormat);
    var data = [randomBar(date, 30)];
    while (data.length < 60) {
      date = date.clone().add(1, 'd');
      if (date.isoWeekday() <= 5) {
        data.push(randomBar(date, data[data.length - 1].y));
      }
    }

    var ctx = document.getElementById('chart1').getContext('2d');
    ctx.canvas.width = 1000;
    ctx.canvas.height = 300;

    var color = Chart.helpers.color;
    var cfg = {
      type: 'bar',
      data: {
        datasets: [{
          label: 'CHRT - Chart.js Corporation',
          backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
          borderColor: window.chartColors.red,
          data: data,
          type: 'line',
          pointRadius: 0,
          fill: false,
          lineTension: 0,
          borderWidth: 2
        }]
      },
      options: {
        scales: {
          xAxes: [{
            type: 'time',
            distribution: 'series',
            ticks: {
              source: 'data',
              autoSkip: true
            }
          }],
          yAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Closing price ($)'
            }
          }]
        },
        tooltips: {
          intersect: false,
          mode: 'index',
          callbacks: {
            label: function(tooltipItem, myData) {
              var label = myData.datasets[tooltipItem.datasetIndex].label || '';
              if (label) {
                label += ': ';
              }
              label += parseFloat(tooltipItem.value).toFixed(2);
              return label;
            }
          }
        }
      }
    };

    var chart = new Chart(ctx, cfg);

    document.getElementById('update').addEventListener('click', function() {
      var type = document.getElementById('type').value;
      chart.config.data.datasets[0].type = type;
      chart.update();
    });

  </script>
@endsection
