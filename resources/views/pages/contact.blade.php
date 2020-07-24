@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<div class="container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-10">
                        <form method="POST" action="{{ route('contact.store') }}">
                            @csrf

                            <div class="text-center pt-3 pb-2 mb-3">
                                <h1>{{ __('Contact Us') }}</h1>
                            </div>

                            @if(Session::has('contact-us'))
                            <div class="alert alert-success text-center col-md-8 mb-3 offset-md-2">
                                {{ Session::get('contact-us') }}
                            </div>
                            @endif

                            <div class="form-group">
                                <div class="col-md-8 mb-3 offset-md-2">
                                    @guest
                                    @if (Route::has('register'))
                                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Work email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @endif
                                    @else
                                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Work email" name="email" value="{{ old('email') ?? auth()->user()->email }}" required autocomplete="email" autofocus>
                                    @endguest

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 mb-3 offset-md-2">
                                    <select name="subject" class="form-control custom-select mb-3" id="subject" required>
                                        <option value="" disabled selected hidden>What's this about?</option>
                                        <option value="Something1">Something1</option>
                                        <option value="Something2">Something2</option>
                                        <option value="Something3">Something3</option>
                                    </select>

                                    @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 mb-3 offset-md-2">
                                    <textarea class="form-control" name="mailMessege" id="mailMessege" rows="10" placeholder="Go ahead, we're listening..." value="{{ old('message') }}" required></textarea>

                                    @error('mailMessege')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-lg btn-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-2 align-self-center">
                        <div>
                            <label for="email">Email:</label>

                            <div>
                                <label for="email">admin@evento.com</label>
                            </div>
                        </div>

                        <div>
                            <label for="phone">Phone</label>

                            <div>
                                <label for="phone">+359888666600</label>
                            </div>
                        </div>

                        <div>
                            <label for="address">Address:</label>

                            <div>
                                <label for="address">No address added</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection