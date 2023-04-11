<?php

namespace App\Http\Controllers\Api\Mobile\Question;

use App\Http\Requests\Main\Question\QuestionRequest;
use App\Models\Event;
use App\Models\Question;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;

class QuestionController
{
    public function answered($event_id, $question_id){
        try {
            $event = Event::find($event_id) ?? false;
            if (is_bool($event))
                throw new \Exception("Bir hata meydana geldi");

            if ($event->created_user_id != Auth::user()->id)
                throw new \Exception("Etkinlik bulunamadı.");

            $question = Question::find($question_id);
            $answered = 0;
            $response_text = "cevaplandı";

            if ($question->is_answered == 1)
            {
                $response_text = "cevaplanmadı";
                $answered = 0;
            }
            else
            {
                $response_text = "cevaplandı";
                $answered = 1;
            }

            $question->is_answered = $answered;
            $answered = $question->save();

            if ($answered){
                return [
                    "status" => 1,
                    "message" => "Soru $response_text olarak işaretlendi."
                ];
            }

        }catch (\Exception $exception){
            return [
                "status" => 0,
                "errors" => $exception->getMessage()
            ];
        }
    }


    public function store($id, QuestionRequest $request)
    {
        try {
            $event = Event::find($id) ?? false;
            if (is_bool($event))
                throw new \Exception("Bir hata meydana geldi");

            $question_check = Question::where("question", $request->question)->where("event_id", $id)->count();
            if ($question_check > 0)
                throw new \Exception("Aynı soru daha önce sorulmuş.");

            $question = new Question;

            if ($request->has("name")){
                $question->name = $request->name;
            }
            $question->question = $request->question;
            $question->event_id = $id;
            $question->is_live = 1;

            if (isset(Auth::user()->id)) {
                $question->created_user_id = Auth::user()->id;
                if (isset($request->anonim)) {
                    $question->is_anonim = 1;
                } else {
                    $question->is_anonim = 0;
                }
            } else {
                $question->is_anonim = 1;
            }

            $save = $question->save();
            if ($save)
            {
                return [
                    "status" => 1,
                    "message" => "Soru başarıyla gönderildi."
                ];
            }
        }catch (Exception $exception){
            return [
                "status" => 0,
                "errors" => $exception->getMessage()
            ];
        }
    }

    public function vote($id, Request $request)
    {

        try {
            $user_id = "";
            if (Auth::check())
                $user_id = Auth::user()->id;
            else
                $user_id = request()->ip();

            $vote = Vote::where('question_id', $id)
                ->where('user_id', $user_id)
                ->where('action_type', 1)
                ->count();
            if ($vote > 0)
            {
                $vote_action = Vote::where('question_id', $id)
                    ->where('action_type', 1)
                    ->where('user_id', $user_id)->delete();
            }
            else
            {
                $vote_action = new Vote();
                $vote_action->event_id = $request->event_id;
                $vote_action->question_id = $id;
                $vote_action->user_id = $user_id;
                $vote_action->action_type = 1;
                $vote_action->save();
            }

            if ($vote_action)
            {
                $vote_count = Vote::where('question_id', $id)->where('action_type', 1)->count();
                return [
                    "status" => 1,
                    "count" => $vote_count,
                    "message" => "İşlem başarıyla gerçekleştirildi."
                ];
            }
            else
                throw new \Exception("İşlem gerçekleştirilirken hata oldu");
        }catch (Exception $exception){
            return [
                "status" => 0,
                "errors" => $exception->getMessage()
            ];
        }

    }
}
