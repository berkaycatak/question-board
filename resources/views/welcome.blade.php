<x-app-layout>
    <x-slot name="website_home_title">{{ config('app.name', 'Laravel') }} - Canlı Yayında Sorularını Yönet!</x-slot>
    <x-slot name="website_description">Etkinlik oluştur ve izleyicilerinden soru al! Canlı yayında kolay arayüz ile soruları yönet ve cevapla!</x-slot>

    <div class="landing-page">
        <h1>Soru Tahtası</h1>
        <h3>Linkini paylaş ve soruları gör!</h3>
        <p>Soru Tahtası kullanarak etkinlik oluştur, linkini paylaş, ister anonim ister isim soyisim ile soruları kabul et!</p>
        <div class="landing-buttons">
            @isset(Auth::user()->id)
                <a href="{{ route("event.create") }}"><button class="green-button">Etkinlik oluştur</button></a>
            @else
                <a href="{{ route("login") }}"><button class="green-button">Giriş yap</button></a>
                <a href="{{ route("register") }}"><button class="blue-button">Kayıt ol</button></a>
            @endif
        </div>
    </div>
</x-app-layout>
