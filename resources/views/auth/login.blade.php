<x-app-layout>
    <div class="left">
        @include('layouts.components.about')
    </div>
    <div class="right">
        <div class="right-context">
            <div class="rc-head">
                <h2>Giriş Yap</h2>
            </div>
            <div class="rc-context">
                <x-jet-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <label for="email">E-Posta</label>
                    <input required type="email" id="email" name="email" value="{{ old("email") }}" placeholder="E-Posta adresinizi girin">
                    <label for="password">Şifre</label>
                    <input required type="password" name="password" placeholder="Şifrenizi girin">
                    <div class="checkbox">
                        <input type="checkbox">
                        <span>Şifremi göster</span>
                    </div>
                    <input type="submit" value="Giriş yap">
                    <div class="rc-context-bottom">
                        <a href="{{ route('password.request') }}">Şifrenizi mi unuttunuz?</a>
                        <a href="{{ route('register') }}">Henüz bir hesabınız yok mu?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
