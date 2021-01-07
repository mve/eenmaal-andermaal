@extends('errors::illustrated-ea-layout')

@section('code', '403')
@section('title', __('Verboden'))

@section('image')
<div style="background-image: url({{ asset('/svg/403.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection

@section('message', __($exception->getMessage() ?: __('Sorry, je hebt geen toegang tot deze pagina.')))
@section('message', __($exception->getMessage() ?: __('Sorry, you are forbidden from accessing this page.')))
