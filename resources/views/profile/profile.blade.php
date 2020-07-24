@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container">
    <div class="col-md-12 justify-content-center">
        <div class="row text-center">
            <div class="col-md-3 p-5">
                <img src="{{ url($user->image) }}" style="width:120px; height:120px;" class="rounded-circle w-70">
            </div>
            <div class="col-md-9 align-self-center">
                <h2>{{ $user->username }}</h2>
            </div>
        </div>

        <div class="row">
            <div class="text-center col-md-3">
                <div>
                    <button type="button" class="btn mb-2 btn-primary btn-block" data-toggle="modal" data-target="#profileModal">
                        Edit profile
                    </button>
                </div>

                <div>
                    <button type="button" class="btn mb-2 btn-primary btn-block" data-toggle="modal" data-target="#imageModal">
                        Change picture
                    </button>
                </div>

                <div>
                    <button type="button" class="btn mb-2 btn-primary btn-block" data-toggle="modal" data-target="#passwordModal">
                        Change password
                    </button>
                </div>
            </div>

            <div class="col-md-9 text-center">
                <div class="text-center border-top pt-3 pb-2">
                    <h4>User Details</h4>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="font-weight-bold pb-1">Account type</div>

                        <div>
                            <label for="organizer">
                                <!-- to be more understanding -->
                                @if($user->organizer == false) 
                                Client
                                @else
                                Organizer
                                @endif
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="font-weight-bold pb-1">Email address</div>

                        <div>
                            <label for="email">{{ $user->email }}</label>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <div class="font-weight-bold pb-1">First name</div>

                        <div>
                            <label for="firstname">{{ $user->firstname }}</label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="font-weight-bold pb-1">Last name</div>

                        <div>
                            <label for="lastname">{{ $user->lastname }}</label>
                        </div>
                    </div>
                </div>

                <div class="text-center border-top pt-3 pb-2">
                    <h5>Address</h5>
                </div>

                <div class="form-row">
                    <div class="col-md-5 mb-3">
                        <div class="font-weight-bold pb-1">Country</div>

                        <div>
                            <label for="country">{{ $user->address->country }}</label>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="font-weight-bold pb-1">City</div>

                        <div>
                            <label for="city">{{ $user->address->city }}</label>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="font-weight-bold pb-1">Zip</div>

                        @if ($user->address->zip == null)
                        <div>
                            <label for="line_2">No zip added</label>
                        </div>
                        @else
                        <div>
                            <label for="zip">{{ $user->address->zip }}</label>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="font-weight-bold pb-1">Address line 1</div>
                        <div>
                            <label for="line_1">{{ $user->address->line_1 }}</label>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="font-weight-bold pb-1">Address line 2</div>

                        @if ($user->address->line_2 == null)
                        <div>
                            <label for="line_2">No address added</label>
                        </div>
                        @else
                        <div>
                            <label for="line_2">{{ $user->address->line_2 }}</label>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Profile update modals -->
        @include('layouts.modals.profile_image')
        @include('layouts.modals.profile_password')
        @include('layouts.modals.profile_update')
        <!-- /Profile update modals -->
    </div>
</div>
@endsection