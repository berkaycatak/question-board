<x-app-layout>
    <div class="main-header">
        <h5>👀 Panelim</h5>
        <h1>Etkinliklerim</h1>
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
                        <a href="{{ route('event.edit', $event->id) }}">Etkinliği düzenle</a>
                    </div>
                    <div class="ecs-item">
                        <a href="{{ route('event.show', $event->id) }}">Etkinliğe git</a>
                    </div>
                    <div class="ecs-item">
                        <form method="POST" action="{{ route('event.destroy', $event->id) }}">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Silmek istediğinizden emin misiniz ?')" class="danger-button" type="submit">Etkinliği sil</button>
                        </form>
                    </div>

                </div>
            </div>
        @endforeach
        {{ $events->links() }}
    </div>

</x-app-layout>
