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

    <section class="content-header">
      <h1>
        Chart
        <small>Average Order</small>
      </h1>
    </section>

    <section class="content">
    	<div style="width:1000px">
    		<canvas id="chart"></canvas>
    	</div>
      <br>
    	<br>
    	Chart Date Range:
      <input type="date" id="start_date" value="{{ $startDate }}">
      to
      <input type="date" id="end_date" value="{{ $endDate }}">
    	<button id="update">update</button>
    </section>

  </div>
@endsection

@section('extra-js')
  <script>
    var url = "{{ route('admin.data.order', ['startDate' => $startDate, 'endDate' => $endDate]) }}";
    var date = new Array();
    var label = new Array();
    var value = new Array();
    var chart;
    $(document).ready(function(){
      $.get(url, function(response){
        response.forEach(function(data){
            date.push(data[0]);
            label.push(data.nama);
            value.push(data[1]);
        });
        var ctx = document.getElementById('chart').getContext('2d');
        ctx.canvas.width = 1000;
        ctx.canvas.height = 300;

        var color = Chart.helpers.color;
        var cfg = {
          type: 'bar',
          data: {
            labels: date,
            datasets: [{
              label: 'Average Order',
              backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
              borderColor: window.chartColors.red,
              data: value,
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
                distribution: 'series',
                ticks: {
                  source: 'data',
                  autoSkip: true
                }
              }],
              yAxes: [{
                ticks: {
                  callback: function(value, index, values) {
                    if(parseInt(value) >= 1000){
                      return 'Rp' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    } else {
                      return 'Rp' + value;
                    }
                  }
                },
                scaleLabel: {
                  display: true,
                  labelString: 'Average Order (in Rupiah)'
                }
              }]
            },
            tooltips: {
              intersect: false,
              mode: 'index',
              callbacks: {
                beginAtZero: true,
                label: function(tooltipItem, myData) {
                  var label = myData.datasets[tooltipItem.datasetIndex].label || '';
                  if (label) {
                    label += ': ';
                  }
                  label += 'Rp' + tooltipItem.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                  return label;
                }
              }
            }
          }
        };

        chart = new Chart(ctx, cfg);
      });
    });

    document.getElementById('update').addEventListener('click', function() {
      var start_date = document.getElementById('start_date').value;
      var end_date = document.getElementById('end_date').value;
      var url = "{{ route('admin.data.order', ['startDate' => ':startDate', 'endDate' => ':endDate']) }}";
      url = url.replace(':startDate', start_date);
      url = url.replace(':endDate', end_date);
      var date = new Array();
      var label = new Array();
      var value = new Array();
      $.get(url, function(response){
        response.forEach(function(data){
            date.push(data[0]);
            label.push(data.nama);
            value.push(data[1]);
        });
      chart.config.data.labels = date;
      chart.config.data.datasets[0].data = value;
      chart.update();
      });
    });
  </script>
@endsection
