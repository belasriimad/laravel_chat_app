@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-12">
            <notification-component></notification-component>
            <chat-component :user_id={{auth()->user()->id}}></chat-component>
        </div>
    </div>
</div>
@endsection