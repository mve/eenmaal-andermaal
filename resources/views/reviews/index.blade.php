@extends('layouts.app')

@section('content')

<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Review</th>
                <th scope="col">Van</th>
                <th scope="col">Over</th>
                <th scope="col">Om</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                @foreach($data as $review)
                <td>
                    <div>
                        @for($i = 0; $i < 5; $i++) @if($i < $review['rating']) <i class="fas fa-star" style="color: #FCD34D;"></i>
                            @else
                            <i class="fas fa-star" style="color: #E5E7EB;"></i>
                            @endif
                            @endfor
                    </div>
                    <div>
                        {{$review['comment']}}
                    </div>
                </td>
                <td>
                    {{$review['first_name'] . " " . $review['last_name']}}
                </td>
                <td>
                    <a href="/auctions/{{$review['auction_id']}}">{{$review['auction_title']}}</a>
                </td>
                <td>
                    @php
                    $date = \Carbon\Carbon::create($review['created_at']);
                    echo $date->format('d-m-Y H:i');
                    @endphp
                </td>
                @endforeach
            </tr>
        </tbody>
    </table>
</div>

@endsection