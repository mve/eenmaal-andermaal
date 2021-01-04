@extends('layouts.admin-app')

@section('content')

    <div class="admin">
        <div class="container-fluid ">
            <h1 class="text-center pt-3"> Eenmaal andermaal</h1>

            <div class="content">
                <h1>Statistieken</h1>

                <div class="row">

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">

                                <canvas id="logChart"></canvas>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">

                                <canvas id="totalChart"></canvas>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        var ctx = document.getElementById('logChart').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
                labels: {!! json_encode(array_values($labels)) !!},
                datasets:[
                        @foreach($datasets as $dataset)
                    {
                        label: '{{$dataset["label"]}}',
                        fill: false,
                        borderColor: '{{$dataset["borderColor"]}}',
                        borderWidth:'2',
                        data: {!! json_encode($dataset["data"]) !!}
                    },
                    @endforeach
                ]
            },

            // Configuration options go here
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                title: {
                    display: true,
                    text: 'Gecategoriseerde errors'
                },
            }
        });

        var totalCtx = document.getElementById('totalChart').getContext('2d');
        var totalChart = new Chart(totalCtx, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
                labels: {!! json_encode(array_values($labels)) !!},
                datasets:[{
                        label: 'Errors',
                        fill: true,
                        backgroundColor: '#c5AE91',
                        borderColor: '#616161',
                        borderWidth:'2',
                        data: {!! json_encode($total) !!}
                    }]
            },

            // Configuration options go here
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                title: {
                    display: true,
                    text: 'Totale aantal errors'
                },
            }
        });
    </script>

@endsection
