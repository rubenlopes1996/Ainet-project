@extends('master')

@section('title', 'Edit Profile')

@section('content')

    @if ($errors->any())
        @include('partials.errors')
    @endif

    <form action="{{route('profile.me', $user->id)}}" method="post" class="form-group" enctype="multipart/form-data">
        @csrf
        @method('put')


        <div class="form-group">
            <label for="inputPassword">Name</label>
            <input
                    type="text" class="form-control"
                    name="name" id="inputName" value="{{ old('name', $user->name) }}"
            />

            <div class="form-group">
                <label for="inputPassword">E-mail</label>
                <input
                        type="text" class="form-control"
                        name="email" id="inputEmail" value="{{ old('email',$user->email) }}"
                />
            </div>

            <div class="form-group">
                <label for="inputPasswordConfirmation">Phone Number</label>
                <input
                        type="text" class="form-control"
                        name="phone" id="inputPhone" value="{{ old('phone',$user->phone) }}"
                />
            </div>

            <div class="form-group">
                <label for="inputPasswordConfirmation">Photo</label>
                <input
                        type="file" class="form-control"
                        name="profile_photo" id="profile_photo" value="{{ old('profile_photo',$user->profile_photo) }}"
                />
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a class="btn btn-default" href="{{route('profile')}}">Cancel</a>
            </div>
    </form>









@endsection