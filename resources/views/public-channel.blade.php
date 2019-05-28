@extends('layouts.app')

@section('title', 'Public channel chat')

@section('content')

<chat-component _messages="{{ json_encode($messages) }}" _auth_user="{{ json_encode(auth()->user()) }}"></chat-component>		

</script>
@endsection