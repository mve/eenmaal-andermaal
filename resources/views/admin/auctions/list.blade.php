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
                            <th>Titel</th>
                            <th>Plaats</th>
                            <th>Land</th>
                            <th>Verkoper</th>
                            <th>Startprijs</th>
                            <th>Looptijd</th>
                            <th class="endTd">Einddatum</th>
                            <th>Geblokkeerd</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($auctions as $auction)
                        <tr onclick="window.location.assign('{{route('admin.auctions.view', $auction->id)}}')">
                            <td>{{$auction->title}}</td>
                            <td>{{$auction->city}}</td>
                            <td>{{$auction->country_code}}</td>
                            <td>@if ($auction->first_name === $auction->last_name)
                                {{$auction->first_name}}
                                @else
                                {{$auction->first_name}} {{$auction->last_name}}
                                @endif
                            </td>
                            <td>€ {{$auction->start_price}}</td>
                            <td>{{$auction->duration}} dagen</td>
                            <td class="endTd">{{date('d-m-Y', strtotime($auction->end_datetime))}}</td>
                            <td>@if($auction->is_blocked == 1)
                                <i class="fas fa-ban"></i>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection