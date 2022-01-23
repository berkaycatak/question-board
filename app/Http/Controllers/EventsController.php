<?php

namespace App\Http\Controllers;

use App\Http\Requests\Main\Event\EventRequest;
use App\Models\Event;
use App\Models\Question;
use Illuminate\Http\Request;
use Auth;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::get();
        return view('pages.events.list', compact('events'));
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
    public function show($id)
    {
        $event = Event::join('users', 'users.id', 'events.created_user_id')
            ->select('users.id as user_id', 'users.name as user_name', 'users.profile_photo_path as user_profile_photo_path',  'events.*')
            ->where('events.id', $id)
            ->first();

        $questions = Question::where('questions.event_id', $id)->get();

        return view('pages.events.single', compact('event', 'questions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
