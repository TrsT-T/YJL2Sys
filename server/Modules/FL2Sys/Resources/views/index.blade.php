@extends('fl2sys::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('fl2sys.name') !!}
    </p>
@endsection
