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
                v-bind:titulos ="['#', 'Título', 'Descrição', 'Autor', 'Data', 'Confirmados', 'Ação']"
                v-bind:itens = "{{json_encode($listaEventos)}}"  
                criar = "#"
                detalhe = "/admin/eventos/" 
                editar = "/admin/eventos/"  
                deletar = "/admin/eventos/" 
                convidar = "/admin/eventos/"
                confirmados = "/admin/listaparticipantes/"                
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

    <modal nome= "adicionar" titulo= "Adicionar Evento">
        <formulario id="formAdicionar" css="" action="{{route('eventos.store')}}" method="post" enctype="" token="{{csrf_token()}}">
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título" value="{{old('titulo')}}">
            </div>
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição" value="{{old('descricao')}}">
            </div>  

            <div class="form-group">
                <label for="addConteudo">Conteúdo</label>
                <textarea id="addConteudo" name="conteudo" class="form-control" style="resize: vertical" rows="8">{{old('conteudo')}}</textarea>
            </div>
             
            <div class="form-group">
                <label for="data">Data</label>
                <input type="date" class="form-control" id="data" name="data" value="{{old('data')}}">
            </div>           
        </formulario>
        <span slot="botoes">
            <button form="formAdicionar" class="btn btn-info">Adicionar</button>
        </span>        
    </modal>

    <modal nome= "editar" titulo= "Editar Evento">
        <formulario id="formEditar" css="" v-bind:action="'/admin/eventos/' + $store.state.item.id" method="put" enctype="" token="{{csrf_token()}}">
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" v-model="$store.state.item.titulo" placeholder="Título">
            </div>
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <input type="text" class="form-control" id="descricao" name="descricao" v-model="$store.state.item.descricao" placeholder="Descrição">
            </div>   
            
            <div class="form-group">
                <label for="editConteudo">Conteúdo</label>
                <textarea id="editConteudo" name="conteudo" class="form-control" style="resize: vertical" rows="8">@{{$store.state.item.conteudo}}</textarea>
            </div>            

            <div class="form-group">
                <label for="data">Data</label>
                <input type="date" class="form-control" id="data" name="data" v-model="$store.state.item.data">
            </div> 
        </formulario>
        <span slot="botoes">
            <button form="formEditar" class="btn btn-info">Editar</button>
        </span>
    </modal>

    <modal nome= "detalhe" v-bind:titulo= "'Detalhe do Evento ' + $store.state.item.titulo">
        <p>@{{$store.state.item.descricao}}</p>  
        <p>@{{$store.state.item.conteudo}}</p>
    </modal>

    <modal nome= "convidar" titulo= "Convidar para Evento">
        <formulario id="formConvidar" css="" action="{{route('notificacoes.store')}}" method="post" enctype="" token="{{csrf_token()}}">          
            
            <input type="hidden" name="id_evento" v-model="$store.state.item.id">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" value="{{old('email')}}">
            </div>

            <div class="form-group">
                <label for="email">Mensagem</label>
                <textarea id="convidarMensagem" name="mensagem" class="form-control" style="resize: vertical" rows="8">{{old('mensagem')}}</textarea>
            </div>

        </formulario>
        <span slot="botoes">
            <button form="formConvidar" class="btn btn-info">Convidar</button>
        </span>        
    </modal>

</template>
@endsection
