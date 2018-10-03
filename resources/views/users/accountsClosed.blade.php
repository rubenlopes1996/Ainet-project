@extends('master')

@section('title', 'Accounts of the user')

@section('content')
    @auth
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Account type</th>
                <th>Date</th>
                <th>Description</th>
                <th>Current balance</th>
                <th>Code</th>
                <th>Created at</th>
                <th>Deleted at</th>

            </tr>
            </thead>
        @foreach ($accounts as $account)
            @if($account->owner_id == @Auth::user()->id)
                @if($account->deleted_at != null)
                        <tbody>

                        <tr>
                            <td>{{ $account->accounts_user->name }}</td>
                            <td>{{ $account->associated_account_type->name}}</td>
                            <td>{{ $account->date }}</td>
                            <td>{{ $account->description }}</td>
                            <td>{{ $account->current_balance }}</td>
                            <td>{{ $account->code }}</td>
                            <td>{{ $account->created_at }}</td>
                            <td>{{ $account->deleted_at }}</td>
                            <td>
                                <form method="post" action="{{route('openSpecific.account',$account->id)}}">
                                    @csrf
                                    @method('patch')
                                    <button type="submit" class="btn btn-primary">Open</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endif

            @endforeach
        </table>
    @endauth
@endsection
