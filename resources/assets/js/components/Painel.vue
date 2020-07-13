<template>
    <div v-bind:class="defineCor">
        <div v-if="titulo" class="panel-heading">{{titulo}}</div>

        <div class="panel-body">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props:['titulo', 'cor'],
        computed:{
            defineCor: function(){
                return "panel " + (this.cor || "panel-default");
            }
        }
    }
</script>

<style>

.blue {
    border-color: #084365;
}

.blue > .panel-heading {
    color: #fff;
    background-color: #084365;
    border-color: #084365;
}

.orange {
    border-color: #dc7f14;
}

.orange > .panel-heading {
    color: #fff;
    background-color: #dc7f14;
    border-color: #dc7f14;
}

.red {
    border-color: #dc1414;
}

.red > .panel-heading {
    color: #fff;
    background-color: #dc1414;
    border-color: #dc1414;
}

.green {
    border-color: #026503;
}

.green > .panel-heading {
    color: #fff;
    background-color: #026503;
    border-color: #026503;
}
</style>

#dc1414