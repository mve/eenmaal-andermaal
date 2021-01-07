@extends('errors::illustrated-ea-layout')

@section('code', '419')
@section('title', __('Pagina verlopen'))

@section('image')
<div style="background-image: url({{ asset('/svg/403.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection

@section('message', __('Sorry, je sessie is verlopen. Vernieuw de pagina en probeer het opnieuw.'))
