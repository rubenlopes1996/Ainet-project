@extends('master')

@section('title', 'List users')

@section('content')
    @auth

        @if (count($users))
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Email</th>
                    <th>Fullname</th>
                    <th>Registered At</th>
                    <th>Type</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->typeToStr() }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->isBlocked() }}</td>
                        @if(@Auth::user()->id!=$user->id)
                            @if($user->blocked==0)
                                <td>
                                    <form method="post" action="{{route('users.block',$user->id)}}">
                                        @csrf
                                        @method('patch')
                                        <button type="submit" class="btn btn-primary">Block</button>
                                    </form>
                                </td>
                            @endif
                            @if($user->blocked==1)
                                <td>
                                    <form method="post" action="{{route('users.unblock',$user->id)}}">
                                        @csrf
                                        @method('patch')


                                        <button type="submit" class="btn btn-primary">Unblock</button>
                                    </form>
                                </td>
                            @endif
                            @if($user->admin==0)
                                <td>
                                    <form method="post" action="{{route('users.promote',$user->id)}}">
                                        @csrf
                                        @method('patch')


                                        <button type="submit" class="btn btn-primary">Promote</button>
                                    </form>
                                </td>
                            @endif
                            @if($user->admin==1)
                                <td>
                                    <form method="post" action="{{route('users.demote',$user->id)}}">
                                        @csrf
                                        @method('patch')
                                        <button type="submit" class="btn btn-primary">Demote</button>
                                    </form>
                                </td>
                            @endif
                        @endif

                    </tr>
                @endforeach
            </table>
        @endauth
    @else
        <h2>No users found</h2>
    @endif
@endsection
