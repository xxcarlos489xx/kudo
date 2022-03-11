@extends('layouts.dashboard')

@section('title','Dashboard')

@section('content')
    <div id="app">
        <nav-bar :user="{{$auth}}"></nav-bar>
        <router-view :auth="{{$auth}}" :users="{{$users}}" :reglas="{{$reglas}}"></router-view>
        <footer-dash></footer-dash>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/js/dashboard/index.js')}}"></script>
    @endpush
@endsection
