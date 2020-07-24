 <!-- User Update Modal -->
 <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title text-center" id="passwordModalLabel">Edit user details</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>

             <form role="form" method="POST" action="{{ route('profile.update', auth()->user()->id) }}" autocomplete="off">
                 @method('PATCH')

                 @csrf

                 <div class="modal-body">
                     <div class="form-row">
                         <div class="col-md-12 mb-3">
                             <label for="email">{{ __('Email address') }}</label>

                             <div>
                                 <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') ?? $user['email'] }}" required autocomplete="email" autofocus>

                                 @error('email')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                             </div>
                         </div>
                     </div>

                     <div class="form-row">
                         <div class="col-md-6 mb-3">
                             <label for="firstname">{{ __('First name') }}</label>

                             <div>
                                 <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" placeholder="First name" name="firstname" value="{{ old('firstname') ?? $user['firstname'] }}" required autocomplete="firstname" autofocus>

                                 @error('firstname')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                             </div>
                         </div>

                         <div class="col-md-6 mb-3">
                             <label for="lastname">{{ __('Last name') }}</label>

                             <div>
                                 <input id="lastname" value="{{ $user['lastname'] }}" type="text" class="form-control @error('lastname') is-invalid @enderror" placeholder="First name" name="lastname" value="{{ old('lastname') ?? $user['lastname'] }}" required autocomplete="lastname" autofocus>

                                 @error('lastname')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                             </div>
                         </div>
                     </div>

                     <p class="text-center">Address</p>
                     <hr>

                     <div class="form-row">
                         <div class="col-md-6 mb-3">
                             <label for="country">Country</label>
                             @include('layouts.country')
                         </div>

                         <div class="col-md-3 mb-3">
                             <label for="city">{{ __('City') }}</label>

                             <div>
                                 <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" placeholder="City" name="city" value="{{ old('city') ?? $user->address['city'] }}" required autocomplete="city" autofocus>

                                 @error('city')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                             </div>
                         </div>
                         <div class="col-md-3 mb-3">
                             <label for="zip">{{ __('Zip') }}</label>

                             <div>
                                 <input id="zip" type="number" class="form-control @error('zip') is-invalid @enderror" placeholder="zip" name="zip" value="{{ old('zip') ?? $user->address['zip'] }}" autocomplete="zip" autofocus>

                                 @error('zip')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                             </div>
                         </div>
                     </div>

                     <div class="form-row">
                         <div class="col-md-12 mb-3">
                             <label for="line_1">{{ __('Line 1') }}</label>

                             <div>
                                 <input id="line_1" type="text" class="form-control @error('line_1') is-invalid @enderror" placeholder="Address line *" name="line_1" value="{{ old('line_1') ?? $user->address['line_1'] }}" required autocomplete="line_1" autofocus>

                                 @error('line_1')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                             </div>
                         </div>
                     </div>

                     <div class="form-row">
                         <div class="col-md-12 mb-3">
                             <label for="line_2">{{ __('Line 2') }}</label>

                             <div>
                                 <input id="line_2" type="text" class="form-control @error('line_2') is-invalid @enderror" placeholder="Address line 2" name="line_2" value="{{ old('line_2') ?? $user->address['line_2'] }}" autocomplete="line_2" autofocus>

                                 @error('line_2')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="submit" id="update_profile" name="update_profile" class="btn btn-primary">Update profile</button>
                 </div>
             </form>
         </div>
     </div>
 </div>