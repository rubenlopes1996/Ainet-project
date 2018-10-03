@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create account</div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('saveAccount', $account) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="account_type_id">Type</label>
                                <select id="account_type_id" type="text"
                                       class="form-control{{ $errors->has('account_type_id') ? ' is-invalid' : '' }}"
                                       name="account_type_id" value="{{ old('account_type_id') }}" >
                                    <option disabled selected> -- select an option --</option>
                                    <option value="1">Bank account</option>
                                    <option value="2">Pocket money</option>
                                    <option value="3">PayPal account</option>
                                    <option value="4">Credit card</option>
                                    <option value="5">Meal card</option>
                                </select>
                                @if ($errors->has('account_type_id'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('account_type_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="code">Code</label>
                                <input id="code" type="text"
                                       class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}"
                                       name="code" value="{{ old('code') }}">
                                @if ($errors->has('code'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <input id="description" type="text"
                                       class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                       name="description" value="{{ old('description') }}">
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="date">Date</label>
                                <input id="date" type="text" placeholder="yyyy-mm-dd"
                                       class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}"
                                       name="date" value="{{ old('date') }}">
                                @if ($errors->has('date'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="start_balance">Start Balance</label>
                                <input id="start_balance" type="text"
                                       class="form-control{{ $errors->has('start_balance') ? ' is-invalid' : '' }}"
                                       name="start_balance" value="{{ old('start_balance') }}">
                                @if ($errors->has('start_balance'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('start_balance') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <div class="form-group">
                                <button type="submit" class="btn btn-success" name="ok">Save</button>
                                <a class="btn btn-default" href="{{route('profile')}}">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
