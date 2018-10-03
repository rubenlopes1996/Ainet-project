@extends('master')

@section('title', 'Edit account')

@section('content')

    @if ($errors->any())
        @include('partials.errors')
    @endif

    <form action="{{route('updateAccount', $account->id)}}" method="post" class="form-group">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="account_type_id">Type</label>
            <select id="account_type_id" type="text"
                    class="form-control"
                    name="account_type_id" value="{{ old('account_type_id') }}">
                <option disabled selected> -- select an option --</option>
                <option value="1">Bank account</option>
                <option value="2">Pocket money</option>
                <option value="3">PayPal account</option>
                <option value="4">Credit card</option>
                <option value="5">Meal card</option>
            </select>

        </div>

        <div class="form-group">
            <label for="code">Code</label>
            <input id="code" type="text"
                   class="form-control"
                   name="code" value="{{ old('code',$account->code) }}">

        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <input id="description" type="text"
                   class="form-control"
                   name="description" value="{{ old('description',$account->description) }}">

        </div>


        <div class="form-group">
            <label for="start_balance">Start Balance</label>
            <input id="start_balance" type="text" class="form-control" name="start_balance"
                   value="{{ old('start_balance',$account->start_balance) }}">

        </div>


        <div class="form-group">
            <button type="submit" class="btn btn-success" name="ok">Save</button>
            <a class="btn btn-default" href="{{route('profile')}}">Cancel</a>
        </div>
        </div>
    </form>
@endsection
