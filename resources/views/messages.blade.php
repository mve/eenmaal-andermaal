@extends('layouts.app')

@section('content')

<div class="sand-blue-gradient">
    <div class="container">
        <div class="row justify-content-center align-items-center py-5" style="height: calc(100vh - 392px); min-height: 450px;">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mt-2 mb-4">Berichten</h2>
                        @if(Session()->has('message'))
                            <div class="alert alert-success">
                                {{ Session()->get('message') }}
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger">
                                {{$errors->first()}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection