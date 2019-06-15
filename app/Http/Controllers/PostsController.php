<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except'=>['index', 'show']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts = Post::orderBy('created_at', 'desc')->get();
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('posts\index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required',
            'body'=>'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);
        //cuida do file upload
        if($request->hasFile('cover_image')){
            //catar o file com extensão
            $fileWithExt = $request->file('cover_image')->getClientOriginalName();
            //apenas o arquivo
            $filename = pathinfo($fileWithExt, PATHINFO_FILENAME);
            //apenas a extensão
            $extention = $request->file('cover_image')->getClientOriginalExtension();
            //arquivo a ser salvo
            $fileNameToStore = $filename.'_'.time().'.'.$extention;
            //upload
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }else{
            $fileNameToStore = 'noimage.jpg';
        }
        //aqui cria o post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts\show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        //cheka o usuário
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', '!');
        }
        return view('posts\edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title'=>'required',
            'body'=>'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);
        $post = Post::find($id);
        //cuida do file upload
        if($request->hasFile('cover_image')){
            if($post->cover_image != 'noimage.jpg'){
                Storage::delete('public/cover_images/'.$post->cover_image);
            }

            //catar o file com extensão
            $fileWithExt = $request->file('cover_image')->getClientOriginalName();
            //apenas o arquivo
            $filename = pathinfo($fileWithExt, PATHINFO_FILENAME);
            //apenas a extensão
            $extention = $request->file('cover_image')->getClientOriginalExtension();
            //arquivo a ser salvo
            $fileNameToStore = $filename.'_'.time().'.'.$extention;
            //upload
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }
        //aqui cria o post
        
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image')){
            $post->cover_image = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', '!');
        }

        if($post->cover_image != 'noimage.jpg'){
            //deleta a imagem
            Storage::delete('public/cover_images/'.$post->cover_image);
        }
        $post->delete();
        return redirect('/posts')->with('success', 'Post Deleted');
    }
}
