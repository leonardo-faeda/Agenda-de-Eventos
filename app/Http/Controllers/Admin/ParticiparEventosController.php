<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Evento;

class ParticiparEventosController extends Controller
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
            ["titulo"=>"Lista de Eventos Disponíveis", "url"=>""]
        ]);

        $user = auth()->user();

        $listaEventos = DB::table('eventos')
                        ->join('users', 'users.id', '=', 'eventos.user_id')                    
                        ->select('eventos.id', 'eventos.titulo', 'eventos.descricao', 'users.name', 'eventos.data')
                        ->whereNull('deleted_at')
                        ->whereDate('data','>=', date('Y-m-d'))
                        ->where('eventos.user_id', '!=', $user->id)
                        ->orderBy('eventos.data', 'DESC')
                        ->paginate(5);
        

        return view('admin.participareventos.index', compact('navegacoes'), compact('listaEventos'));
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
        $user = auth()->user();
 
        DB::table('lista_participantes')
            ->insert([                    
                'user_id' => $user->id,
                'evento_id' => $request->id_evento,
            ]);        

        DB::table('notificacaos')     
            ->where('id', $request->id)
            ->delete();
       
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
