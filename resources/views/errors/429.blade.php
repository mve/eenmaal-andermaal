@extends('errors::illustrated-ea-layout')

@section('code', '429')
@section('title', __('Te veel verzoeken'))

@section('image')
<div style="background-image: url({{ asset('/svg/403.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection

@section('message', __('Sorry, je stuurt te veel verzoeken naar onze servers.'))
