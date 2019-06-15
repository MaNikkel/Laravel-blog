@extends('layouts/app')

@section('content')
@if(count($posts) > 0)
  @foreach ($posts as $post)
      <div class="card card-body bg-light">
          <div class="row">
              <div class="col-md-4 col-sm-4">
                <img style="width: 100%" src="http://127.0.0.1/lsapp/public/storage/cover_images/{{$post->cover_image}}">
              </div>
              <div class="col-md-4 col-sm-4">
                  <h3><a href="http://127.0.0.1/lsapp/public/posts/{{$post->id}}">{{$post->title}}</a></h3>
                  <small>Written on {{$post->created_at}}</small>
              </div>
          </div>
          
       </div>
  @endforeach
  {{$posts->links()}}
@else 
    <p>No posts</p>
@endif
@endsection