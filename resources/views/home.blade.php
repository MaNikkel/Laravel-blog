@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="http://127.0.0.1/lsapp/public/posts/create" class="btn btn-primary">Create Post</a>
                    <hr>
                    
                    @if (count($user->posts) > 0)                    
                        <table class='table table-striped'>
                            <tr>
                                <td>Title</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @foreach ($user->posts as $post)
                            <tr>
                                <td>{{$post->title}}</td>
                                <td><small>{{$post->created_at}}</small></td>
                                <td><a href="/" class="btn btn-primary">Edit</a></td>
                                <td>{!!Form::open(['action'=>['PostsController@destroy', $post->id], 'method'=>'POST', 'class'=>'pull-right'])!!}
                                        {{Form::hidden('_method', 'DELETE')}}
                                        {{Form::submit('Delete', ['class'=> 'btn btn-danger'])}}
                                    {!!Form::close()!!}</td>
                            </tr>
                            @endforeach
                        </table>
                    @else 
                    <br/>
                        <p>You have no posts</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
