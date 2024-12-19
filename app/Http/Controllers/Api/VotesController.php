<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Vote;
use Illuminate\Http\Request;
use Auth;

class VotesController extends Controller
{
    public function vote(Request $request)
    {
        $user_id = "";
        if (Auth::check())
            $user_id = Auth::user()->id;
        else
            $user_id = request()->ip();

        $vote = Vote::where('question_id', $request->question_id)
            ->where('user_id', $user_id)
            ->where('action_type', $request->type)
            ->count();
        if ($vote > 0)
        {
            $vote_action = Vote::where('question_id', $request->question_id)
                ->where('action_type', $request->type)
                ->where('user_id', $user_id)->delete();
        }
        else
        {
            $vote_action = new Vote();
            $vote_action->event_id = $request->event_id;
            $vote_action->question_id = $request->question_id;
            $vote_action->user_id = $user_id;
            $vote_action->action_type = $request->type;
            $vote_action->save();
        }

        if ($vote_action)
        {
            $vote_count = Vote::where('question_id', $request->question_id)->where('action_type', $request->type)->count();
            return response()->json(['status' => 'success', 'message' => 'İşlem başarıyla gerçekleştirildi', 'count' => $vote_count]);
        }
        else
        {
            return response()->json(['status' => 'fail', 'message' => 'İşlem gerçekleştirilirken hata oldu']);
        }
    }

    public function ask(Request $request)
    {
        $user_id = "";
        if (\Illuminate\Support\Facades\Auth::check())
            $user_id = Auth::user()->id;
        else
            $user_id = request()->ip();

        $question = Question::find($request->question_id);
        if ($question == null)
            throw new \Exception("Bir hata meydana geldi");

        $promt = 'Sen "Soru Tahtası" platformu için oluşturulmuş bir yapay zekasın. '. $question->event->name .' başlıklı etkinlik için gönderilmiş aşağıdaki soruya kısa bir şekilde cevap ver. "' . $question->question . '"';
        $response = $this->generateAIContent($promt);

        $answer = $response['candidates'][0]['content']['parts'][0]['text'];


        $save = $question->gemini_answer = $answer;
        $save = $question->save();

        if ($save)
        {
            return response()->json([
                'status' => 'success',
                'message' => 'İşlem başarıyla gerçekleştirildi',
                'answer' => $answer
            ]);
        }
        else
        {
            return response()->json(['status' => 'fail', 'message' => 'İşlem gerçekleştirilirken hata oldu']);
        }
    }

    function generateAIContent($prompt) {
        $apiKey = env("GEMINI_API_KEY");
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $apiKey;

        $data = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $prompt]
                    ]
                ]
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Hata: ' . curl_error($ch);
            return null;
        }

        curl_close($ch);

        return json_decode($response, true);
    }

}
