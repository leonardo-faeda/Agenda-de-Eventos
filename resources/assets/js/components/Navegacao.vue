<template>
<ol class="breadcrumb">
  <li v-for="item in navegacoes"><a v-if="item.url" v-bind:class="defineClasse" v-bind:href="item.url">{{item.titulo}}</a><span v-if="!item.url">{{item.titulo}}</span></li>
</ol>
</template>

<script>
    export default {
      props:['navegacoes'],
      computed: {
          defineClasse: function(){

          }
      }
    }
</script>
