<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ListaParticipantesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $navegacoes = json_encode([
            ["titulo"=>"Principal", "url"=>route('admin')],
            ["titulo"=>"Lista dos Eventos Confirmados", "url"=>""]
        ]);

        $user = auth()->user();

        $listaEventos = DB::table('lista_participantes')                            
                        ->join('eventos', 'eventos.id', '=', 'lista_participantes.evento_id')
                        ->join('users', 'users.id', '=', 'eventos.user_id')                        
                        ->select('eventos.id', 'eventos.titulo', 'eventos.descricao', 'users.name', 'eventos.data')
                        ->whereNull('eventos.deleted_at')
                        ->where('lista_participantes.user_id', '=', $user->id)
                        ->orderBy('eventos.data', 'DESC')
                        ->paginate(5);

        return view('admin.confirmados.index', compact('navegacoes'), compact('listaEventos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $navegacoes = json_encode([
            ["titulo"=>"Principal", "url"=>route('admin')],
            ["titulo"=>"Lista dos Meus Eventos", "url"=>route('eventos.index')],
            ["titulo"=>"Lista de Participantes", "url"=>""],
        ]);

        $listaParticipantes = DB::table('lista_participantes') 
                                ->join('users', 'users.id', '=', 'lista_participantes.user_id')                              
                                ->select('users.name','users.email')
                                ->whereNull('lista_participantes.deleted_at')
                                ->where('lista_participantes.evento_id', $id)
                                ->get();

        return view('admin.participantes.index', compact('listaParticipantes'), compact('navegacoes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();
        DB::table('lista_participantes')
            ->where('evento_id', '=', $id)
            ->where('user_id', '=', $user->id)
            ->delete();
        
        return redirect()->back();
    }
}
