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
        $get_event = Event::find($event_id) ?? abort(404);
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

    public function not_answered($event_id, $question_id){
        $get_event = Event::find($event_id) ?? abort(404);
        if (isset(Auth::user()->id)){
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

        $event = Event::join('users', 'users.id', 'events.created_user_id')
            ->select('users.id as user_id', 'users.name as user_name', 'users.profile_photo_path as user_profile_photo_path',  'events.*')
            ->where('events.id', $event_id)
            ->first() ?? abort(404);

        $questions = Question::where('questions.event_id', $event_id)->get();

        $get_question = Question::find($question_id) ?? abort(404);
        if ($get_question->created_user_id == Auth::user()->id || Auth::user()->admin == 1){
            return view('pages.events.single', compact('event', "questions", "get_question"));
        }else{
            return redirect()->route('event.show', $event->id)->withError("Yetkilendirme hatası");
        }

    }

    public function update(QuestionRequest $request, $event_id, $question_id){
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
