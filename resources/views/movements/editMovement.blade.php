@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Update Movement</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('movementsUpdate',$movement->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="form-group">
                                <label for="type">Type</label>
                                <select id="type" type="text"
                                        class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}"
                                        name="type" value="{{ old('type',$movement->type) }}">
                                    <option disabled selected> -- select an option --</option>
                                    <option value="revenue">Revenue</option>
                                    <option value="expense">Expense</option>
                                </select>
                                @if ($errors->has('type'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="movement_category_id">Category</label>
                                <select id="movement_category_id"
                                        class="form-control{{ $errors->has('movement_category_id') ? ' is-invalid' : '' }}"
                                        name="movement_category_id" value="{{ old('movement_category_id') }}">
                                    <option disabled selected> -- select an option --</option>
                                    <option value="1">Food</option>
                                    <option value="2">Clothes</option>
                                    <option value="3">Services</option>
                                    <option value="4">Eletricity</option>
                                    <option value="5">Phone</option>
                                    <option value="6">Fuel</option>
                                    <option value="7">Mortage payment</option>
                                    <option value="8">Salary</option>
                                    <option value="9">Bonus</option>
                                    <option value="10">Roytalties</option>
                                    <option value="11">Interest</option>
                                    <option value="12">Gifts</option>
                                    <option value="13">Dividends</option>
                                    <option value="14">Product sales</option>
                                </select>
                                @if ($errors->has('movement_category_id'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('movement_category_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="date">Date</label>
                                <input id="date" type="text" placeholder="yyyy-mm-dd"
                                       class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}"
                                       name="date" value="{{ old('date', $movement->date) }}">
                                @if ($errors->has('date'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="value">Value</label>
                                <input id="value" type="text"
                                       class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}"
                                       name="value" value="{{ old('value',$movement->value) }}">
                                @if ($errors->has('value'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('value') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <div class="form-group">
                                <label for="description">Description</label>
                                <input id="description" type="text"
                                       class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                       name="description" value="{{ old('description',$movement->description) }}">
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="document_file">Document</label>

                                <input id="document_file" type="file"
                                       class="form-control{{ $errors->has('document_file') ? ' is-invalid' : '' }}"
                                       name="document_file">

                                @if ($errors->has('document_file'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('document_file') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="document_description">Description Document</label>
                                <input id="document_description" type="text"
                                       class="form-control{{ $errors->has('document_description') ? ' is-invalid' : '' }}"
                                       name="document_description" value="{{ old('document_description') }}">
                                @if ($errors->has('document_description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('document_description') }}</strong>
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
