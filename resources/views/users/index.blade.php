@extends('master')

@section('title', 'List users')

@section('content')
    @auth
        <form action="{{route('users.index')}}" method="GET" role="search">
            <div class="input-group">
                <input type="text" class="form-control" name="name"
                       placeholder="Search "> <span class="input-group-btn">
            <button type="submit" class="btn btn-default">
                <span class="glyphicon glyphicon-search"></span>
            </button>
        </span>
            </div>
            <div class="form-group">
                <label for="UserType">Type</label>
                <select name="type" id="type" class="form-control">
                    <option disabled selected> -- select an option --</option>
                    <option value="normal">Client</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>
            <div class="form-group">
                <label for="statusType">StatusType</label>
                <select name="status" id="status" class="form-control">
                    <option disabled selected> -- select an option --</option>
                    <option value="unblocked">Unblock</option>
                    <option value="blocked">Block</option>
                </select>
            </div>
        </form>
        @if (count($users))
            <table class="table table-striped" style="background: #cce5ff">
                <thead>
                <tr>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Registered At</th>
                    <th>Admin</th>
                    <th>Blocked</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            <div class="form-group">
                                @if ($user->admin)
                                    <span class="user-is-admin"></span>
                                    <form  method="post" action="{{route('users.demote', $user->id)}}">
                                        @csrf
                                        {{ method_field('PATCH') }}
                                        <button type="submit" class="btn btn-xs btn-danger">Demote</button>
                                    </form>
                                @else
                                    <form method="post" action="{{route('users.promote', $user->id)}}">
                                        @csrf
                                        {{ method_field('PATCH') }}
                                        <button type="submit" class="btn btn-xs btn-success">Promote</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                @if ($user->blocked)
                                    <span class="user-is-blocked"></span>
                                    <form  method="post" action="{{route('users.unblock', $user->id)}}">
                                        @csrf
                                        {{ method_field('PATCH') }}
                                        <button type="submit" class="btn btn-xs btn-success">Unblock</button>
                                    </form>
                                @else
                                    <form method="post" action="{{route('users.block', $user->id)}}">
                                        @csrf
                                        {{ method_field('PATCH') }}
                                        <button type="submit" class="btn btn-xs btn-danger">Block</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <h2>No users found</h2>
            @endif
    @endauth
@endsection