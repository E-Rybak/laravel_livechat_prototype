@extends('layouts.app')

@section('title', 'Chatrooms')

@section('content')

<chat-room-index link="{{ route('base') }}" _rooms="{{ json_encode($rooms) }}"></chat-room-index>		

@endsection