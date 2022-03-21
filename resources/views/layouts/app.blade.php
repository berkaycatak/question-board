<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @isset($website_title)
            <title>{{ $website_title }} - {{ config('app.name', 'Laravel') }}</title>
        @elseif(isset($website_home_title))
            <title>{{ $website_home_title }}</title>
        @else
            <title>{{ config('app.name', 'Laravel') }}</title>
        @endif

        @isset($website_description)
            <meta name="description" content="{{ $website_description }}">
        @endif

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <meta name="yandex-verification" content="f093c89ba5a445d4" />
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script src='https://www.google.com/recaptcha/api.js?render=6LePzMweAAAAAFvu5sGRLlp7EeFoPi6VAMBdZjRC'></script>
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-JGS5TSLP9F"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

        gtag('config', 'G-JGS5TSLP9F');
        </script>
        <!-- Styles -->
        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="/css/events.css">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.4.1/socket.io.js" integrity="sha512-MgkNs0gNdrnOM7k+0L+wgiRc5aLgl74sJQKbIWegVIMvVGPc1+gc1L2oK9Wf/D9pq58eqIJAxOonYPVE5UwUFA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="/js/socket.js"></script>
        <script src="/js/jquery.ambiance.js"></script>
        <script src="/js/jquery.playSound.js"></script>
    </head>
    <body>
        @include('layouts.components.header')

        @isset($errors)
            @if($errors->any())
                <div class="errors mt-3">
                    <div class="mt-3 form-error-top">
                        @foreach($errors->all() as $error)
                            <li> {{ $error }} </li>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

        <main @isset($errors) @if($errors->any()) style="padding-top: 10px;" @endif @endif>
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

            @if(false)
                <footer>
                    <a target="_blank" href="https://www.medialyra.com/">
                        <img height="30" src="https://medialyra.com/wp-content/uploads/2021/11/lyra.png" alt="Media Lyra">
                    </a>
                    <span>| Copyright © {{ date('Y') }} Tüm Hakları Saklıdır.</span>
                </footer>
            @endif
        </main>

        <script src="/js/custom.js"></script>
        @isset($js)
            {{ $js }}
        @endif

        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('6LePzMweAAAAAFvu5sGRLlp7EeFoPi6VAMBdZjRC', {action: 'submit'}).then(function(token) {
                    var recaptchaCevabi = document.getElementById('recaptchaCevabi');
                    recaptchaCevabi.value = token;
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js" data-cfasync="false"></script>
        <script>
            window.cookieconsent.initialise({
                "palette": {
                    "popup": {
                        "background": "#efefef",
                        "text": "#404040"
                    },
                    "button": {
                        "background": "#8ec760",
                        "text": "#ffffff"
                    }
                },
                "theme": "classic",
                "position": "bottom-right",
                "content": {
                    "message": "Bu web sitesi çalışabilmesi için çerezleri kullanır. Aynı zamanda kayıt olmadan işlem yapabilmeniz için ve güvenlik nedeniyle yapılan işlemlerde ip adresi kayıt edilmektedir. ",
                    "dismiss": "Anladım!",
                    "link": "Soru Tahtası",
                    "href": "#"
                }
            });
        </script>
    </body>
    @stack('modals')

    @livewireScripts

</html>
