<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    public function index(){
        $events = Event::where("created_user_id", Auth::user()->id)->get();
        return view('dashboard', compact("events"));
    }
}
