<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Event;
use App\Comment;
use App\EventImage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();
        return view('profile.approved')->with('events', $events);
    }

    public function approve($id)
    {
        $event = Event::all()->where('id', $id)->first();
        $event->approved = true;
        $event->save();
        return redirect()->back();
    }

    public function list()
    {
        $events = Event::all()
            ->where('approved', '=', true)
            ->where('public', '=', true);

        return $events;
    }

    public function approved()
    {
        $events = array();
        if (Auth::user()->organizer) {
            $event_ids = json_decode(Auth::user()->event_organizer);
            if ($event_ids == null) {
                return view('profile.waiting')->with('events', null);
            }
            foreach ($event_ids as $event_id) {
                $the_event = Event::all()
                    ->where('id', '=', $event_id)
                    ->where('approved', '=', true)
                    ->first();
                if ($the_event != null) {
                    array_push($events, $the_event);
                }
            }
        } else {
            $event_ids = json_decode(Auth::user()->event_client);
            if ($event_ids == null) {
                return view('profile.waiting')->with('events', null);
            }
            foreach ($event_ids as $event_id) {
                $the_event = Event::all()
                    ->where('id', '=', $event_id)
                    ->where('approved', '=', true)
                    ->first();
                if ($the_event != null) {
                    array_push($events, $the_event);
                }
            }
        }
        return view('profile.approved')->with('events', $events);
    }

    public function waiting()
    {
        $events = array();
        if (Auth::user()->organizer) {
            $event_ids = json_decode(Auth::user()->event_organizer);
            if ($event_ids == null) {
                return view('profile.waiting')->with('events', null);
            }
            foreach ($event_ids as $event_id) {
                $the_event = Event::all()
                    ->where('id', '=', $event_id)
                    ->where('approved', '=', false)
                    ->first();
                if ($the_event != null) {
                    array_push($events, $the_event);
                }
            }
        } else {
            $event_ids = json_decode(Auth::user()->event_client);
            if ($event_ids == null) {
                return view('profile.waiting')->with('events', null);
            }
            foreach ($event_ids as $event_id) {
                $the_event = Event::all()
                    ->where('id', '=', $event_id)
                    ->where('approved', '=', false)
                    ->first();
                if ($the_event != null) {
                    array_push($events, $the_event);
                }
            }
        }
        return view('profile.waiting')->with('events', $events);
    }

    public function storeShow(Request $request, Event $event)
    {
        //Show images public
        if ($request->has('show_images')) {
            $event = Event::all()->where('id', $event->id)->first();
            if($event->show_images){
                $event->show_images = false;
                $event->save();
                return back()->with('success', 'You are approved the event gallery to be private!');
            }
            $event->show_images = true;
            $event->save();
            return back()->with('success', 'You are approved the event gallery to be public!');
        }
        
        //Post comment
        if ($request->has('add_comment')) {
            $validateData = $request->validate([
                'comment' => 'min:5|max:500|required',
            ]);

            $commentData = array_merge($validateData, ['user_id' => auth()->id()]);
            $event->comments()->create($commentData);

            return back()->with('success', 'You have successfully posted a comment!');
        }

        //Post event picture
        if ($request->has('add_image')) {
            $image_path = $request->file('event_image');
            if ($image_path == null) {
                return back()->with('error', "You haven't specified an Image!");
            }
            $filename = time() . "." . $image_path->getClientOriginalExtension();
            Image::make($image_path)->save(public_path('storage/' . $filename));
            //$event->eventImages()->event_image = $filename;
            $imageArray = ['event_image' => $filename];

            $event->eventImages()->create($imageArray);
            return back()->with('success', 'You have successfully uploaded a picture!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()) {
            $users = User::all()->where('organizer', true);
            return view('events.create')->with('users', $users);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Session::flash('success', 'You have successfully created an event request please wait for response from the organizer!');

        $event = Event::create([
            'address' =>  $request['event_address'],
            'organizer' => $request['organizer'],
            'start_date' => date_format(date_create($request['start_date']), 'Y-m-d'),
            'end_date' => date_format(date_create($request['end_date']), 'Y-m-d'),
            'client' => Auth::user()->username,
            'name' => $request['event_name'],
            'public' => ($request['public'] == 'true' ? true : false),
            'description' => $request['event_description'],
            'show_images' => false,
            'approved' => false,
        ]);

        $organizer_user = User::all()->where('username', $request['organizer'])->first();
        $this->save_organizer_event($organizer_user, $event);

        $client_user = User::all()->where('username', Auth::user()->username)->first();
        $this->save_client_event($client_user, $event);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $user = Auth::user();
        $eventImages = EventImage::where('event_id', $event->id);
        $comments = Comment::where('event_id', $event->id)->latest()->paginate(5);
        return view('events.show', compact('event', 'comments', 'eventImages', 'user'));
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
        $comment = Comment::where('id', $id)->first();

        if ($comment != null) {
            $comment->delete();
            return back()->with('success', 'You have successfully deleted your comment!');
        }

        return back()->with('error', 'You can\'t delete your comment!');
    }

    private function save_organizer_event($user, $event)
    {
        if ($user->event_organizer == null) {
            $user->event_organizer = json_encode(array($event->id));
        } else {
            $array_events = json_decode($user->event_organizer, true);
            array_push($array_events, $event->id);
            $user->event_organizer = json_encode($array_events);
        }
        $user->save();
    }


    private function save_client_event($user, $event)
    {
        if ($user->event_client == null) {
            $user->event_client = json_encode(array($event->id));
        } else {
            $array_events = json_decode($user->event_client, true);
            array_push($array_events, $event->id);
            $user->event_client = json_encode($array_events);
        }
        $user->save();
    }
}
