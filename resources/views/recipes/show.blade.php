@extends('layouts.app')

@section('content')


<div class="container mt-5" id="app">
    <main-show :recipe="{{ $recipe }}" :user="{{ Auth::user() ? Auth::user() : "'guest'"}}"></main-show>
</div>

@include('includes.footer') 

@endsection