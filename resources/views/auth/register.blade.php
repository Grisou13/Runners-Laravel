@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}
                        <!-- FIRST NAME ..........................................................-->
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="col-md-4 control-label">First name</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- LAST NAME ..........................................................-->
                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label">Last name</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autofocus>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- SHORTNAME ..........................................................-->
                        <div class="form-group{{ $errors->has('shortname') ? ' has-error' : '' }}">
                            <label for="shortname" class="col-md-4 control-label">Shortname</label>

                            <div class="col-md-6">
                                <input id="shortname" type="text" class="form-control" name="shortname" value="{{ old('shortname') }}" required autofocus>

                                @if ($errors->has('shortname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('shortname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- EMAIL ADDRESS ..........................................................-->
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- PHONE ..........................................................-->
                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Telephon number</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required autofocus>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- SEX ..........................................................-->
                        <div class="form-group{{ $errors->has('sex') ? ' has-error' : '' }}">
                            <label for="sex" class="col-md-4 control-label">Sex</label>

                            <div class="col-md-6">
                                <select id="sex" class="form-control" name="sex" required autofocus>
                                  <option selected disabled>Select a sex</option>
                                  <option value="0">Female</option>
                                  <option value="1">Male</option>
                                </select>

                                @if ($errors->has('sex'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sex') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- STATUS ..........................................................-->
                        <div class="form-group{{ $errors->has('qr_code') ? ' has-error' : '' }}">
                            <label for="stat" class="col-md-4 control-label">Status</label>

                            <div class="col-md-6">
                                <input id="stat" type="text" class="form-control" name="stat" value="{{ old('stat') }}" required autofocus>


                                @if ($errors->has('qr_code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('qr_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- QR CODE ..........................................................-->
                        <div class="form-group{{ $errors->has('qr_code') ? ' has-error' : '' }}">
                            <label for="qr_code" class="col-md-4 control-label">QR Code</label>

                            <div class="col-md-6">
                                <input id="qr_code" type="text" class="form-control" name="qr_code" value="{{ old('qr_code') }}" required autofocus>


                                @if ($errors->has('qr_code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('qr_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- PASSWORD ..........................................................-->
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- CONFIRM PASSWORD ..........................................................-->
                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
