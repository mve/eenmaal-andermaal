@extends('layouts.admin-app')

@section('content')

<div class="container-fluid admin">

    <h1 class="text-center pt-3">{{ $user->username }}</h1>
    <div class="content">
        <div class="row">
            <div class="col-lg-3 text-center">
                <h2>Veilingen</h2>
                <div class="row rounded-top border-top pt-2 mx-1">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <p>Actief</p>
                                        <h1 class="display-2">{{count($auctions)}}</h1>
                                    </div>
                                    <div class="col">
                                        <p>Totaal</p>
                                        <h1 class="display-2">{{count($auctions + $pastAuctions)}}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <h2>Biedingen</h2>
                <div class="row rounded-top border-top pt-2 mx-1">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <p>Ontvangen</p>
                                    <div class="col">
                                        <h1 class="display-2">€{{number_format($bids->amount_received, 2)}}</h1>
                                    </div>
                                    <div class="col">
                                        <h1 class="display-2">{{$bids->received}}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <p>Geplaatst</p>
                                    <div class="col">
                                        <h1 class="display-2">€{{number_format($bids->amount_placed, 2)}}</h1>
                                    </div>
                                    <div class="col">
                                        <h1 class="display-2">{{$bids->placed}}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 text-center">
                <h2>Informatie</h2>
                <div class="row rounded-top border-top pt-2 mx-1">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="text-left">Naam</td>
                                            @if($user->first_name === $user->last_name)
                                                <td class="text-right">{{$user->last_name}}</td>
                                            @else
                                                <td class="text-right">{{$user->first_name}} {{$user->last_name}}</td>
                                            @endif
                                            
                                        </tr>
                                        <tr>
                                            <td class="text-left">E-mail</td>
                                            <td class="text-right">{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">Geboortedatum</td>
                                            <td class="text-right">{{ $user->birth_date }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">Woonplaats</td>
                                            <td class="text-right">{{ $user->city }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">Land</td>
                                            <td class="text-right">{{ $user->country_code }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">Registratiedatum</td>
                                            <td class="text-right">{{date('d-m-Y', strtotime($user->created_at))}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button class="btn btn-danger text-light btn-lg">Blokkeren</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(count($auctions) > 0)
            <h3>Actieve veilingen</h3>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Titel</th>
                        <th scope="col">Huidig bod</th>
                        <th scope="col">Einddatum</th>
                    </tr>
                </thead>
                    <tbody>
                        @foreach($auctions as $auction)                
                            <tr>
                                <td>{{$auction->title}}</td>
                                <td>{{$auction->amount}}</td>
                                <td>{{$auction->end_datetime}}</td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
        @endif

        @if(count($pastAuctions) > 0)
        <h3>Historie</h3>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Titel</th>
                        <th scope="col">Huidig bod</th>
                        <th scope="col">Einddatum</th>
                    </tr>
                </thead>
                    <tbody>
                        @foreach($auctions as $auction)                
                            <tr>
                                <td>{{$auction->title}}</td>
                                <td>{{$auction->amount}}</td>
                                <td>{{$auction->end_datetime}}</td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

@endsection