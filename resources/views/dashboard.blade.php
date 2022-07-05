@extends('layouts.app')

@section('content')
    <div class="container mt-5" id="app">
        <main-profile :user="{{ Auth::user() }}"></main-profile>
    </div>
@endsection
