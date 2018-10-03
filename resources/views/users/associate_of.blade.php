@extends('master')

@section('title', 'List users')

@section('content')
    @auth
        @if (count($users))
            <form action="{{route('profiles')}}" method="GET" role="search">
                @csrf
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
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Accounts</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{route('accounts',$user->id)}}" type="button" class="btn btn-default">Account</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        @endauth
    @else
        <h2>No users found</h2>
    @endif
@endsection
