@extends('frontend.layouts.app')
@section('cutom_css')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endsection
@section('content')
    @include('frontend.component.MenuBar')
    @include('frontend.component.contact')

    @include('frontend.component.Footer')
@endsection
