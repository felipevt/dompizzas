<template>
    <div>
        <input type="text" class=form-control v-model="queryString" v-on:keyup="getResults()" placeholder="Digite a sua busca">

        <div class="panel-footer" v-if="clientes.length">
            <ul class="list-group">
                <li class="list-group-item" v-for="cliente in clientes">{{ cliente.nome }}</li>
            </ul>
        </div>
    </div>

</template>

<script>
    export default {
        data(){
            return{
                queryString: '',
                clientes: [],
            }
        },
        methods:{
            getResults(){
                this.clientes= [];
                axios.get('/api/search', {params: {queryString: this.queryString}}).then(response=>{
                    response.data.forEach((cliente)=>{
                       this.clientes=response.data;
                    });
                });
            }

        }
    }

</script>