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
        
        <painel titulo= "Lista dos Meus Eventos">
            <navegacao
                v-bind:navegacoes = "{{$navegacoes}}"
            >
            </navegacao>            

            <tabela 
                v-bind:titulos ="['#', 'Título', 'Descrição', 'Autor', 'Data', 'Ação']"
                v-bind:itens = "{{json_encode($listaEventos)}}"  
                detalhe = "/admin/eventos/"     
                deletar = "/admin/listaparticipantes/"                            
                token ="{{csrf_token()}}"      
                ordem="desc" 
                ordemcol= "4"    
                modal= "sim"         
            >
            </tabela>

            <div align="center">
                {{$listaEventos->links()}}
            </div>
            
        </painel>
    </pagina>   

    <modal nome= "detalhe" v-bind:titulo= "'Detalhe do Evento ' + $store.state.item.titulo">        
        <p>@{{$store.state.item.descricao}}</p>  
        <p>@{{$store.state.item.conteudo}}</p>
        <p align="center">
            <small>Por: @{{$store.state.item.name}} - @{{$store.state.item.data}}</small>
          </p>       
    </modal>    

</template>
@endsection
