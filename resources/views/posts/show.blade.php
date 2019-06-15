@extends('layouts/app')

@section('content')
    <a href="http://127.0.0.1/lsapp/public/posts" class="btn btn-default"><--</a>
    <h1>{!!$post->title!!}</h1>
    <small>{{$post->created_at}}</small>
    <img style="100%" src="http://127.0.0.1/lsapp/public/storage/cover_images/{{$post->cover_image}}"><br><br>
    <div>
        {!!$post->body!!}
    </div>
    <hr>
    @if (!Auth::guest() && Auth::user()->id == $post->user_id)  
    <a href="http://127.0.0.1/lsapp/public/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>
    {!!Form::open(['action'=>['PostsController@destroy', $post->id], 'method'=>'POST', 'class'=>'pull-right'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Delete', ['class'=> 'btn btn-danger'])}}
    {!!Form::close()!!}
    @endif
@endsection