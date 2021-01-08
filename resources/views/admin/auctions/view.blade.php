@extends('layouts.admin-app')

@section('content')

<div class="container-fluid admin">
    <div class="d-flex justify-content-center align-items-center mb-3">
        <h2 class="text-center">{{$auction->title}}</h2>
        <a href="{{ route('admin.auctions.list') }}" class="back-button btn btn-outline-secondary">Terug</a>
        <button class="btn btn-primary text-light btn-lg ml-4" name="show_auction" onclick="window.location.assign('{{route('auctions.show', $auction->id)}}')">Open veiling</button>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <!-- CAROUSEL SLIDER -->
            <div id="carouselExampleIndicators" class="carousel slide " data-ride="carousel">
                <ol class="carousel-indicators">
                    @for($i = 0; $i < count($auctionImages); $i++) <li data-target="#carouselExampleIndicators" @if($i==0) class="active" @endif data-slide-to="{{$i}}">
                        </li>
                        @endfor
                </ol>
                <div class="carousel-inner">
                    @for($i = 0; $i < count($auctionImages); $i++) <div class="carousel-item @if($i==0) active @endif">
                        <img src='{{$auctionImages[$i]["file_name"]}}' class="d-block" alt="..."></div>
                @endfor
            </div>
            @if(count($auctionImages) > 1)
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
            @endif
            <!-- END OF CAROUSEL SLIDER -->
        </div>
    </div>
    <div class="col-lg text-center">
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
                                            <div class="col text-left">Verkoper</div>
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
                                        <div class="row mt-4">
                                            <div class="col text-left">Startdatum</div>
                                            <div class="col text-right">{{date('d-m-Y', strtotime($auction->created_at))}}</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col text-left">Looptijd</div>
                                            <div class="col text-right">{{$auction->duration}} dagen</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col text-left">Einddatum</div>
                                            <div class="col text-right">{{date('d-m-Y', strtotime($auction->end_datetime))}}</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row mt-4">
                                            <div class="col text-left">Startprijs</div>
                                            <div class="col text-right">€ {{number_format($auction->start_price)}}</div>
                                        </div>
                                    </td>
                                </tr>
                                @if ($bids)
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col text-left">Aantal biedingen</div>
                                            <div class="col text-right">{{$bids->count}}</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col text-left">Huidig bedrag</div>
                                            <div class="col text-right">€ {{$bids->amount}}</div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="row mt-3">
                            <div class="col text-right">
                                <button class="btn btn-primary text-light btn-lg" name="show_profile" onclick="window.location.assign('{{route('admin.users.view', $auction->user_id)}}')">Zie verkoper</button>
                            </div>
                            <div class="col text-center">
                                <form method="post" action="{{route('admin.auctions.edit', $auction->id)}}">
                                    @csrf
                                    <button class="btn btn-warning btn-lg" type="submit" name="edit">Bewerken</button>
                                </form>
                            </div>
                            <div class="col text-left">
                                <form method="post">
                                    @csrf
                                    @if ($auction->is_blocked)
                                    <button class="btn btn-success btn-lg" type="submit" name="unblock" onclick="return confirm('Weet u zeker dat u deze veiling wilt deblokkeren?')">Deblokkeren</button>
                                    @else
                                    <button class="btn btn-danger text-light btn-lg" type="submit" name="block" onclick="return confirm('Weet u zeker dat u deze veiling wilt blokkeren?')">Blokkeren</button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 offset-lg-1">
        <div class="my-4">
            <h4>Omschrijving</h4>
            <p>{!! nl2br($auction->description) !!}</p>
            <h4>Gegevens</h4>
            <p>
                Land: {{$auction->getCountry()}}<br />
                Plaats: {{$auction->city}}
                @foreach($auction->getSeller()->getPhoneNumbers() as $phoneNumber)
                <br />Telefoonnummer: {{$phoneNumber["phone_number"]}}<br />
                @endforeach
            </p>
            <h4>Betaling</h4>
            <p>
                @if($auction->payment_instruction!==null && !empty($auction->payment_instruction))
                Betalingsinstructies:<br />
                {{$auction->payment_instruction}}<br /><br />
                @endif
                De verkoper accepteert de volgende betalingsmethoden:<br />
            <ul>
                @foreach($auction->getPaymentMethods() as $paymentMethod)
                <li>{{$paymentMethod["method"]}}</li>
                @endforeach
            </ul>
            </p>
            <h4>Verzending</h4>
            <p>
                De verkoper accepteert de volgende verzendmethoden:<br />
            <ul>
                @foreach($auction->getShippingMethods() as $shippingMethod)
                <li>{{$shippingMethod["method"]}}: &euro;{{$shippingMethod["price"]}}</li>
                @endforeach
            </ul>
            </p>
        </div>
    </div>
</div>
</div>

@endsection
