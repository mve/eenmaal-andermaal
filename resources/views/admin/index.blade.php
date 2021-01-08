@extends('layouts.admin-app')

@section('content')

    <div class="admin">
        <div class="container-fluid ">
            <h1 class="text-center pt-3"> EenmaalAndermaal</h1>

            <div class="content">
                <h1>Dashboard</h1>

                <div class="row">

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <canvas id="accountsCreatedChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <canvas id="auctionHitsChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="text-secondary">{{$auctionHitsToday}}</h1>
                                <p>Unieke veiling bezoekers vandaag</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="text-secondary">{{$auctionsTotal['total_auctions']}}</h1>
                                <p>Totaal aantal veiligen</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="text-secondary">{{$bidsTotal['total_bids']}}</h1>
                                <p>Totaal aantal biedingen</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="text-secondary">{{$usersTotal['total_users']}}</h1>
                                <p>Totaal aantal accounts</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        var ctx = document.getElementById('accountsCreatedChart').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
                labels: {!! json_encode($usersCreatedAt) !!},
                datasets: [{
                    label: 'Nieuwe accounts',
                    backgroundColor: '#c5AE91',
                    borderColor: '#616161',
                    borderWidth:'2',
                    data: {!! json_encode($usersCreatedTotal) !!}
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
                }
            }
        });

        var ctx = document.getElementById('auctionHitsChart').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
                labels: {!! json_encode($auctionHitsCreatedAt) !!},
                datasets: [{
                    label: 'Unieke veiling bezoekers',
                    backgroundColor: '#c5AE91',
                    borderColor: '#616161',
                    borderWidth:'2',
                    data: {!! json_encode($auctionHitsTotal) !!}
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
                }
            }
        });
    </script>

@endsection
