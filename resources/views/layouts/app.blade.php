<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="/css/events.css">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body>
        @include('layouts.components.header')
        <main>
            @isset($errors)
                @if($errors->any())
                    <div class="container mt-3">
                        <div class="mt-3 form-error-top">
                            @foreach($errors->all() as $error)
                                <li> {{ $error }} </li>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            @if(session('success') != "")
                <div class="container mt-3">
                    @php(printSuccessMessage(session('success')))
                </div>
            @endif

            @if(session('error') != "")
                <div class="container mt-3">
                    @php(printErrorMessage(session('error')))
                </div>
            @endif

            {{ $slot }}

        </main>

    <footer><a target="_blank" href="https://www.medialyra.com/"><img height="30" src="https://medialyra.com/wp-content/uploads/2021/11/lyra.png" alt="Media Lyra"></a>  | Copyright © {{ date('Y') }} Tüm Hakları Saklıdır.</footer>


    </body>
    @stack('modals')

    @livewireScripts

</html>