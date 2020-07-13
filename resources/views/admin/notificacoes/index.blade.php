@extends('layouts.app')

@section('content')
<template>
    <pagina tamanho = "12">

        @if($errors->all())
            <div class="alert alert-danger alert-dismissible text-center" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                @foreach ($errors->all() as $key => $value)
                    <li><strong>{{$value}}</strong></li>
                @endforeach
            </div>
        @endif
        
        <painel titulo= "Lista de Notificações">
            <navegacao
                v-bind:navegacoes = "{{$navegacoes}}"
            >
            </navegacao>            

            <tabela 
                v-bind:titulos ="['#', 'Evento', 'Mensagem', 'Ação']"
                v-bind:itens = "{{json_encode($listaNotificacoes)}}"  
                confirmar = "/admin/notificacoes/" 
                token ="{{csrf_token()}}"      
                ordem="desc" 
                ordemcol= "0"    
                modal= "sim"         
            >
            </tabela>

            <div align="center">
                {{$listaNotificacoes->links()}}
            </div>
            
        </painel>

    </pagina>

    <modal nome="confirmar" titulo= "Confirmar Participação">
        

        <formulario id="formConfirmar" css="" action="{{route('participareventos.store')}}" method="post" enctype="" token="{{csrf_token()}}">          
            <label><h3>Tem certeza que deseja participar do evento?<h3></label>
            <input type="hidden" name="id" v-model="$store.state.item.id">
            <input type="hidden" name="id_evento" v-model="$store.state.item.evento_id">                       
        </formulario>

        <span slot="botoes">
            <button form="formConfirmar" class="btn btn-success">Confirmar</button>
        </span>   
             
    </modal>
    
  
</template>
@endsection
