@extends('layouts.admin-app')

@section('content')

    <div class="container-fluid admin">
        <h1 class="text-center pt-3">Rubrieken</h1>

        <div class="content">
            <div id="category-container-parent-admin">
                <div class="row category-container">
                    @php(print($categoryMenuHTML))
                </div>
            </div>
        </div>
    </div>

@endsection
