@extends('layouts.app')

@section('content')

    <div class="container">


        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @if(!empty($user->profile_photo))
                    <img src="storage/profiles/{{ $user->profile_photo}}"
                         style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;">
                @else

                    <td><img src="uploads/avatars/default.jpg"
                             style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;"></td>
                @endif
                <h2>{{ $user->name }} Profile</h2>
                <td>
                    <a class="btn btn-primary" href="{{route('profile.password')}}"> Change Password </a>
                </td>
                <td>
                    <a class="btn btn-primary" href="{{route('profile.me')}}"> Edit Profile </a>
                </td>

                <td>
                    <form method="get" action="{{route('profiles')}}">
                        <button type="submit" class="btn btn-primary">Show all users</button>
                    </form>
                </td>
                <td>
                    <form method="get" action="{{route('accounts',$user->id)}}">
                        <button type="submit" class="btn btn-primary">Show all accounts</button>
                    </form>
                </td>
                <td>
                    <form method="get" action="{{route('opened.accounts',$user->id)}}">
                        <button type="submit" class="btn btn-primary">Show all opened accounts</button>
                    </form>
                </td>
                <td>
                    <form method="get" action="{{route('closed.accounts',$user->id)}}">
                        <button type="submit" class="btn btn-primary">Show all closed accounts</button>
                    </form>
                </td>
                <td>
                    <form method="get" action="{{route('associate',$user)}}">
                        <button type="submit" class="btn btn-primary">Show all associates</button>
                    </form>
                </td>
                <td>
                    <form method="get" action="{{route('associate_of',$user)}}">
                        <button type="submit" class="btn btn-primary">Show all associates of</button>
                    </form>
                </td>
                <td>

                    <form method="get" action="{{route('createAccount')}}">
                        <button type="submit" class="btn btn-primary">Create Account</button>
                    </form>
                </td>

                    <form method="get" action="{{route('showStatistics',$user->id)}}">
                        <button type="submit" class="btn btn-primary">Statistics</button>
                    </form>

            </div>
        </div>
    </div>
@endsection
