@extends('layouts.admin-app')

@section('content')

<div class="container-fluid admin">
    <h1 class="text-center pt-3">{{ $user->username }}</h1>
    <div class="content">
        <div class="row mb-3">
            <div class="col-lg-3 text-center">
                <h2>Veilingen</h2>
                <div class="row rounded-top border-top py-2 mx-1">
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
                                        <h1 class="display-2">{{count($auctions) + count($pastAuctions)}}</h1>
                                    </div>
                                </div>
                                <div class="row">
                                    <p>Bekeken</p>
                                    <div class="col">
                                        <p>Vandaag</p>
                                        <h1 class="display-2">{{$views->today}}</h1>
                                    </div>
                                    <div class="col">
                                        <p>Totaal</p>
                                        <h1 class="display-2">{{$views->total}}</h1>
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
                                        <h1 class="display-1">€{{number_format($bids->amount_received)}}</h1>
                                    </div>
                                    <div class="col">
                                        <h1 class="display-1">{{$bids->received}}</h1>
                                    </div>
                                </div>
                                <div class="row">
                                    <p>Totaal</p>
                                    <div class="col">
                                        <h1 class="display-1">€{{number_format($bids->amount_received_total)}}</h1>
                                    </div>
                                    <div class="col">
                                        <h1 class="display-1">{{$bids->received_total}}</h1>
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
                                        <h1 class="display-1">€{{number_format($bids->amount_placed)}}</h1>
                                    </div>
                                    <div class="col">
                                        <h1 class="display-1">{{$bids->placed}}</h1>
                                    </div>
                                </div>
                                <div class="row">
                                    <p>Totaal</p>
                                    <div class="col">
                                        <h1 class="display-1">€{{number_format($bids->amount_placed_total)}}</h1>
                                    </div>
                                    <div class="col">
                                        <h1 class="display-1">{{$bids->placed_total}}</h1>
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
                                            <td>
                                                <div class="row">
                                                    <div class="col text-left">Naam</div>
                                                    <div class="col text-right">
                                                        @if ($user->first_name === $user->last_name)
                                                        {{$user->first_name}}
                                                        @else
                                                        {{$user->first_name}} {{$user->last_name}}
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col text-left">E-mail</div>
                                                    <div class="col text-right">{{ $user->email }}</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col text-left">Geboortedatum</div>
                                                    <div class="col text-right">{{$user->birth_date}}</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col text-left">Woonplaats</div>
                                                    <div class="col text-right">{{$user->city}}</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col text-left">Land</div>
                                                    <div class="col text-right">{{$user->country_code}}</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col text-left">Registratiedatum</div>
                                                    <div class="col text-right">{{date('d-m-Y', strtotime($user->created_at))}}</div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <form method="post" action="{{route('admin.users.view', $user->id)}}">
                                    @csrf
                                    @if ($user->is_blocked)
                                    <button class="btn btn-success btn-lg" type="submit" name="unblock" onclick="return confirm('Weet u zeker dat u deze gebruiker wilt deblokkeren?')">Deblokkeren</button>
                                    @else
                                    <button class="btn btn-danger text-light btn-lg" type="submit" name="block" onclick="return confirm('Weet u zeker dat u deze gebruiker wilt blokkeren?')">Blokkeren</button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(count($auctions) > 0)
            @include("admin.includes.auctions-table", [
            "title" => "Actieve veilingen",
            "auctions" => $auctions
            ])
        @endif

        @if(count($pastAuctions) > 0)
            @include("admin.includes.auctions-table", [
            "title" => "Historie",
            "auctions" => $pastAuctions
            ])
        @endif
    </div>
</div>

@endsection