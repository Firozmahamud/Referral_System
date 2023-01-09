
@extends('layouts.dashboardLayout')

@section('content')

 <h1 >ReferralTrack</h1>

{{--<canvas id="myChart"></canvas> --}}

<div class="row">
    <div class="col-xl-9">
        <div class="card mb-5">
            <div class="card-header">
                <i class="fas fa-chart-area me-1"></i>
                Monthly ReferralTrack Chart
            </div>
            <div class="card-body">
                <canvas id="myChart" width="100%" height="40"></canvas></div>
        </div>
    </div>


<script type="text/javascript">

 var dateLabels = JSON.parse(@json($dateLabels));
 var dateData = JSON.parse(@json($dateData));


    var canvas = document.getElementById('myChart');
    var data = {
        // labels: ["January", "February", "March", "April", "May", "June", "July"],
        labels: dateLabels,
        datasets: [
            {
                label: "Referral User",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "rgba(75,192,192,1)",
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 5,
                pointHitRadius: 10,
                // data: [65, 59, 80, 0, 56, 55, 40],
                data: dateData,
            }
        ]
    };

    var option = {
      showLines: true
    };
    var myLineChart = Chart.Line(canvas,{
      data:data,
      options:option
    });

    </script>

    <style>
        #myChart{
            width: 100% !important;
            height: 50%;
        }
    </style>

@endsection
