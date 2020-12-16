@extends('layouts.admin-app')

@section('content')

    <div class="container-fluid admin"
         style="padding-left: 290px; padding-top: 40px; background-color: #353535; height: 100vh;">

        <h1>{{ $user->username }}</h1>
        <div class="row">
            <div class="col-lg-4 text-center">
                <h2 class="text-center">Veilingen</h2>
                <div class="card">
                    <div class="card-body">
                        <p>Actief</p>
                        <h1>5</h1>
                        <p>Totaal</p>
                        <h1>13</h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <h2>Biedingen</h2>
                <div class="card">
                    <div class="card-body">
                        <p>Actief</p>
                        <h1>5</h1>
                        <p>Totaal</p>
                        <h1>13</h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <h2>Informatie</h2>
                <div class="card text-left">
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Mark</td>
                                    <td>Mark</td>
                                </tr>
                                <tr>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                </tr>
                                <tr>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
