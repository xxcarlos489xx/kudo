@extends('layouts.dashboard')

@section('title','Dashboard')

@section('content')
    <div id="app">
        <nav-bar></nav-bar>
        {{-- <div class="container"> --}}
            <router-view></router-view>
        {{-- </div> --}}
    </div>
    @push('scripts')
        <script src="{{ asset('assets/js/dashboard/index.js')}}"></script>
    @endpush
@endsection
