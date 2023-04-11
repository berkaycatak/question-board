<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
}
