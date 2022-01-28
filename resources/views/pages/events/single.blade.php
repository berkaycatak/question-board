<x-app-layout>
        <div class="main-header">
            <h5>✍🏻 SORU TAHTASI</h5>

            <h1>{{ $event->name }}</h1>
            <div class="main-header-specs">
                <div class="mhs-item" style="display: flex;">
                    <img class="ecs-item" height="25" width="25" style="border-radius: 50%;" src="{{ $event->user_profile_photo_path == null ? 'https://ui-avatars.com/api/?name='. $event->user_name : '/storage/'.$event->user_profile_photo_path }}" alt="{{ $event->user_name }}">
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
                <div class="mhs-item">
                    <div class="ecs-item">
                        <a target="_blank" href="{{ $event->adress }}">Etkinliğe git</a>
                    </div>
                </div>
                @isset(Auth::user()->id)
                    @if($event->created_user_id == Auth::user()->id)
                        <div class="mhs-item">
                            <div class="ecs-item">
                                <a href="{{ route('event.edit', $event->id) }}">Etkinliği düzenle</a>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
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
                <input type="submit" value="Gönder">
            </form>

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
                                    <span
                                    @if($question->is_answered)
                                        style=" color: white!important; "
                                    @endif
                                    >{{ $question->question }}</span>
                                    @isset(Auth::user()->id)
                                        @if(Auth::user()->id == $event->created_user_id)

                                            <small
                                                @if($question->is_answered)
                                                   style=" color: #efefef; "
                                                @endif
                                            >
                                                <a href="{{ route("question_answered", ["event_id" => $event->id, "question_id" => $question->id]) }}">Cevaplandı</a> | <a href="{{ route("question_delete", ["event_id" => $event->id, "question_id" => $question->id]) }}">Sil</a>
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
</x-app-layout>