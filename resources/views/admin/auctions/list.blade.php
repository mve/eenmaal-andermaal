@extends('layouts.admin-app')

@section('content')
    <div class="admin">
        <div class="container-fluid ">
            <h1 class="text-center pt-3">Veilingen</h1>

            <div class="content">

                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead">
                        <tr>
                            <th scope="col">Gebruikersnaam</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Naam</th>
                            <th scope="col">Land</th>
                            <th scope="col">Verkoper</th>
                            <th scope="col" class="endTd">Geblokkeerd</th>
                            <th>Actief</th>
                            <th>Totaal</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
