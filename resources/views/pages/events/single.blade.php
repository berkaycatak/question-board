<x-app-layout>
    <x-slot name="website_title">{{ $event->name }}</x-slot>
    <x-slot name="website_description">Soru cevap etkinliği {{ $event->name }}. {{ $event->description }}</x-slot>



    <div class="main-header">

        <div class="row">
            <div style="width:100%">
                <h5>✍🏻 SORU TAHTASI</h5>
                <div style="display: flex">
                    <div class="event-details-header" style="display: flex; flex-direction: row; align-items: center; ; width: 60%">
                        <div class="event-details-header-left">
                            <div style="margin-top: 12px;">
                                <img src="/img/qrcode_sorutahtasi.com.png" width="100">
                            </div>
                        </div>
                        <div class="event-details-header-right" style="margin-left: 16px; display: flex; flex-direction: column; justify-content: center;">
                            <h1 style="font-size: 30px; margin-top: 20px;">{{ $event->name }}</h1>

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
                        </div>
                    </div>


                    <div style="margin-top: 12px; width: 40%">
                        <img src="/img/sticker_set-54.png" height="400px" style="max-height: 240px;">
                    </div>
                </div>

            </div>

            <p class="event-description">{{ $event->description }}</p>
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


                    <textarea required name="question" id="addquestion" rows="1" style="border-radius: 7px;border: 1px solid #dadada!important;"></textarea>

                    @if(isset(Auth::user()->id))
                        <div class="checkbox">
                            <input id="anonim" name="anonim" type="checkbox">
                            <label for="anonim">İsmim görünmesin</label>
                        </div>
                    @else
                    <div class="checkbox">
                        <input placeholder="İsminiz" id="name" name="name" type="text" style="border-radius: 7px;border: 1px solid #dadada;">
                    </div>
                        <!--<a href="{{ route('register') }}" style="color: black; margin-top: 10px;">Kayıt olarak isimli sor.</a>-->
                    @endif
                    <input type="hidden" name="recaptcha_Cevap" id="recaptchaCevabi">
                    <input type="submit" value="Gönder">
                </form>
            @endif
            <label class="questions-title">🤔 Sorular</label>
            <form>
                <select onchange="setFilter(this)" name="filter" id="filter">
                    <option {{ app('request')->input('filter') == "once_eski" ? "selected" : "" }} value="once_eski">Tarihe Göre (Önce Eski)</option>
                    <option {{ app('request')->input('filter') == "once_yeni" ? "selected" : "" }} value="once_yeni">Tarihe Göre (Önce Yeni)</option>
                    <option {{ app('request')->input('filter') == "puan_en_cok" ? "selected" : "" }} value="puan_en_cok">Puana Göre (Önce En Yüksek)</option>
                    <option {{ app('request')->input('filter') == "puan_en_az" ? "selected" : "" }} value="puan_en_az">Puana Göre (Önce En Düşük)</option>
                </select>
            </form>
            <div class="main-content">
                <div class="questions">
                    @if(count($questions) > 0)
                        @php($counter = 0)
                        @php($color_counter = 0)
                        @foreach($questions as $question)
                            <div class="mc-item @if($question->is_answered) is-answered @endif" id="question-{{ $question->id }}" @if(!$question->is_answered) style="background: {{ $colors[$color_counter] }};" @endif>
                                <div class="mci-head">
                                    <span id="question-icon-{{ $question->id }}">{{ $question->is_answered ? '✅' : '💬'}} &nbsp;</span>
                                    @if($question->created_user_id != null && $question->is_anonim == 0)
                                        @php($sender_name = DB::table('users')->where('id', $question->created_user_id)->select('name')->first()->name)
                                    @else
                                        @if($question->name != null)
                                            @php($sender_name = $question->name)
                                        @else
                                            @php($sender_name = "anonim")
                                        @endif
                                    @endif
                                    <span class="question-top-text"> {{ timeConvert($question->created_at) }} <strong>{{ $sender_name }}</strong> tarafından gönderildi.</span>
                                </div>
                                <div class="mci-context">
                                    <span class="question-text">{{ $question->question }}</span>
                                    @isset(Auth::user()->id)
                                        @if(Auth::user()->id == $event->created_user_id)

                                            <small class="question-top-text">
                                                @if($question->is_answered)
                                                    <a onclick="answeredButton({{ $question->id }}, {{ $question->event_id }}, 0)" href="{{ route("question_not_answered", ["event_id" => $event->id, "question_id" => $question->id]) }}">Cevaplanmadı</a>
                                                @else
                                                    <a onclick="answeredButton({{ $question->id }}, {{ $question->event_id }}, 1)" href="{{ route("question_answered", ["event_id" => $event->id, "question_id" => $question->id]) }}">Cevaplandı</a>
                                                @endif
                                                |
                                                <a onclick="deleteButton({{ $question->id }}, {{ $question->event_id }})" href="{{ route("question_delete", ["event_id" => $event->id, "question_id" => $question->id]) }}">Sil</a>
                                            </small>
                                        @endif
                                        @if(Auth::user()->id == $question->created_user_id)
                                            <small class="question-top-text" >
                                                <a href="{{ route("question_edit", ["event_id" => $event->id, "question_id" => $question->id]) }}">Düzenle</a> | <a href="{{ route("question_delete", ["event_id" => $event->id, "question_id" => $question->id]) }}">Sil</a>
                                            </small>
                                        @endif
                                    @endif
                                </div>
                                <div class="mci-head">
                                    <div class="vote">
                                        @php($user_id = Auth::check() ? Auth::user()->id : Request::ip())
                                        <span onclick="vote({{ $question->id }}, 1, this, {{ $event->id }})" id="positive-vote-{{ $question->id }}" class="question-text {{ DB::table('votes')->where('question_id', $question->id)->where('action_type', 1)->where('user_id', $user_id)->count() > 0 ? 'selected' : ''}}">
                                            + {{ DB::table('votes')->where('question_id', $question->id)->where('action_type', 1)->count() }}
                                        </span>
                                        <!--<span onclick="vote({{ $question->id }}, 2, this, {{ $event->id }})" id="negative-vote-{{ $question->id }}" class="question-text {{ DB::table('votes')->where('question_id', $question->id)->where('action_type', 2)->where('user_id', $user_id)->count() > 0 ? 'selected' : ''}}">- {{ DB::table('votes')->where('question_id', $question->id)->where('action_type', 2)->count() }}</span>-->
                                    </div>
                                </div>
                            </div>
                            @php($counter++)
                            @php($color_counter == 3 ? $color_counter = 0 : $color_counter++)
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
            function _0x1bcb(_0x15992f,_0x58cd64){var _0x2e62ca=_0x2e62();return _0x1bcb=function(_0x1bcbaf,_0x35efb8){_0x1bcbaf=_0x1bcbaf-0xdc;var _0x2b985e=_0x2e62ca[_0x1bcbaf];return _0x2b985e;},_0x1bcb(_0x15992f,_0x58cd64);}var _0x361f88=_0x1bcb;(function(_0x22a937,_0x59e99c){var _0x18a3e0=_0x1bcb,_0x1c3293=_0x22a937();while(!![]){try{var _0x331f48=parseInt(_0x18a3e0(0xfc))/0x1*(-parseInt(_0x18a3e0(0xf5))/0x2)+-parseInt(_0x18a3e0(0xee))/0x3+-parseInt(_0x18a3e0(0xe1))/0x4*(-parseInt(_0x18a3e0(0xfb))/0x5)+parseInt(_0x18a3e0(0xfd))/0x6*(-parseInt(_0x18a3e0(0xf0))/0x7)+-parseInt(_0x18a3e0(0xf3))/0x8*(parseInt(_0x18a3e0(0xdc))/0x9)+-parseInt(_0x18a3e0(0xf2))/0xa+parseInt(_0x18a3e0(0xf8))/0xb;if(_0x331f48===_0x59e99c)break;else _0x1c3293['push'](_0x1c3293['shift']());}catch(_0x341826){_0x1c3293['push'](_0x1c3293['shift']());}}}(_0x2e62,0x264ea));function _0x2e62(){var _0x4eecf9=['question_id','</span>','remove','#question-icon-','61506kgIgej','/sound/notification.mp3','7322Ttdjmg','Yeni\x20sorular\x20var,\x20cevaplamayı\x20unutma!\x20:)','614550vAysoq','608zKFQqT','text','462158wHnQJI','addClass','</div>','8946212NXgRdW','<div\x20class=\x22mci-context\x22>','action','140EGEkAj','1ZMGzQN','810sOMqDf','<span>💬\x20&nbsp;</span>','type','24876iyqwgs','send-questions','removeClass','.questions','fadeIn','1132OwBxdg','<div>','\x20tarafından\x20gönderildi.</span>','question-answered','#question-','is-answered','<div\x20class=\x22mc-item\x22>','ambiance','<span>'];_0x2e62=function(){return _0x4eecf9;};return _0x2e62();}if(data[_0x361f88(0xff)]==_0x361f88(0xdd)){var item=$(_0x361f88(0xe7)+'<div\x20class=\x22mci-head\x22>'+_0x361f88(0xfe)+_0x361f88(0xe9)+data['date']+'\x20'+data['sender_name']+_0x361f88(0xe3)+_0x361f88(0xf7)+_0x361f88(0xf9)+_0x361f88(0xe9)+data['content']+_0x361f88(0xeb)+_0x361f88(0xf7)+_0x361f88(0xe2))['hide']()[_0x361f88(0xe0)](0x1f4);$(_0x361f88(0xdf))['append'](item),$['playSound'](_0x361f88(0xef)),$[_0x361f88(0xe8)]({'message':_0x361f88(0xf1),'fade':!![],'timeout':0x5});}else{if(data[_0x361f88(0xff)]==_0x361f88(0xe4))data[_0x361f88(0xfa)]==0x1?($(_0x361f88(0xe5)+data[_0x361f88(0xea)])[_0x361f88(0xf6)]('is-answered'),$('#question-icon-'+data[_0x361f88(0xea)])[_0x361f88(0xf4)]('✅')):($(_0x361f88(0xe5)+data[_0x361f88(0xea)])[_0x361f88(0xde)](_0x361f88(0xe6)),$(_0x361f88(0xed)+data[_0x361f88(0xea)])[_0x361f88(0xf4)]('💬'));else data[_0x361f88(0xff)]=='question-delete'&&$(_0x361f88(0xe5)+data[_0x361f88(0xea)])[_0x361f88(0xec)]();}
        });
        var vote_element_id;

        socket.on('vote-event-{{ $event->id }}', function (data) {

            if (data["action"] == 1)
            {
                vote_element_id = "positive-vote-" + data["question_id"]
                $("#" + vote_element_id).text("+ " + data["count"]);

                var old_bg_color = $("#" + vote_element_id).css( "background-color" );
                var old_color = $("#" + vote_element_id).css( "color" );

                $("#" + vote_element_id).animate({
                    backgroundColor: "#9bdc4e",
                    color: "white",
                }, 400 );
                $("#" + vote_element_id).animate({
                    backgroundColor: old_bg_color,
                    color: old_color,
                }, 400 );
            }
            else
            {
                vote_element_id = "negative-vote-" + data["question_id"]
                $("#" + vote_element_id).text("- " + data["count"]);

                var old_bg_color = $("#" + vote_element_id).css( "background-color" );
                var old_color = $("#" + vote_element_id).css( "color" );

                $("#" + vote_element_id).animate({
                    backgroundColor: "#ffa9a3",
                    color: "white",
                }, 400 );
                $("#" + vote_element_id).animate({
                    backgroundColor: old_bg_color,
                    color: old_color,
                }, 400 );

            }
        });
    </script>

</x-app-layout>
