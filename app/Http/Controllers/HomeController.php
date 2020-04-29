<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Crea una nueva instacia del controlador.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'roles:admin']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
}
