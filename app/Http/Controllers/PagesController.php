<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        $title = 'Welcome!';
        //return view('pages/services', compact('title'));
        return view('pages/index')->with('titleW', $title);
    }
    public function about(){
        return view('pages/about');
    }
    public function services(){
        $data = array(
            'titleW' => 'Services',
            'services' => ['1','2','3']//no blade deve existir um '$titleW' e um '$services'
        );
        return view('pages/services')->with($data);
        //esse return retorna uma view, passando $data como parametro 
    }
    public function blog(){
        return view('pages/posts/index');
    }
}
