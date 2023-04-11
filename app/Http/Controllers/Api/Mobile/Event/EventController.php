<?php

namespace App\Http\Controllers\Api\Mobile\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\Main\Event\EventRequest;
use App\Models\Event;
use App\Models\Question;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function list(Request $request){
        try {
            $coming_events   = Event::with('creator_user')->where('is_live', '1')->where('date', ">=", date('Y-m-d'))->orderBy("id" ,'DESC')->get();
            $past_events     = Event::with('creator_user')->where('is_live', '1')->where('date', "<", date('Y-m-d'))->orderBy("id", 'DESC')->get();

            return [
                "status" => 1,
                "events" => [
                    "coming" => $coming_events,
                    "past"   => $past_events
                ]
            ];
        }catch (\Exception $exception){
            return [
                "status" => 0,
                "errors" => $exception->getMessage()
            ];
        }
    }

    public function show($id, Request $request){
        try {
            $event   = Event::with(
            'creator_user',
                    "questions",
                    'questions.user',
                    'questions.votes',
                )
                ->find($id);

            return [
                "status" => 1,
                "event" => $event
            ];
        }catch (\Exception $exception){
            return [
                "status" => 0,
                "errors" => $exception->getMessage()
            ];
        }
    }

    public function store(EventRequest $request){
        try {
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
                return [
                    "status" => 1,
                    "event" => $event
                ];
            }
        }catch (\Exception $exception){
            return [
                "status" => 0,
                "errors" => $exception->getMessage()
            ];
        }
    }

    public function update($id, EventRequest $request){
        try {
            $event = Event::find($id) ?? false;
            if (is_bool($event))
                throw new Exception('Düzenlenmek istenen etkinlik bulunamadı.');

            if ($event->created_user_id != Auth::user()->id)
                throw new Exception('Düzenlenmek istenen etkinlik bulunamadı.');

            $event->name = $request->name;
            $event->description = $request->description;
            $event->adress = $request->adress;
            $event->date = $request->date;
            $event->time = $request->time;
            $event->created_user_id = Auth::user()->id;
            $save = $event->save();

            if ($save){
                return [
                    "status" => 1,
                    "event" => $event
                ];
            }
        }catch (\Exception $exception){
            return [
                "status" => 0,
                "errors" => $exception->getMessage()
            ];
        }
    }

    public function delete($id, Request $request){
        try {
            $event = Event::find($id) ?? false;
            if (is_bool($event))
                throw new Exception('Silinmek istenen etkinlik bulunamadı.');

            if ($event->created_user_id != Auth::user()->id)
                throw new Exception('Silinmek istenen etkinlik bulunamadı.');

            $questions_delete = Question::where("event_id", $id)->delete();
            $event_delete     = Event::where("id", $id)->where("created_user_id", Auth::user()->id)->delete();

            return [
                "status" => 1,
                "messages" => "Etkinlik başarıyla silindi."
            ];

        }catch (\Exception $exception){
            return [
                "status" => 0,
                "errors" => $exception->getMessage()
            ];
        }
    }
}
