@extends('errors::illustrated-ea-layout')

@section('code', '401')
@section('title', __('Ongeautoriseerd'))

@section('image')
<div style="background-image: url({{ asset('/svg/403.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection

@section('message', __('Sorry, je bent niet geautoriseerd om deze pagina te bezoeken.'))
