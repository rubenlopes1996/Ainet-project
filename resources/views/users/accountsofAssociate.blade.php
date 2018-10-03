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

            </tr>
            </thead>
            @foreach ($accounts as $account)
                @if(count($accounts))

                    <tbody>

                    <tr>
                        <td>{{ $account->accounts_user->name }}</td>
                        <td>{{ $account->associated_account_type->name}}</td>
                        <td>{{ $account->date }}</td>
                        <td>{{ $account->description }}</td>
                        <td>{{ $account->current_balance }}</td>
                        <td>{{ $account->code }}</td>
                        <td>{{ $account->created_at }}</td>
                        <td>
                            <form method="get" action="{{route('showMovements',$account->id)}}">
                                <button type="submit" class="btn btn-primary">Show account</button>
                            </form>
                        </td>
                    </tr>

                @endif
            @endforeach
        </table>
    @endauth
@endsection
