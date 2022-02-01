<x-app-layout>
    <x-slot name="website_title">Şifremi Unuttum</x-slot>
    <x-slot name="website_description">Soru Tahtası hesabınızın şifresini unuttuysanız kısa form ile şifrenizi yenileyin.</x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Parolanızı mı unuttunuz? Sorun yok. Sadece bize e-posta adresinizi bildirin, size şifrenizi değiştirmenizi sağlayacak bir şifre sıfırlama bağlantıs içeren e-posta gönderelim.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    {{ __('Şifre sıfırlama bağlantısını gönder.') }}
                </x-jet-button>
            </div>
        </form>
</x-app-layout>
