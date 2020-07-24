@extends('layouts.app')

@section('title', 'events')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="text-center pt-3 pb-2 mb-3">
                <h1>{{ __('EventO') }}</h1>
            </div>

            <div class="row justify-content-center mb-3">
                <div class="col-md-12">
                    <div class="text-center">
                        <h4>Check our public events</h4>
                    </div>
                    @if (auth()->user() && auth()->user()->organizer == false)
                    <div class="float-md-right">
                        <a href="{{ route('event.create') }}" class="btn btn-lg btn-primary">Create event</a>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-md-12">
                <div id="calendar"></div>
            </div>

        </div>
    </div>
    <script>
        var eventArray = @json($eventArray, JSON_PRETTY_PRINT);
    </script>
    @endsection