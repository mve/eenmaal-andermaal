@extends('layouts.admin-app')

@section('content')

    <div class="container-fluid admin">
        <h1 class="text-center pt-3">Rubrieken</h1>

        <form class="ml-auto mr-auto text-center" method="GET" action="{{route('categories.index')}}">
            <input type="text" name="search" class="form-control d-inline" style="width:inherit" placeholder="Zoeken..." value="{{isset($_GET['search']) ? $_GET['search'] : ''}}"/>
            <input type="submit" class="btn btn-sm btn-outline-secondary" value="Zoek"/>
        </form>

        <div class="content">
            <div class="table-responsive">
                <table class="table" style="table-layout: fixed;">
                    <thead class="thead">
                        <tr>
                            <th scope="col">Boven</th>
                            <th scope="col">Rubriek</th>
                            <th scope="col">Onder</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$category->getParentCategory()["name"]}}</td>
                            <td>{{$category->name}}</td>
                            <td class="text-truncate">{{$category->getChildrenCategoriesString()}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @include("includes.pagination", $paginationData)
    </div>

@endsection
