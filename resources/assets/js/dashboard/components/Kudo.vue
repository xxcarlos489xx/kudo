<template>
    <b-card no-body class="overflow-hidden mb-3" v-if="item">
        <b-row no-gutters>
            <b-col md="6" lg="3" class="d-flex">
                <b-card-img :src="item.img ? item.img : '/kudo-default.png'" alt="Image" class="rounded-0"></b-card-img>
            </b-col>
            <b-col md="6" lg="9" class="align-self-center p-3">
                <b-card-body :title="item.titulo">
                    <a class="btn btn-primary btn-view-kudo" href="#" role="button">Ver tablero</a>
                    <b-dropdown class="btn-options" 
                                size="lg"  
                                dropleft 
                                variant="link" 
                                v-if="all"
                                toggle-class="text-decoration-none" 
                                no-caret>
                        <template #button-content>
                            <b-icon class="icon-options" icon="three-dots-vertical"></b-icon>
                        </template>
                        <b-dropdown-item @click="eliminar(item.id)">Eliminar</b-dropdown-item>
                    </b-dropdown>
                    <span v-if="all">
                        <strong>PARA: </strong>{{item.user_send.nombres}}
                    </span>
                    <hr>
                    <b-card-text>
                        <div class="row">
                        <div class="col-6">
                            <small><strong>Autor</strong></small><br>
                            <small>{{item.autor.nombres}}</small><br>
                            <small><strong>Posts</strong></small><br>
                            <small>{{item.kudos}}</small>
                        </div>
                        <div class="col-6">
                            <small><strong>Creado</strong></small><br>
                            <small>{{item.created_at}}</small>
                        </div>
                        </div>
                    </b-card-text>
                </b-card-body>
            </b-col>
        </b-row>
    </b-card>
</template>

<script>

export default {
    props:['item','all'],
    data () {
        return {

        }
    },
    methods: {
        eliminar(id){
            this.eventHub.$emit('eliminar', id);
        }
    },
}
</script>