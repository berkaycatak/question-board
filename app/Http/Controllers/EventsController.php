<?php

namespace App\Http\Controllers;

use App\Http\Requests\Main\Event\EventRequest;
use App\Models\Event;
use App\Models\Question;
use App\Models\Vote;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events      = Event::where('is_live', '1')->where('date', ">=", date('Y-m-d'))->orderBy("id" ,'DESC')->paginate(10);
        $past_events = Event::where('is_live', '1')->where('date', "<", date('Y-m-d'))->orderBy("id", 'DESC')->paginate(10);
        return view('pages.events.list', compact('events', 'past_events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        $event = new Event();
        $event->name = $request->name;
        $event->description = $request->description;
        $event->adress = $request->adress;
        $event->date = $request->date;
        $event->time = $request->time;
        $event->created_user_id = Auth::user()->id;
        $save = $event->save();
        $id = $event->id;

        if ($save){
            return redirect()->route('event.show', $id)->withSuccess('Soru cevap etkinliği başarıyla oluşturuldu.');
        }else{
            return redirect()->route('event.create', $id)->withSuccess('Soru cevap etkinliği oluşturulurken bir problem yaşandı.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $event = Event::join('users', 'users.id', 'events.created_user_id')
            ->select('users.id as user_id', 'users.name as user_name', 'users.profile_photo_path as user_profile_photo_path',  'events.*')
            ->where('events.id', $id)
            ->first() ?? abort(404);

        $colors = ["#4285F4", "#DB4437", "#F4B400", "#0F9D58"];
        $questions = Question::where('questions.event_id', $id)
            ->where('is_live', 1);
        if (isset($request->filter))
        {
            if ($request->filter == "once_eski")
            {
                $questions = $questions->orderBy("created_at", "ASC");
            }
            else if ($request->filter == "once_yeni")
            {
                $questions = $questions->orderBy("created_at", "DESC");
            }
            else if ($request->filter == "puan_en_cok")
            {
                $questions = Vote::where("votes.event_id", $id)
                    ->where("questions.is_live", 1)
                    ->select('questions.*', 'votes.question_id', DB::raw('count(*) as total'))
                    ->groupBy('votes.question_id')
                    ->leftJoin("questions", "questions.id", "votes.question_id")
                    ->orderBy('total', 'desc');

                $array = [];
                foreach ($questions->get() as $question){
                    $array[] = $question->id;
                }

                $_questions = Question::where("event_id", $id)
                    ->where("questions.is_live", 1)
                    ->whereNotIn("id",
                        $array
                    )->get();

                $questions = $questions->get();
                $questions->push(...$_questions);
            }
            else if ($request->filter == "puan_en_az")
            {
                $questions = Vote::where("votes.event_id", $id)
                    ->where("questions.is_live", 1)
                    ->select('questions.*', 'votes.question_id', DB::raw('count(*) as total'))
                    ->groupBy('votes.question_id')
                    ->leftJoin("questions", "questions.id", "votes.question_id")
                    ->orderBy('total', 'asc');

                $array = [];
                foreach ($questions->get() as $question){
                    $array[] = $question->id;
                }

                $_questions = Question::where("event_id", $id)
                    ->where("questions.is_live", 1)
                    ->whereNotIn("id",
                        $array
                    )->get();

                $questions = $questions->get();
                $_questions->push(...$questions);
                $questions = $_questions;
            }
        }
        else
        {
            $questions = $questions->orderBy("created_at", "ASC");
        }

        if (!$questions instanceof Collection){
            $questions = $questions->get();
        }


        return view('pages.events.single', compact('event', 'questions', "colors"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::find($id) ?? abort(404);
        return view('pages.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, $id)
    {
        $event = Event::find($id) ?? abort(404);
        $event->name = $request->name;
        $event->description = $request->description;
        $event->adress = $request->adress;
        $event->date = $request->date;
        $event->time = $request->time;
        $event->created_user_id = Auth::user()->id;
        $save = $event->save();

        if ($save){
            return redirect()->route('event.edit', $id)->withSuccess('Etkinlik detayları başarıyla düzenlendi.');
        }else{
            return redirect()->route('event.edit', $id)->withSuccess('Etkinlik detayları düzenlenirken bir hata oluştu.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::where("id", $id)->where("created_user_id", Auth::user()->id)->count();
        if ($event){
            $questions_delete = Question::where("event_id", $id)->delete();
            $event_delete     = Event::where("id", $id)->where("created_user_id", Auth::user()->id)->delete();
        }else{
            return redirect()->back()->withSuccess("Yetkilendirme hatası.");
        }

        if (isset($event_delete)){
            if ($event_delete){
                return redirect()->back()->withSuccess("Etkinlik başarıyla silindi.");
            }else{
                return redirect()->back()->withSuccess("Etkinlik silinirken bir problem yaşandı.");
            }
        }
    }

}
