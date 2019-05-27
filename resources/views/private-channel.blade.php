@extends('layouts.app')

@section('title', 'Private channel chat')

@section('content')

<private-chat-component _roomid="{{ $id }}" _imessages="{{ json_encode($imessages) }}" _user="{{ json_encode($user) }}"></private-chat-component>		

</script>
@endsection