<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware(['auth' => 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $host = $request->getHttpHost();

        if (Auth::user() && auth()->user()->organizer == false) {
            $events = Event::all()
                ->where('approved', '=', true)
                ->where('client', '=', auth()->user()->username);
        } else if (Auth::user() && auth()->user()->organizer) {
            $events = Event::all()
                ->where('approved', '=', true)
                ->where('organizer', '=', auth()->user()->username);
            //->orWhere('public', '=', true);
        } else {
            $events = Event::where('approved', '=', true)->where('public', '=', true);
        }

        $eventArray = array();
        foreach ($events as $event) {
            $eventArray[] = array(
                'id' => $event->id,
                'title' => $event->name,
                'start' => $event->start_date,
                'end' => $event->end_date,
                'url' => 'http://' . $host . '/events/show/' . $event->id,
            );
        }
        return view('home', compact('eventArray'));
    }
}
