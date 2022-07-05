@extends('layouts.app')

@section('content')

<section>
    <div class="container mt-5" id="app">
    <div id="app" class="second-section">
        <articles-main 
            :title="'{{ $key }}'" 
            :category="'{{ $key }}'" 
            :user="{{ Auth::user() ? Auth::user() : "'guest'"}}"></articles-main>
    </div>
</div>
</section>


@include('includes.footer') 

@endsection