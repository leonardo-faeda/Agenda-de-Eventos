@extends('layouts.app')

@section('content')
<template>
    <pagina tamanho = "12">

                
        <painel titulo= "Lista dos Meus Eventos">
            <navegacao
                v-bind:navegacoes = "{{$navegacoes}}"
            >
            </navegacao>            
            <div>
            <?php
                foreach ($listaParticipantes as $key => $value){
                    echo '<li>'.$value->name.' - '.$value->email.'</li>';
                }            
            ?>
            </div>
            
            
        </painel>
    </pagina>

   
</template>
@endsection
