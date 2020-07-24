@extends('layouts.app')

@section('title', 'Create Event')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="text-center pt-3 pb-2 mb-3">
                <h1>{{ __('EventO') }}</h1>
            </div>

            @if (auth()->user() && auth()->user()->organizer == false)
            <form method="POST" action="{{ route('event.create') }}" id='theform'>
                @csrf
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="event_name">{{ __('Event Name') }}</label>
                        <div>
                            <input id="event_name" type="text" class="form-control @error('name') is-invalid @enderror" id="validationServer02" placeholder="Event Name" name="event_name" required autocomplete="event_name" autofocus>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date">{{ __('Start date') }}</label>
                        <div>
                            <input id="start_date" type="text" class="cusDate form-control @error('start_date') is-invalid @enderror" placeholder="Start date" name="start_date" required autofocus>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_date">{{ __('End date') }}</label>
                        <div>
                            <input id="end_date" type="text" class="cusDate form-control @error('end_date') is-invalid @enderror" placeholder="End date" name="end_date" required autofocus>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="event_address">{{ __('Event Address') }}</label>

                        <div class='input-group date' id='datepicker' s>
                            <input id="event_address" type="text" class="form-control @error('address') is-invalid @enderror" id="validationServer02" placeholder="Event Address" name="event_address" required autocomplete="event_address" autofocus>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>

                    </div>
                </div>
                <div class="form-group">
                    <label for="event_description">{{ __('Event Description') }}</label>
                    <div class="col-md-14 mb-3">
                        <textarea name="event_description" id="event_description" rows="10" class="form-control @error('description') is-invalid @enderror" placeholder="Describe your event in detail..." form="theform" required>
                        </textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="font-weight-bold pb-1 mb-2">{{ __('Organizer') }}</div>
                    <select name="organizer" class="custom-select mb-3" id="organizer" required>
                        <!-- Foreach user with organizer == true -->
                        @foreach ($users as $user)
                        <option value="{{ $user->username }}">{{ $user->username }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-row">
                    <div class="font-weight-bold pb-1 mb-2">{{ __('Event Type') }}</div>
                    <select name="public" class="custom-select mb-3" id="public" required>
                        <!-- Foreach user with organizer == true -->
                        <option value="true">Public</option>
                        <option value="false">Private</option>
                    </select>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-lg btn-primary">
                            {{ __('Create') }}
                        </button>
                    </div>
                </div>
            </form>
            @else
            <div class="text-center pt-3 pb-2 mb-3">
                <h1>Sorry only clients can create events</h1>
            </div>
            <div class="col-md-12 text-center">
                <a class="btn btn-lg btn-primary" href="{{ url('home') }}">Back to callendar</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection