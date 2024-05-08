@extends('frontend.layouts.app')
@section('content')
    @include('frontend.component.MenuBar')
    @include('frontend.component.ByCategoryList')
    @include('frontend.component.TopBrands')
    @include('frontend.component.Footer')
@endsection
