<!--
<header>
    <div class="h-brand">
        <img class="h-brand-img" src="/img/ouakademi-logo-colored.svg" alt="">
        <h3>Soru Tahtası</h3>
    </div>
    <div class="h-nav">
        <a href="{{ route('event.index') }}">Etkinlikler</a>

        @if(isset(Auth::user()->id))
            <a href="{{ route('event.create') }}">Etkinlik oluştur</a>
            <a href="{{ route('profile.show') }}">Profilim</a>
        @else
            <a href="{{ route('login') }}">Giriş Yap</a>
            <a href="{{ route('register') }}">Kayıt Ol</a>
        @endif
    </div>
</header>
-->

<div class="nav">
    <input type="checkbox" id="nav-check">
    <div class="nav-header">
        <div class="nav-title">
            <img class="h-brand-img" src="/img/ouakademi-logo-colored.svg" alt="">
            <h3>Soru Tahtası</h3>
        </div>
    </div>
    <div class="nav-btn">
        <label for="nav-check">
            <span></span>
            <span></span>
            <span></span>
        </label>
    </div>

    <div class="nav-links">
        <a href="{{ route('event.index') }}">Etkinlikler</a>

        @if(isset(Auth::user()->id))
            <a href="{{ route('event.create') }}">Etkinlik oluştur</a>
            <a href="{{ route('profile.show') }}">Profilim</a>
        @else
            <a href="{{ route('login') }}">Giriş Yap</a>
            <a href="{{ route('register') }}">Kayıt Ol</a>
        @endif
    </div>
</div>


