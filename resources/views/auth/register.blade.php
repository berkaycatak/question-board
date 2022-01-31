<x-app-layout>
    <x-slot name="header"></x-slot>
    <style>main{ flex-direction: row!important; }

        @media (max-width:820px) {
            main{
                flex-direction: column-reverse!important;
            }

            .right-context{
                max-width: inherit;
            }

            .left{ display: none; }

        }
    </style>

    <div class="left">
        @include('layouts.components.about')
    </div>
    <div class="right">
        <div class="right-context">
            <div class="rc-head">
                <h2>Kayıt Ol</h2>
            </div>
            <div class="rc-context">
                <x-jet-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <label for="email">Ad Soyad</label>
                    <input class="mb" required type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Adınızı ve soyadınızı girin">
                    <label for="email">E-Posta</label>
                    <input class="mb" required id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="E-Posta adresinizi girin">
                    <label for="password">Şifre</label>
                    <input class="mb" required type="password" name="password" required autocomplete="new-password" id="password" placeholder="Şifrenizi girin">
                    <input class="mb" required id="password_confirmation"  type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Şifrenizi doğrulayın">

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mt-4">
                            <x-jet-label for="terms">
                                <div class="flex items-center">
                                    <x-jet-checkbox name="terms" id="terms"/>

                                    <div class="ml-2">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-jet-label>
                        </div>
                    @endif

                    <input type="submit" value="Kayıt ol">
                    <div class="rc-context-bottom">
                        <a href="{{ route('login') }}">Zaten bir hesabım var</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
