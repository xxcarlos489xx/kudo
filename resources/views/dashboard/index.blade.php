@extends('layouts.dashboard')

@section('title','Dashboard')

@section('content')
    <div id="app">
        <nav-bar :user="{{$auth}}"></nav-bar>
        <router-view :users="{{$users}}" :reglas="{{$reglas}}"></router-view>
        <footer-dash></footer-dash>
    </div>
    @push('scripts')
        <script src="{{ asset('assets/js/dashboard/index.js')}}"></script>
    @endpush
@endsection
