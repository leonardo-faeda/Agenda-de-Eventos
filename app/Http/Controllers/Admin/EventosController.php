<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Evento;

class EventosController extends Controller
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
            ["titulo"=>"Lista dos Meus Eventos", "url"=>""]
        ]);

        $user = auth()->user();

        $listaEventos = DB::table('eventos')
                        ->join('users', 'users.id', '=', 'eventos.user_id')                        
                        ->select('eventos.id', 'eventos.titulo', 'eventos.descricao', 'users.name', 'eventos.data')
                        ->whereNull('deleted_at')
                        ->where('eventos.user_id', '=', $user->id)
                        ->orderBy('eventos.id', 'DESC')
                        ->paginate(5);

        return view('admin.eventos.index', compact('navegacoes'), compact('listaEventos'));
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
        $data = $request->all();
        $validacao = \Validator::make($data, [
            "titulo" => "required",
            "descricao" => "required",
            "conteudo" => "required",
            "data" => "required",
        ]);

        if($validacao->fails()){
            return redirect()->back()->withErrors($validacao)->withInput();
        }

        $user = auth()->user();
        $user->eventos()->create($data);
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
        return Evento::find($id);
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
        $data = $request->all();
        $validacao = \Validator::make($data, [
            "titulo" => "required",
            "descricao" => "required",
            "conteudo" => "required",
            "data" => "required",
        ]);

        if($validacao->fails()){
            return redirect()->back()->withErrors($validacao)->withInput();
        }

        $user = auth()->user();
        $user->eventos()->find($id)->update($data);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
        $nomeEvento = DB::table('eventos')
            ->select('titulo')
            ->where('id', '=', $id)
            ->first();

        $listaUsuariosPertencenteAoEvento = DB::table('lista_participantes')
                                                ->select('user_id')
                                                ->where('evento_id', '=', $id)
                                                ->get();

        $mensagem = "O evento ". $nomeEvento->titulo . " foi cancelado";

        foreach ($listaUsuariosPertencenteAoEvento as $key => $value){
            DB::table('notificacaos')
            ->insert([
                'mensagem' => $mensagem,
                'user_id' => $value->user_id,
                'evento_id' => -1
            ]);
        }  
            
            
        DB::table('lista_participantes')
            ->where('evento_id', '=', $id)
            ->delete();

        Evento::find($id)->delete();

        return redirect()->back();
    }
}
