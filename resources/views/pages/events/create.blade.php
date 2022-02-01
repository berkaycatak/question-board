<x-app-layout>
    <x-slot name="website_title">Etkinlik Oluştur</x-slot>

    <div class="main-header">
        <h5 class="main-header-h5">✍🏻 ETKİNLİK PANOSU</h5>
        <h1>Etkinlik Oluştur</h1>
        <a class="main-header-a" href="{{ route('event.index') }}">Etkinlik listesine git</a>
    </div>
    <div class="main-context">
        <h2 class="mc-h2-event">Etkinlik Ekle</h2>
        <form method="POST" action="{{ route('event.store') }}" class="main-content-form">
            @csrf
            <label for="eventname">Adı *</label>
            <input class="mb" name="name" value="{{ old('name') }}" type="text" placeholder="Etkinliğin adını girin" required>
            <label for="eventtime">⏰ Saati *</label>
            <input class="mb time-element" name="time" id="time" value="{{ old('time') }}" type="text" placeholder="Etkinliğin saatini girin Örn: 13:00" required>
            <label for="eventtime">👀 Konusu</label>
            <input class="mb" name="description" value="{{ old('description') }}" type="text" placeholder="Etkinliğin konusunu girin">
            <label for="eventtime">📍 Adresi</label>
            <input class="mb url-element" name="adress" value="{{ old('adress') }}" type="text" placeholder="Etkinliğin adresini girin">
            <label for="eventdate">🗓 Günü *</label>
            <input class="mb" name="date" value="{{ old('date') }}" type="date" placeholder="Etkinliğin gününü GG.AA.YYYY şeklinde girin" required>
            <input type="submit" value="Ekle">
        </form>
    </div>

    <x-slot name="js">
        <script src="https://nosir.github.io/cleave.js/dist/cleave.min.js"></script>
        <script>
            var cleave = new Cleave('.time-element', {
                time: true,
                timePattern: ['h', 'm']
            });

            var cleave2 = new Cleave('.url-element', {
                prefix: 'https://'
            });
        </script>

    </x-slot>
</x-app-layout>
