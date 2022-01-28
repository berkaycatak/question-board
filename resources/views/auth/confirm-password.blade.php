<x-app-layout>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Lütfen yeni şifrenizi girin.') }}
        </div>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div>
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" autofocus />
            </div>

            <div class="flex justify-end mt-4">
                <x-jet-button class="ml-4">
                    {{ __('Onayla') }}
                </x-jet-button>
            </div>
        </form>
</x-app-layout>
