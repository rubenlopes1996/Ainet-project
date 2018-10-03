@extends('master')

@section('title', 'List users')

@section('content')
    @auth

        <table class="table table-striped">
            <thead>

            <tr>
                <th>Value</th>
                <th>Date</th>
                <th>End balance</th>
                <th>Description</th>
                <th>Type</th>
                <th>Movement category</th>
                <th>Actions</th>
            </tr>
            </thead>
            @foreach ($movements as $movement)
                <tr>
                    <td>{{ $movement->value }}</td>
                    <td>{{ $movement->date }}</td>
                    <td>{{ $movement->end_balance }}</td>
                    <th>{{ $movement->description }}</th>
                    <td>{{ $movement->type }}</td>
                    <td>{{ $movement->associated_movement_type->name }}</td>
                    <td>
                        <form method="get" action="{{route('movementsEdit', $movement->id)}}">
                            <button type="submit" class="btn btn-primary">Edit Movement</button>
                        </form>
                        <form method="post"
                              action="{{route('movementsDelete', $movement->id)}}">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Delete Movement</button>
                        </form>
                        <form method="get" action="{{route('showuploadDocument', $movement->id)}}">
                            <button type="submit" class="btn btn-primary">Upload Document</button>
                        </form>
                        @if(!is_null($movement->document_id))
                            <form method="get" action="{{route('showDocument',$movement->document_id)}}">
                                <button type="submit" class="btn btn-primary">Show document</button>
                            </form>
                            <form method="get"
                                  action="{{route('downloadDocument',[$movement->id, $movement->document_id])}}">
                                <button type="submit" class="btn btn-primary">Download document</button>
                            </form>
                            <form method="post" action="{{route('deleteDocument', $movement->document_id)}}">
                                <button type="submit" class="btn btn-primary">Delete document</button>
                                @csrf
                                @method('delete')
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    @endauth
@endsection

