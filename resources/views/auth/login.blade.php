@extends('layouts.login')

@section('title','Login')

@section('content')
    <div id="app">
        <Login></Login>
    </div>
    @push('scripts')
        <script src="{{ asset('assets/js/auth/index.js')}}"></script>
    @endpush
@endsection
