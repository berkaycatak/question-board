<x-app-layout>
    <x-slot name="website_title">Yaklaşan Soru Cevap Etkinlikleri</x-slot>
    <x-slot name="website_description">Soru Tahtası üzerinde oluşturulmuş soru cevap etkinliklerini görüntüleyebilirsiniz. Kendi soru cevap etkinliğinizi oluşturup canlı yayında yönetebilirsiniz.</x-slot>

    <div class="main-header">
            <h5>👀 Etkinlikler</h5>
            <h1>Yaklaşan Etkinlikler</h1>
        </div>
        <div class="main-events">
            @foreach($events as $event)
                <div class="event-card">
                    <a href="{{ route('event.show', $event->id) }}"><h3>{{ $event->name }}</h3></a>
                    <div class="event-card-spec">
                        <div class="ecs-item">
                            <span>⏰</span>
                            <span class="ecs-item-text"> {{ $event->time }}</span>
                        </div>
                        <div class="ecs-item">
                            <span>🗓</span>
                            <span class="ecs-item-text">{{ $event->date }}</span>
                        </div>
                        <div class="ecs-item">
                            @isset(Auth::user()->id)
                                @if($event->created_user_id == Auth::user()->id)
                                    <a href="{{ route('event.edit', $event->id) }}">Etkinliği düzenle</a>
                                @endif
                            @endif
                        </div>
                        <div class="ecs-item">
                            <a href="{{ route('event.show', $event->id) }}">Etkinliğe git</a>
                        </div>
                        @isset(Auth::user()->id)
                            @if($event->created_user_id == Auth::user()->id)
                                <div class="ecs-item">
                                    <form method="POST" action="{{ route('event.destroy', $event->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Silmek istediğinizden emin misiniz ?')" class="danger-button" type="submit">Etkinliği sil</button>
                                    </form>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
            @if(count($events) == 0 )
                <span>Henüz hiç etkinlik yok. <a href="{{ route('event.create') }}">Hemen oluştur!</a></span>
            @endif
        </div>

    <div class="main-header">
        <h1>Geçmiş Etkinlikler</h1>
    </div>
    <div class="main-events">
        @foreach($past_events as $event)
            <div class="event-card">
                <a href="{{ route('event.show', $event->id) }}"><h3>{{ $event->name }}</h3></a>
                <div class="event-card-spec">
                    <div class="ecs-item">
                        <span>⏰</span>
                        <span class="ecs-item-text"> {{ $event->time }}</span>
                    </div>
                    <div class="ecs-item">
                        <span>🗓</span>
                        <span class="ecs-item-text">{{ $event->date }}</span>
                    </div>
                    <div class="ecs-item">
                        @isset(Auth::user()->id)
                            @if($event->created_user_id == Auth::user()->id)
                                <a href="{{ route('event.edit', $event->id) }}">Etkinliği düzenle</a>
                            @endif
                        @endif
                    </div>
                    <div class="ecs-item">
                        <a href="{{ route('event.show', $event->id) }}">Etkinliğe git</a>
                    </div>
                    @isset(Auth::user()->id)
                        @if($event->created_user_id == Auth::user()->id)
                            <div class="ecs-item">
                                <form method="POST" action="{{ route('event.destroy', $event->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Silmek istediğinizden emin misiniz ?')" class="danger-button" type="submit">Etkinliği sil</button>
                                </form>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
        {{ $past_events->links() }}
        @if(count($events) == 0 )
            <span>Henüz hiç etkinlik yok. <a href="{{ route('event.create') }}">Hemen oluştur!</a></span>
        @endif
    </div>
</x-app-layout>
