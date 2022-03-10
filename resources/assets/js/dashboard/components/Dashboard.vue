<template>
    <div class="container-fluid">
        <div class="row p-5 row-head-kudo">
            <div class="col-12 d-flex justify-content-between">
                <div class="text-white">
                    <h1>Tablero</h1>
                </div>
                <div>
                    <a class="btn btn-primary" role="button" @click="openModal();">
                        <b-icon icon="clipboard-plus"></b-icon>
                        <span>Nuevo Kudo</span> 
                    </a>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-5">
                <b-tabs content-class="mt-3">
                    <b-tab title="Disponibles" active>
                        <Kudo></Kudo>
                    </b-tab>
                    <b-tab title="Recibidos">
                        <Kudo></Kudo>
                    </b-tab>
                </b-tabs>
            </div>
        </div>
        
    </div>
</template>

<script>
import Kudo from './Kudo'
export default {
    data () {
        return {

        }
    },
    components:{
        Kudo
    },
    methods: {
        openModal(){

        }
    },
}
</script>