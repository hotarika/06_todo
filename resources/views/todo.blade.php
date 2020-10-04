@extends('layouts.app')

@section('content')
<todo-component
    :tasks="{{ json_encode($tasks) }}"
    :user="{{ json_encode($user) }}"
    {{-- :path="{{ json_encode(asset('/')) }}" --}}>
</todo-component>
@endsection
