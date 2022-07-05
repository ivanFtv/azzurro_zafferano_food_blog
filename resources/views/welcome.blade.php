@extends('layouts.app')

@section('content')

    <section id="header">
        <div class="hero-section d-flex justify-content-center align-items-center">
           <img src="images/hero_image.png" style="width: 100%; height:auto;" alt="">
        </div>
        <div class="recipes-categories d-flex justify-content-center align-items-center bg-white">
            <ul class="my-1">
                <a href="{{ route('showByFilter', 'Antipasti') }}"><li class="overOrange overBorder">Antipasti</li></a>
                <a href="{{ route('showByFilter', 'Primi Piatti') }}"><li class="overOrange overBorder">Primi</li></a>
                <a href="{{ route('showByFilter', 'Secondi Piatti') }}"><li class="overOrange overBorder">Secondi</li></a>
                <a href="{{ route('showByFilter', 'Dolci') }}"><li class="overOrange overBorder">Dolci</li></a>
                <a href="{{ route('showByFilter', 'Piatti Veloci') }}"><li class="overOrange overBorder">Ricette Veloci</li></a>
            </ul>
        </div>
    </section>
    <section id="main-section">
        <div class="container">
            <div class="container first pb-4 pt-4">
                <div class="row py-2 paddingYhome">
                    <h2 class="font-montserrat text-uppercase">Ho voglia di</h2>
                    <hr class="ms-2" style="border: 2px solid orange; width:60px; border-radius: 20px; opacity:1;">
                </div>
                <div class="row margin-start-home">
                    <div class="col-6 col-md-3">
                        <h3 class="fw-bold" style="color:rgb(11, 56, 105);">Antipasti</h3>
                        <ul class="home-categories-list">
                            <a href="#"><li class="overOrange">Antipasti di pasta</li></a>
                            <a href="#"><li class="overOrange">Antipasti di pesce</li></a>
                            <a href="#"><li class="overOrange">Antipasti di carne</li></a>
                            <a href="#"><li class="overOrange">Antipasti veloci</li></a>
                            <a href="#"><li class="overOrange">Fritti</li></a>
                        </ul>
                    </div>
                    <div class="col-6 col-md-3">
                        <h3 class="fw-bold" style="color:rgb(11, 56, 105);">Primi</h3>
                        <ul class="home-categories-list">
                            <a href="#"><li class="overOrange">Paste al pomodoro</li></a>
                            <a href="#"><li class="overOrange">Paste in bianco</li></a>
                            <a href="#"><li class="overOrange">Gnocchi</li></a>
                            <a href="#"><li class="overOrange">Sfoglie ripiene</li></a>
                            <a href="#"><li class="overOrange">Torte salate</li></a>
                        </ul>
                    </div>
                    <div class="col-6 col-md-3">
                        <h3 class="fw-bold" style="color:rgb(11, 56, 105);">Secondi</h3>
                        <ul class="home-categories-list">
                            <a href="#"><li class="overOrange">Secondi di carne</li></a>
                            <a href="#"><li class="overOrange">Secondi di pesce</li></a>
                            <a href="#"><li class="overOrange">Verdure al vapore</li></a>
                            <a href="#"><li class="overOrange">Verdure alla griglia</li></a>
                            <a href="#"><li class="overOrange">Speciali orientali</li></a>
                        </ul>
                    </div>
                    <div class="col-6 col-md-3">
                        <h3 class="fw-bold" style="color:rgb(11, 56, 105);">Dolci</h3>
                        <ul class="home-categories-list">
                            <a href="#"><li class="overOrange">Torte</li></a>
                            <a href="#"><li class="overOrange">Gelati</li></a>
                            <a href="#"><li class="overOrange">Semifreddi</li></a>
                            <a href="#"><li class="overOrange">Sorbetti</li></a>
                            <a href="#"><li class="overOrange">Biscotti e pasticcini</li></a>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="app" class="second-section">
            <articles-main 
                :title="'I nostri primi piatti'" 
                :category="'Primi Piatti'" 
                :direction="'orizontal'"
                :user="{{ Auth::user() ? Auth::user() : "'guest'"}}"></articles-main>

            <articles-main 
                :title="'I nostri secondi piatti'" 
                :category="'Secondi Piatti'" 
                :direction="'orizontal'"
                :user="{{ Auth::user() ? Auth::user() : "'guest'"}}"></articles-main>

            <articles-main 
                :title="'Dolci'" 
                :category="'Dolci'" 
                :direction="'orizontal'"
                :user="{{ Auth::user() ? Auth::user() : "'guest'"}}"></articles-main>

            <articles-main 
                :title="'Ricette Veloci'" 
                :category="'Ricette Veloci'" 
                :direction="'orizontal'"
                :user="{{ Auth::user() ? Auth::user() : "'guest'"}}"></articles-main>

            <articles-main-api :title="'E per finire .. Drinks (dai nostri partners)'"></articles-main-api>
        </div>
    </section>
@include('includes.footer')

@endsection