<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Evento;
use App\User;
use App\ListaParticipantes;
use App\Notificacao;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $navegacoes = json_encode([
            ["titulo"=>"Principal", "url"=>""]
        ]);
        
        $user = auth()->user();

        $totalEventos = Evento::where('user_id', '!=', $user->id)->count();
        $totalMeusEventos = Evento::where('user_id', '=', $user->id)->count();
        $totalConfirmado = ListaParticipantes::where('user_id', '=', $user->id)->count();
        $totalNoticias = Notificacao::where('user_id', '=', $user->id)->count();
        return view('home', compact('navegacoes', 'totalMeusEventos', 'totalEventos', 'totalConfirmado', 'totalNoticias'));
    }
}
