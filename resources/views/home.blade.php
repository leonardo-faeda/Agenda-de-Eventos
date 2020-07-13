@extends('layouts.app')

@section('content')
<template>
<pagina tamanho = "10">
    <painel titulo= "Controle">
        <navegacao
            v-bind:navegacoes = "{{$navegacoes}}"
        >
        </navegacao>
        <div class="row">            
            <div class="col-md-4">
                <caixa quantidade="{{$totalMeusEventos}}" titulo="Meus Eventos" url="{{route('eventos.index')}}" cor ="#3ecca1" icone="fa fa-calendar-plus-o" ></caixa>
            </div>   
            <div class="col-md-4">
                <caixa quantidade="{{$totalConfirmado}}" titulo="Eventos Confirmados" url="{{route('listaparticipantes.index')}}" cor ="#FA8072" icone="fa fa-calendar-check-o" ></caixa>
            </div>
            <div class="col-md-4">
                <caixa quantidade="{{$totalNoticias}}" titulo="Notícias" url="{{route('notificacoes.index')}}" cor ="#f39c12d4" icone="fa fa-bell-o" ></caixa>
            </div>             
        </div>        
    </painel>
</pagina>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
@endsection
