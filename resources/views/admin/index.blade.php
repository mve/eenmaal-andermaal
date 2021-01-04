@extends('layouts.admin-app')

@section('content')

    <div class="admin">
        <div class="container-fluid ">
            <h1 class="text-center pt-3"> Eenmaal andermaal</h1>

            <div class="content">
                <h1>Dashboard</h1>

                <div class="row">

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">

                                <canvas id="myChart"></canvas>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem eveniet itaque
                                    quod.
                                    Adipisci
                                    aspernatur culpa distinctio eaque eius eligendi excepturi illum molestias neque
                                    omnis
                                    quae,
                                    ratione
                                    repellendus veniam voluptate, voluptatum!
                                </p>

                                <div class="btn btn-outline-secondary">Action <i class="fas fa-arrow-right"></i></div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'My First dataset',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [0, 10, 5, 2, 20, 30, 45]
                }]
            },

            // Configuration options go here
            options: {}
        });
    </script>

@endsection
