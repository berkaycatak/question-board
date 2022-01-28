<x-app-layout>
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
