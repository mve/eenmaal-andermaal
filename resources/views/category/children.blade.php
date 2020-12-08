@extends('layouts.app')

@section('content')
    <div class="mb-4"></div>

    {{\App\Breadcrumbs::createAndPrint($category, 5)}}

    <div class="container">

        <h2>{{$category->name}}</h2>

        <div class="row py-4">

            <div class="col-md-12 row">
                @foreach($children as $child)
                    <a href="{{route("auctionsInCategory",$child->id)}}" class="col-lg-4 col-md-6 mb-4 no-link">
                        <div class="auction-card hover-effect">
                            <div class="auction-card-body">
                                <h4 class="mb-0">{{$child->name}}</h4>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

        </div>


    </div>



@endsection
