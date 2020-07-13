<template>
  <div>
    <div class="form-inline">
      <a v-if="criar && !modal" v-bind:href="criar">Adicionar Artigo</a>  
      <modallink v-if="criar && modal" tipo="button" nome="adicionar" titulo="" icone= "fa fa-plus" css=""></modallink>
      <div class="form-group pull-right">      
        <input type="search" class="form-control" placeholder="Buscar" v-model="buscar" >
      </div>
    </div>

    <table class="table table-striped table-hover" style="margin-top: 15px;">
      <thead>
        <tr>
          <th style="cursor:pointer" v-on:click="ordenaColuna(index)" v-for="(titulo,index) in titulos">{{titulo}}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in lista">
          <td v-for="i in item ">{{i | formataData}}</td> 

          <td v-if="confirmar">
            <form v-bind:id="index" v-bind:action="confirmar + item.id" method="post">
              <input type="hidden" name="_method" value="DELETE">
              <input type="hidden" name="_token" v-bind:value="token">
              
              <a v-if="item.evento_id != -1 && !modal" v-bind:href="confirmar"> confirmar |</a>
              <modallink v-if="item.evento_id != -1 && modal" v-bind:item="item" v-bind:url="confirmar"  tipo="button" nome="confirmar" titulo="" icone="fa fa-check-circle" css="btn btn-success"></modallink>
                 
              <button v-on:click="executaForm(index)" type="button" class="btn btn-danger"><i class="fa fa-times-circle-o"></i></button>
                     
            </form>
          </td>  

          <td v-if="confirmados">
              <form v-bind:id="item.id" v-if="confirmados" v-bind:action="confirmados + item.id" method="get">
                <button v-on:click="executaForm(item.id)" type="button" class="btn btn-info"><i class="fa fa-users"></i></button>
              </form>
          </td>             

          <td v-if="detalhe || editar || deletar || convidar">
            <form v-bind:id="index" v-if="deletar && token" v-bind:action="deletar + item.id" method="post">
              <input type="hidden" name="_method" value="DELETE">
              <input type="hidden" name="_token" v-bind:value="token">

              <a v-if="convidar && !modal" v-bind:href="convidar"> Convidar |</a>
              <modallink v-if="convidar && modal" v-bind:item="item" v-bind:url="convidar"  tipo="button" nome="convidar" titulo="" icone="fa fa-bell-o" css="btn btn-warning"></modallink>

              <a v-if="detalhe && !modal" v-bind:href="detalhe">Detalhe |</a>
              <modallink v-if="detalhe && modal" v-bind:item="item" v-bind:url="detalhe" tipo="button" nome="detalhe" titulo="" css="btn btn-info" icone="fa fa-info-circle"></modallink>
              

              <a v-if="editar && !modal" v-bind:href="editar"> Editar |</a>
              <modallink v-if="editar && modal" v-bind:item="item" v-bind:url="editar"  tipo="button" nome="editar" titulo="" icone="fa fa-pencil" css="btn btn-success"></modallink>
              
              <button v-on:click="executaForm(index)" type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                 
            </form>   

            <span v-if="!token">
              <a v-if="detalhe && !modal" v-bind:href="detalhe">Detalhe |</a>
              <modallink v-if="detalhe && modal" v-bind:item="item" v-bind:url="detalhe" tipo="button" nome="detalhe" titulo="" css="btn btn-info" icone="fa fa-info-circle"></modallink>
              
              <a v-if="editar && !modal" v-bind:href="editar"> Editar |</a>
              <modallink v-if="editar && modal" v-bind:item="item" tipo="button" v-bind:url="editar" nome="editar" titulo="" icone="fa fa-pencil" css="btn btn-success"></modallink>
              
            </span>
            <span v-if="token && !deletar">
              <a v-if="detalhe && !modal" v-bind:href="detalhe">Detalhe |</a>
              <modallink v-if="detalhe && modal" v-bind:item="item" tipo="button" v-bind:url="detalhe" nome="detalhe" titulo="" css="btn btn-info" icone="fa fa-info-circle"></modallink>
              
              <a v-if="editar && !modal" v-bind:href="editar"> Editar |</a>
              <modallink v-if="editar && modal" v-bind:item="item" tipo="button" v-bind:url="editar" nome="editar" titulo="" icone="fa fa-pencil" css="btn btn-success"></modallink>
            </span>
          </td>
        </tr>


      </tbody>

    </table>

  </div>

</template>

<script>
    export default {
      props:['titulos','itens','ordem','ordemcol','criar','detalhe','editar','deletar', 'confirmar', 'convidar', 'confirmados', 'token','modal'],
      data: function(){
        return {
          buscar:'',
          ordemAux: this.ordem || "asc",
          ordemAuxCol: this.ordemcol || 0
        }
      },
      methods:{
        executaForm: function(index){
          document.getElementById(index).submit();
        },
        ordenaColuna: function(coluna){
          this.ordemAuxCol = coluna;
          if(this.ordemAux.toLowerCase() == "asc"){
            this.ordemAux = 'desc';
          }else{
            this.ordemAux = 'asc';
          }
        }
      },
      filters: {
        formataData: function(valor){
          if(!valor) return '';
          valor = valor.toString();
          if(valor.split('-').length == 3){
            valor = valor.split('-');
            return valor[2] + '/' + valor[1]+ '/' + valor[0];
          }

          return valor;
        }
      },
      computed:{
        lista:function(){
          let lista = this.itens.data;
          let ordem = this.ordemAux;
          let ordemCol = this.ordemAuxCol;
          ordem = ordem.toLowerCase();
          ordemCol = parseInt(ordemCol);

          if(ordem == "asc"){
            lista.sort(function(a,b){
              if (Object.values(a)[ordemCol] > Object.values(b)[ordemCol] ) { return 1;}
              if (Object.values(a)[ordemCol] < Object.values(b)[ordemCol] ) { return -1;}
              return 0;
            });
          }else{
            lista.sort(function(a,b){
              if (Object.values(a)[ordemCol] < Object.values(b)[ordemCol] ) { return 1;}
              if (Object.values(a)[ordemCol] > Object.values(b)[ordemCol] ) { return -1;}
              return 0;
            });
          }

          if(this.buscar){
            return lista.filter(res => {
              res = Object.values(res);
              for(let k = 0;k < res.length; k++){
                if((res[k] + "").toLowerCase().indexOf(this.buscar.toLowerCase()) >= 0){
                  return true;
                }
              }
              return false;

            });
          }


          return lista;
        }
      }
    }
</script>

