<?php

namespace App\Http\Controllers;

use App\Http\Requests\Main\Question\QuestionRequest;
use App\Models\Event;
use App\Models\Question;
use Illuminate\Http\Request;
use Auth;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class QuestionsController extends Controller
{
    public function store(QuestionRequest $request, $id){


        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = '6LePzMweAAAAANeSyk6_og1vI5-0GzV4Ht8Wh3Ab';
        $recaptcha_response = $_POST['recaptcha_Cevap'];

        // Make and decode POST request:
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);
        // Take action based on the score returned:

        $question_check = Question::where("question", $request->question)->where("event_id", $id)->count();
        $sender_name = "anonim";
        if ($question_check <= 0)
        {
            $question = new Question;
            $question->question = $request->question;
            $question->event_id = $id;

            if (isset($recaptcha->score)) {
                if ($recaptcha->score >= 0.5) {
                    $question->is_live = 0;
                }
            } else {
                $question->is_live = 0;
            }

            if (isset(Auth::user()->id)){
                $question->created_user_id = Auth::user()->id;
                if (isset($request->anonim)){
                    $question->is_anonim = 1;
                }else{
                    $sender_name = Auth::user()->name;
                    $question->is_anonim = 0;
                }
            }else{
                $question->is_anonim = 1;
            }

            $save = $question->save();
            if ($save){
                if (isset($recaptcha->score)) {
                    if ($recaptcha->score >= 0.4) {
                        print "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.4.1/socket.io.js\" integrity=\"sha512-MgkNs0gNdrnOM7k+0L+wgiRc5aLgl74sJQKbIWegVIMvVGPc1+gc1L2oK9Wf/D9pq58eqIJAxOonYPVE5UwUFA==\" crossorigin=\"anonymous\" referrerpolicy=\"no-referrer\"></script>";
                        print '<script>const socket2 = io("https://sorutahtasi.com:5222", { transports : [\'websocket\'] });</script>';
                        print '<script>socket2.emit("send-questions", { "event_id" : ' . $question->event_id . ', "sender_name": "' . $sender_name . '", "date" : "az önce", "content" : "' . $question->question . '" });</script>';
                        print view('layouts.redirect.question')->render();
                        sleep(1);
                        return redirect()->route('event.show', $id)->withSuccess('Sorunuz başarıyla gönderildi.');
                    } else {
                        return redirect()->route('event.show', $id)->withSuccess('Google bot olduğunuzu düşünüyor. Sorunuzu kaydettik fakat yayına almadık. İncelemenin ardından gösterilmeye başlanacak.');
                    }
                } else
                {
                    return redirect()->route('event.show', $id)->withSuccess('Google bot olduğunuzu düşünüyor. Sorunuzu kaydettik fakat yayına almadık. İncelemenin ardından gösterilmeye başlanacak.');
                }
            }else{
                return redirect()->route('event.show', $id)->withError('Sorunuz gönderilirken bir problem yaşandı.');
            }
        }
        else
        {
            return redirect()->route('event.show', $id)->withError('Daha önce aynı soru gönderilmiş.');
        }
    }

    public function delete($event_id, $question_id){

        $get_event    = Event::find($event_id) ?? abort(404);
        $get_question = Question::find($question_id);
        if (isset(Auth::user()->id)) {
            if ($get_event->created_user_id == Auth::user()->id || $get_question->created_user_id == Auth::user()->id) {

                $delete = Question::where('id', $question_id)->delete();
                if ($delete) {
                    return redirect()->route('event.show', $event_id)->withSuccess('Soru başarıyla silindi.');
                } else {
                    return redirect()->route('event.show', $event_id)->withError('Soru silinirken bir problem yaşandı.');
                }
            }
        }
    }

    public function answered($event_id, $question_id){
        if (isset(Auth::user()->id)){
            $get_event = Event::find($event_id) ?? abort(404);
            if ($get_event->created_user_id == Auth::user()->id){

                $question = Question::find($question_id);
                $question->is_answered = 1;
                $answered = $question->save();

                if ($answered){
                    return redirect()->route('event.show', $event_id)->withSuccess('Soru başarıyla cevaplandı olarak işaretlendi.');
                }else{
                    return redirect()->route('event.show', $event_id)->withError('Soru cevaplandı olarak işaretlenirken bir problem yaşandı.');
                }

            }else{
                return redirect()->route('event.show', $event_id)->withError('Yetkilendirme hatası.');
            }
        }else{
            return redirect()->route('event.show', $event_id)->withError('Yetkilendirme hatası.');
        }
    }

    public function not_answered($event_id, $question_id){
        if (isset(Auth::user()->id)){
            $get_event = Event::find($event_id) ?? abort(404);
            if ($get_event->created_user_id == Auth::user()->id){

                $question = Question::find($question_id);
                $question->is_answered = 0;
                $answered = $question->save();

                if ($answered){
                    return redirect()->route('event.show', $event_id)->withSuccess('Soru başarıyla cevaplanmadı olarak işaretlendi.');
                }else{
                    return redirect()->route('event.show', $event_id)->withError('Soru cevaplanmadı olarak işaretlenirken bir problem yaşandı.');
                }

            }else{
                return redirect()->route('event.show', $event_id)->withError('Yetkilendirme hatası.');
            }
        }else{
            return redirect()->route('event.show', $event_id)->withError('Yetkilendirme hatası.');
        }
    }


    public function edit($event_id, $question_id){
        if (isset(Auth::user()->id)){
            $event = Event::join('users', 'users.id', 'events.created_user_id')
                    ->select('users.id as user_id', 'users.name as user_name', 'users.profile_photo_path as user_profile_photo_path',  'events.*')
                    ->where('events.id', $event_id)
                    ->first() ?? abort(404);

            $questions = Question::where('questions.event_id', $event_id)->get() ?? abort(404);

            $get_question = Question::find($question_id) ?? abort(404);
            if ($get_question->created_user_id == Auth::user()->id || Auth::user()->admin == 1){
                return view('pages.events.single', compact('event', "questions", "get_question"));
            }else{
                return redirect()->route('event.show', $event->id)->withError("Yetkilendirme hatası");
            }
        }
    }

    public function update(QuestionRequest $request, $event_id, $question_id){
        if (isset(Auth::user()->id)){
            $get_question = Question::find($question_id) ?? abort(404);
            if ($get_question->created_user_id == Auth::user()->id || Auth::user()->admin == 1){
                $get_question->question = $request->question;
                if (isset($request->anonim)){
                    $get_question->is_anonim = 1;
                }else{
                    $get_question->is_anonim = 0;
                }
                $save = $get_question->save();

                if ($save){
                    return redirect()->route('question_edit', [$event_id, $question_id])->withSuccess("Soru başarıyla düzenlendi.");
                }

            }else{
                return redirect()->route('event.show', $event_id)->withError("Yetkilendirme hatası");
            }
        }
    }
}
