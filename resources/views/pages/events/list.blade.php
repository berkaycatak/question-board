<x-app-layout>
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
                            <span class="ecs-item-text">{{ $event->time }}</span>
                        </div>
                        <div class="ecs-item">
                            <span>🗓</span>
                            <span class="ecs-item-text">{{ $event->date }}</span>
                        </div>
                        <div class="ecs-item">
                            <a href="{{ route('event.show', $event->id) }}">Soru sor</a>
                        </div>
                        <div class="ecs-item">
                            <a href="{{ route('event.show', $event->id) }}">Etkinliğe git</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
</x-app-layout>
