<x-app-layout>
    <style>main{ flex-direction: row!important; }

        @media (max-width:820px) {
            main{
                flex-direction: column-reverse!important;
            }
            .right-context{
                max-width: inherit;
            }

            .right{ border-radius: inherit; background: none; }
            .left{ display: none; border-radius: inherit; }

        }
    </style>
    <div class="left">
        @include('layouts.components.about')
    </div>
    <div class="right">
        <div class="right-context">
            <div class="rc-head">
                <h2>Giriş Yap</h2>
            </div>
            <div class="rc-context">

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
