<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Notificacao;
use App\User;

class NotificacoesController extends Controller
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
            ["titulo"=>"Lista de Notícias", "url"=>""]
        ]);

        $user = auth()->user();

        $listaNotificacoes = DB::table('notificacaos')      
                        ->select('notificacaos.id', 'notificacaos.evento_id', 'notificacaos.mensagem')
                        ->whereNull('notificacaos.deleted_at')
                        ->where('notificacaos.user_id', '=', $user->id)
                        ->orderBy('notificacaos.id', 'DESC')
                        ->paginate(5);
        

        return view('admin.notificacoes.index', compact('navegacoes'), compact('listaNotificacoes'));
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
            "email" => "required",            
            "mensagem" => "required",
        ]);

        if($validacao->fails()){
            return redirect()->back()->withErrors($validacao)->withInput();
        }

        $user = DB::table('users')->where('email', $request->email)->first();
        $userLogado = auth()->user();

        if(!$user){
            return redirect()->back()->withErrors("Email não existe!")->withInput();
        }else if($user->id == $userLogado->id){
            return redirect()->back()->withErrors("Auto convite!")->withInput();
        }else{   
            $participando = DB::table('lista_participantes')
                            ->where('user_id', $user->id)      
                            ->where('evento_id', $request->id_evento)
                            ->first();
            if($participando){
                return redirect()->back()->withErrors("Usuário já está participando do evento!")->withInput();
            }else{
                DB::table('notificacaos')
                ->insert([
                    'mensagem' => $request->mensagem,
                    'user_id' => $user->id,
                    'evento_id' => $request->id_evento,
                ]);
            }
            
        }        
       
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
        return Notificacao::find($id);
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Notificacao::find($id)->delete();
        return redirect()->back();
    }
}
