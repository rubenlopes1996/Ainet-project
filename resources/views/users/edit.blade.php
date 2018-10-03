@extends('master')

@section('title', 'Edit user')

@section('content')
@if ($errors->any())
    @include('partials.errors')
@endif
<form action="{{route('users.update', $user->id)}}" method="post" class="form-group">
    @csrf
    @method('put')
    @include('users.partials.add-edit')
    <div class="form-group">
        <button type="submit" class="btn btn-success" name="ok">Save</button>
        <a class="btn btn-default" href="{{route('users.index')}}">Cancel</a>
    </div>
</form>
@endsection
