<x-app-layout>
    <x-slot name="website_title">Etkinliği Düzenle</x-slot>

    <div class="main-header">
        <h5 class="main-header-h5">✍🏻 ETKİNLİK PANOSU</h5>
        <h1>Etkinliği düzenle</h1>
        <a class="main-header-a" href="{{ route('dashboard') }}">Etkinliklerime git</a>
    </div>
    <div class="main-context">
        <h2 class="mc-h2-event">Etkinliği düzenle</h2>
        <form method="POST" action="{{ route('event.update', $event->id) }}" class="main-content-form">
            @method('put')
            @csrf
            <label for="eventname">Adı *</label>
            <input class="mb" name="name" @if(old('name') != "") value="{{ old('name') }}" @else value="{{ $event->name }}" @endif  type="text" placeholder="Etkinliğin adını girin" required>
            <label for="eventtime">⏰ Saati *</label>
            <input class="mb" name="time" @if(old('time') != "") value="{{ old('time') }}" @else value="{{ $event->time }}" @endif type="text" placeholder="Etkinliğin saatini girin Örn: 13:00" required>
            <label for="eventtime">👀 Konusu</label>
            <input class="mb" name="description" @if(old('description') != "") value="{{ old('description') }}" @else value="{{ $event->description }}" @endif type="text" placeholder="Etkinliğin konusunu girin">
            <label for="eventtime">📍 Adresi</label>
            <input class="mb" name="adress" @if(old('adress') != "") value="{{ old('adress') }}" @else value="{{ $event->adress }}" @endif  type="text" placeholder="Etkinliğin adresini girin">
            <label for="eventdate">🗓 Günü *</label>
            <input class="mb" name="date" @if(old('date') != "") value="{{ old('date') }}" @else value="{{ $event->date }}" @endif type="date" placeholder="Etkinliğin gününü GG.AA.YYYY şeklinde girin" required>
            <input type="submit" value="Düzenle">
        </form>
    </div>
</x-app-layout>
