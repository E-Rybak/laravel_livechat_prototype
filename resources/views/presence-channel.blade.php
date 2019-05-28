@extends('layouts.app')

@section('title', 'Presence channel chat')

@section('content')
<presence-channel-component _auth_user="{{ json_encode(auth()->user()) }}" _messages="{{ json_encode($messages) }}"></presence-channel-component>

@endsection

