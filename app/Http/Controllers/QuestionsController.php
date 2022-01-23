<?php

namespace App\Http\Controllers;

use App\Http\Requests\Main\Question\QuestionRequest;
use App\Models\Event;
use App\Models\Question;
use Illuminate\Http\Request;
use Auth;

class QuestionsController extends Controller
{
    public function store(QuestionRequest $request, $id){
        $question = new Question;
        $question->question = $request->question;
        $question->event_id = $id;

        if (isset(Auth::user()->id)){
            $question->created_user_id = Auth::user()->id;
            if (isset($request->anonim)){
                $question->is_anonim = 1;
            }else{
                $question->is_anonim = 0;
            }
        }else{
            $question->is_anonim = 1;
        }


        $save = $question->save();
        if ($save){
            return redirect()->route('event.show', $id)->withSuccess('Sorunuz başarıyla gönderildi.');
        }else{
            return redirect()->route('event.show', $id)->withError('Sorunuz gönderilirken bir problem yaşandı.');
        }
    }

    public function delete($event_id, $question_id){

        $get_event = Event::find($event_id);
        if (isset(Auth::user()->id)) {
            if ($get_event->created_user_id == Auth::user()->id) {

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
        $get_event = Event::find($event_id);
        if (isset(Auth::user()->id)){
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
}
