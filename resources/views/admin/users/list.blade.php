@extends('layouts.admin-app')

@section('content')
<div class="admin">
    <div class="container-fluid ">
        <h1 class="text-center pt-3">Gebruikers</h1>

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
                    @foreach($users as $user)
                        <tr onclick="window.location.assign('{{route('admin.users.view', $user->id)}}')">
                            <td>{{$user->username}}</td>
                            <td>{{$user->email}}</td>
                            <td>@if ($user->first_name === $user->last_name)
                                    {{$user->first_name}}
                                @else
                                    {{$user->first_name}} {{$user->last_name}}
                                @endif</td>
                            <td>{{$user->country_code}}</td>
                            <td>
                                @if($user->is_seller == 1)
                                    <i class="fas fa-check-circle"></i>
                                @endif
                            </td>
                            <td class="endTd">
                                @if($user->is_blocked == 1)
                                    <i class="fas fa-ban"></i>
                                @endif</td>
                            <td>{{$user->Active}}</td>
                            <td>{{$user->AllCnt}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @include("includes.pagination", $paginationData)

    </div>
</div>

@endsection
