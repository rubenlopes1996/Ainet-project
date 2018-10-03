@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create movement</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('uploadDocument', $movement->id) }}"
                              enctype="multipart/form-data">
                            @csrf

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
