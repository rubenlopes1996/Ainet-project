@extends('master')

@section('title', 'Change password')

@section('content')
    @if ($errors->any())
        @include('partials.errors')
    @endif
    <form action="{{route('profile.password', $user->id)}}" method="post" class="form-group">
        @csrf
        @method('patch')


        <div class="form-group">
            <label for="inputPassword">Old Password</label>
            <input
                    type="password" class="form-control"
                    name="old_password" id="inputOldPassword"
            />


            <div class="form-group">
                <label for="inputPassword">Password</label>
                <input
                        type="password" class="form-control"
                        name="password" id="inputPassword"
                />
            </div>
            <div class="form-group">
                <label for="inputPasswordConfirmation">Password confirmation</label>
                <input
                        type="password" class="form-control"
                        name="password_confirmation" id="inputPasswordConfirmation"/>
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a class="btn btn-default" href="{{route('profile')}}">Cancel</a>
            </div>
    </form>
@endsection
