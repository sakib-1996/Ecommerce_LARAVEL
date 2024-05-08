@extends('frontend.layouts.app')
@section('content')
    @include('frontend.component.MenuBar')
    @include('frontend.component.PaymentMethodList')
    @include('frontend.component.check-out')
    @include('frontend.component.Footer')
@endsection
