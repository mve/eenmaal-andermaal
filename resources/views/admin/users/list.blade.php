@extends('layouts.admin-app')

@section('content')

    <div class="container-fluid admin">
        <h1 class="text-center pt-3">Gebruikers</h1>

        <div class="content">
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead">
                    <tr>
                        <th scope="col">Gebruikersnaam</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Naam</th>
                        <th scope="col" class="endTd">Verkoper</th>
                        <th>Actief</th>
                        <th>Totaal</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($users as $user)

                        <tr>

                            <td>{{$user->username}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->first_name}} {{$user->last_name}}</td>
                            <td class="endTd">{{$user->is_seller}}</td>

                        </tr>
                    @endforeach
                    <tr>
                        <td>1</td>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td class="endTd">@mdo</td>
                        <td>8</td>
                        <td>29</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td class="endTd">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" disabled>
                            </div>
                        </td>
                        <td>8</td>
                        <td>29</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td class="endTd">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" disabled checked>
                            </div>
                        </td>
                        <td>8</td>
                        <td>29</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
