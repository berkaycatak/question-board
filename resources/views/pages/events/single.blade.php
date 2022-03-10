<x-app-layout>
    <x-slot name="website_title">{{ $event->name }}</x-slot>
    <x-slot name="website_description">Soru cevap etkinliği {{ $event->name }}. {{ $event->description }}</x-slot>

    <div class="main-header">
            <h5>✍🏻 SORU TAHTASI</h5>

            <h1>{{ $event->name }}</h1>

            <div class="main-header-specs">
                <div class="mhs-item" style="display: flex;">
                    <img class="ecs-item" height="25" width="25" style="border-radius: 50%;" src="{{ $event->user_profile_photo_path == null ? 'https://ui-avatars.com/api/?name='. $event->user_name : ''.$event->user_profile_photo_path }}" alt="{{ $event->user_name }}">
                    <span class="ecs-item-text" style="margin-left: 5px;">{{ $event->user_name }}</span>
                </div>
                <div class="mhs-item">
                    <span>⏰</span>
                    <span class="ecs-item-text">{{ $event->time }}</span>
                </div>
                <div class="mhs-item">
                    <span>🗓</span>
                    <span class="ecs-item-text">{{ $event->date }}</span>
                </div>
                @if($event->adress != null)
                    <div class="mhs-item mt-1">
                        <div class="ecs-item">
                            <a target="_blank" href="{{ $event->adress }}">Etkinliğe Katıl</a>
                        </div>
                    </div>
                @endif
                @isset(Auth::user()->id)
                    @if($event->created_user_id == Auth::user()->id)
                        <div class="mhs-item mt-1">
                            <div class="ecs-item">
                                <a href="{{ route('event.edit', $event->id) }}">Etkinliği düzenle</a>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
            <p class="event-description">{{ $event->description }}</p>

            <hr>
        </div>

            @isset($get_question)
                <form class="mcr-content add-question-form" method="POST" action="{{ route('question_update', [$event->id, $get_question->id]) }}">
                    @csrf
                    <label for="addquestion">💬 Soruyu düzenle</label>
                    <textarea required name="question" id="addquestion" rows="1">{{ $get_question->question }}</textarea>

                    <div class="checkbox">
                        <input id="anonim" name="anonim" type="checkbox" @if($get_question->is_anonim == 1) checked @endif>
                        <label for="anonim">İsmim görünmesin</label>
                    </div>
                    <input type="hidden" name="recaptcha_Cevap" id="recaptchaCevabi">
                    <input type="submit" value="Kaydet">
                </form>
            @else
                <form class="mcr-content add-question-form" method="POST" action="{{ route('question_store', $event->id) }}">
                    @csrf
                    <label for="addquestion">💬 Soru Ekle</label>
                    <textarea required name="question" id="addquestion" rows="1"></textarea>

                    @if(isset(Auth::user()->id))
                        <div class="checkbox">
                            <input id="anonim" name="anonim" type="checkbox">
                            <label for="anonim">İsmim görünmesin</label>
                        </div>
                    @else
                        <a href="{{ route('register') }}" style="color: black; margin-top: 10px;">Kayıt olarak isimli sor.</a>
                    @endif
                    <input type="hidden" name="recaptcha_Cevap" id="recaptchaCevabi">
                    <input type="submit" value="Gönder">
                </form>
            @endif
            <label class="questions-title">🤔 Sorular</label>
            <div class="main-content">
                <div class="questions">
                    @if(count($questions) > 0)
                        @php($counter = 0)
                        @foreach($questions as $question)
                            <div class="mc-item @if($question->is_answered) is-answered @endif ">
                                <div class="mci-head">
                                    <span>{{ $question->is_answered ? '✅' : '💬'}} &nbsp;</span>
                                    @if($question->created_user_id != null && $question->is_anonim == 0)
                                        @php($sender_name = DB::table('users')->where('id', $question->created_user_id)->select('name')->first()->name)
                                    @else
                                        @php($sender_name = "anonim")
                                    @endif
                                    <span @if($question->is_answered) class="is-answered-text" @endif> {{ timeConvert($question->created_at) }} {{ $sender_name }} tarafından gönderildi.</span>
                                </div>
                                <div class="mci-context">
                                    <span  @if($question->is_answered) class="color-white" @endif >{{ $question->question }}</span>
                                    @isset(Auth::user()->id)
                                        @if(Auth::user()->id == $event->created_user_id)

                                            <small @if($question->is_answered) class="color-white-ac" @endif >
                                                @if($question->is_answered)
                                                    <a href="{{ route("question_not_answered", ["event_id" => $event->id, "question_id" => $question->id]) }}">Cevaplanmadı</a>
                                                @else
                                                    <a href="{{ route("question_answered", ["event_id" => $event->id, "question_id" => $question->id]) }}">Cevaplandı</a>
                                                @endif
                                                |
                                                <a href="{{ route("question_delete", ["event_id" => $event->id, "question_id" => $question->id]) }}">Sil</a>
                                            </small>
                                        @endif
                                        @if(Auth::user()->id == $question->created_user_id)
                                            <small @if($question->is_answered) class="color-white-ac" @endif >
                                                <a href="{{ route("question_edit", ["event_id" => $event->id, "question_id" => $question->id]) }}">Düzenle</a> | <a href="{{ route("question_delete", ["event_id" => $event->id, "question_id" => $question->id]) }}">Sil</a>
                                            </small>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            @php($counter++)
                        @endforeach
                    @else
                        <span class="no-question">
                            Herhangi bir soru bulunamadı. İlk sen sor!
                        </span>
                    @endif
                </div>
            </div>
     </div>


    <script>
        socket.on('event-{{ $event->id }}', function (data) {
            var item = $('<div class="mc-item">' +
                '<div class="mci-head">' +
                '<span>💬 &nbsp;</span>' +
                '<span>'+ data["date"] +' '+ data["sender_name"] +' tarafından gönderildi.</span>' +
                '</div>' +
                '<div class="mci-context">' +
                '<span>'+ data["content"] +'</span>' +
                '</div>' +
                '<div>').hide().fadeIn(500);
            $('.questions').append(item);
            $.playSound('/sound/notification.mp3');
            $.ambiance({message: "Yeni sorular var, cevaplamayı unutma! :)",  fade: true,  timeout: 5});


        });


    </script>

</x-app-layout>
