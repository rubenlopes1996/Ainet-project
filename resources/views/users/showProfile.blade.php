@extends('master')

@section('title', 'List users')

@section('content')
    @auth
        @if (count($users))
            <form action="{{route('profiles')}}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" name="name"
                           placeholder="Search "> <span class="input-group-btn">
            <button type="submit" class="btn btn-default">
                <span class="glyphicon glyphicon-search"></span>
            </button>
                </span>
                </div>

            </form>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Photo</th>
                    <th>Fullname</th>
                    <th>Associates</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        @if(!empty($user->profile_photo))
                            <td><img src="{{asset('storage/profiles/'.$user->profile_photo)}}}}"
                                     style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;">
                            </td>
                        @else
                            <td><img src="uploads/avatars/default.jpg"
                                     style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;">
                            </td>
                        @endif
                        <td>{{ $user->name }}</td>
                        <td>
                            @if($user->associated->contains(Auth::id()))
                                <span>Associate-of</span>

                            @endif
                        </td>

                        <td>
                            @if($user->associated_members->contains(Auth::id()))
                                <span>Associate</span>
                            <td>
                                <form method="post" action="{{route('removeAssociate',$user->id)}}">
                                    @csrf
                                    <button type="submit" class="btn btn-xs btn-danger">Remove associate</button>
                                </form>
                            </td>
                            @else

                            <td>
                                <form method="post" action="{{route('addAssociate',$user->id)}}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$user->id}}">
                                    <button type="submit" class="btn btn-xs btn-success">Add associate</button>
                                </form>
                            </td>
                            @endif
                        </td>




                    </tr>
                @endforeach
                </tbody>
            </table>
        @endauth
    @else
        <h2>No users found</h2>
    @endif
@endsection
