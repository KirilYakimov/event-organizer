@extends('layouts.app')

@section('title', 'Event')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="text-center">
                <h1>{{ $event->name }}</h1>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <a class="text-primary" href="{{ url('home') }}">Back to callendar</a>
            </div>

            <div class="container p-6">
                <div class="row">
                    <div class="border bg-white">
                        <p class="m-0 m-3">Event name: {{ $event->name }}</p>
                        <p class="m-0 m-3">Event type: {{ $event->public ? "Public" : "Private"}}</p>
                        <p class="m-0 m-3">Organizer: {{ $event->organizer }}</p>
                        <p class="m-0 m-3">Date: {{ date( 'F j, Y, H:i', strtotime($event->start_date)) }} </p>
                        <p class="m-0 m-3">Number of people: </p>
                        <p class="m-0 m-3">Menu type: </p>
                        <p class="m-0 m-3">Location: {{ $event->address }}</p>
                        <p class="m-0 m-3">Description: {{ $event->description }} </p>
                    </div>
                </div>

                @if (!$event->eventImages->isEmpty() && ((auth()->user()->username == $event->organizer || auth()->user()->username == $event->client) || $event->show_images == true))
                <div class="row card shadow-lg d-flex flex-row bd-highlight bg-white mt-2" id="image">
                    @foreach($event->eventImages as $eventImage)
                    <a href="#eventImage" data-toggle="modal" data-target="#eventImage">
                        <img class="rounded-circle m-3" data-toggle="modal" src="{{ asset('storage/'.$eventImage->event_image) }}" style="width:100px; height:100px;" alt="event picture">
                    </a>
                    @endforeach
                </div>
                @else
                <div class="row card shadow-lg bg-white mt-2">
                    <div class="card-body text-center">
                        <div class="card-title pt-2 mb-2">
                            @if(auth()->user()->username == $event->organizer && strtotime($event->end_date) > time())
                            <h3>The event must be over before you upload pictures!</h3>
                            @else
                            <h3>This event has no pictures yet!</h3>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Only organizers can upload pictures -->
                @if (auth()->user())
                @if (auth()->user()->username == $event->organizer && strtotime($event->end_date) < time()) <form class="row" role="form" method="POST" action="{{ route('event_view.store', $event->id ) }}" enctype="multipart/form-data" autocomplete="off">
                    @method('POST')
                    @csrf
                    <div class="custom-file bg-white mt-2 mb-2">
                        <input type="file" class="custom-file-input" id="image" name="add_image">
                        <label class="custom-file-label" for="add_image">Upload image to event</label>
                    </div>
                    <div class="col-md-12 text-center">
                        <button type="submit" id="add_image" name="add_image" class="btn btn-primary">Upload</button>
                    </div>
                    </form>

                    @endif
                    <!-- Make gallery public -->
                    @if (!$event->eventImages->isEmpty() && auth()->user()->username == $event->client)
                    <form role="form" class="col-md-12 text-center" method="POST" action="{{ route('event_view.store', $event->id ) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="btn-group m-2" role="group">
                            @if ($event->show_images)
                            <button class="btn btn-danger ml-1" id="show_images" name="show_images" type="submit">Make gallery private</button>
                            @else
                            <button class="btn btn-primary ml-1" id="show_images" name="show_images" type="submit">Make gallery public</button>
                            @endif
                        </div>
                    </form>
                    @endif
                    @endif
                    <!-- /Make gallery public -->

                    @if(auth()->user())

                    @if (!empty($comments))
                    <div class="row card p-2 mt-2">
                        <!-- Write a comment -->
                        <form role="form" class="border p-3 bg-light" method="POST" action="{{ route('event_view.store', $event->id ) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="input-group d-flex">
                                <div class="d-flex flex-row bd-highlight">
                                    <img class="rounded-circle" src="{{ asset(auth()->user()->image) }}" style="width:50px; height:50px;" alt="profile picture">
                                </div>
                                <div class="flex-grow-1 bd-highlight">
                                    <input type="text" class="form-control ml-1 mt-2" name="comment" placeholder="Write a comment...">
                                </div>

                                <div class="btn-group m-2" role="group" aria-label="Basic">
                                    <button class="btn btn-primary ml-1" id="add_comment" name="add_comment" type="submit">Comment</button>
                                </div>
                            </div>
                        </form>
                        <!--/ Write a comment -->

                        @forelse($comments as $comment)
                        <blockquote class="blockquote ml-5 mt-2">
                            <div class="d-flex flex-row">
                                <a href=""><img class="rounded-circle" style="width:50px; height:50px;" src="{{ asset($comment->user->image) }}" alt="..."></a>
                            </div>

                            <a class="text-primary" href='#'>{{ $comment->user->username }}</a>
                            <div class="border bg-white p-3"> {{ $comment->comment }} </div>
                            <footer class="blockquote-footer d-flex flex-row mt-2">
                                <div class="w-100 bd-highlight">{{ date( 'F j, Y, g:i a', strtotime($comment->created_at)) }}</div>
                                @if($comment->user_id == auth()->user()->id)
                                <form method="post" action="{{ route('event_view.delete', $comment->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-primary" type="submit">Delete</button>
                                </form>
                                @endif
                            </footer>
                        </blockquote>
                        @empty
                        <div class="card shadow-lg bg-white">
                            <div class="card-body text-center">
                                <div class="card-title pt-3 pb-2 mb-2">
                                    <h3>This event has no comments yet!</h3>
                                </div>
                            </div>
                        </div>
                        @endforelse
                        <!--/ Users coments -->
                        <div class="col-12 row d-flex justify-content-center">
                            {{ $comments->links() }}
                        </div>
                    </div>
                    @endif
                    @endif
            </div>
        </div>
        <!-- Event image modal -->
        @include('layouts.modals.event_image')
        <!-- /Event image modal-->
    </div>
</div>
@endsection