@extends('errors::illustrated-ea-layout')

@section('code', '500')
@section('title', __('Server error'))

@section('image')
<div style="background-image: url({{ asset('/svg/500.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection

@section('message', __('Oops, er ging iets fout op onze servers.'))
