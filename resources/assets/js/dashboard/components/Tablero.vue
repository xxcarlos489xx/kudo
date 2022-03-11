<template>
    <div class="container-fluid mb-5">
        <div class="row p-5 row-head-kudo">
            <div class="col-12 text-center">
                <div class="text-white" v-if="loading">
                    <b-skeleton></b-skeleton>
                </div>
                <div class="text-white" v-else>
                    <h1>{{tablero.titulo}}</h1>
                    <b-button v-b-toggle.collap-kudo variant="primary">
                        <b-icon icon="bookmark-plus"></b-icon>
                        Agregar
                    </b-button>                    
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6">
                    <b-collapse id="collap-kudo" class="mt-2">
                        <b-card>
                            <div class="form-group">
                                <label for="">Descripción</label>
                                <textarea type="text" 
                                        class="form-control" 
                                        :class="$v.form.descripcion.$error ? 'is-invalid' : ''"
                                        v-model="form.descripcion"
                                        placeholder="Máximo 300 caracteres">
                                </textarea>
                                <span class="invalid-feedback" v-if='!$v.form.descripcion.required && $v.form.descripcion.$anyDirty'>
                                    La descripción es requerida
                                </span>               
                                <span   class="invalid-feedback" 
                                    v-if='!$v.form.descripcion.minLength &&  $v.form.descripcion.$anyDirty'>
                                    La descripción debe tener un minimo de 15 caracteres
                                </span>
                                <span   class="invalid-feedback" 
                                        v-if='!$v.form.descripcion.maxLength &&  $v.form.descripcion.$anyDirty'>
                                        La descripción debe tener un máximo de 300 caracteres
                                </span>               
                            </div>
                            <button @click.prevent="openModalCropie('imgKudo')"
                                    type="button" 
                                    class="btn btn-primary">
                                <b-icon icon="cloud-upload"></b-icon>
                                Agregar imagen
                            </button>
                            <div class="row" style="place-content:center">
                                <img class="mt-2" :src="form.imagen" width="250px" height="auto">
                            </div>
                            <template #footer>
                                <div class="text-center">
                                    <button type="button" 
                                            :disabled="$v.form.descripcion.$error || saving"
                                            @click="saveKudo()"
                                            class="btn btn-success">
                                        Publicar
                                    </button>
                                    <button type="button" 
                                            :disabled="saving"
                                            @click="cleanKudo()"
                                            class="btn btn-danger">
                                        Cancelar
                                    </button>
                                </div>
                                
                            </template>
                        </b-card>
                    </b-collapse>
                </div>                
            </div>
            <div class="row mt-3" v-if="loading">
                <div class="col-12 col-md-6 col-lg-4" v-for="(d,index) in 3" :key="index">
                    <b-card no-body img-top>
                        <b-skeleton-img card-img="top" aspect="1:1"></b-skeleton-img>
                        <b-card-body>
                            <b-skeleton></b-skeleton>
                            <b-skeleton></b-skeleton>
                            <b-skeleton></b-skeleton>
                        </b-card-body>
                    </b-card>
                </div>
            </div>
            <div class="row mt-3 mb-5 pb-5" v-else>
                <template v-if="tablero.kudos.length > 0">
                    <div class="col-12 col-md-6 col-lg-4" v-for="(t) in tablero.kudos" :key="t.id">
                        <b-card title="" :img-src="`/assets/kudos/${t.imagen}_original.png`" img-alt="Image" img-top>
                            <b-card-text>
                                {{t.descripcion}}
                            </b-card-text>
                            <template #footer>
                                <small class="text-muted">Autor: {{t.autor.nombres}}</small><br>
                                <small class="text-muted">Creado: {{t.created_at}}</small>
                            </template>
                        </b-card>
                    </div>
                </template>
                <template v-else>
                    <b-alert show variant="info">
                        <h4 class="alert-heading">Ups...!</h4>
                        <hr>
                        <p class="mb-0">
                        Aún no existen kudos para este tablero, se el primero en crear uno.
                        </p>
                    </b-alert>
                </template>
                
            </div>
        </div>
        <modal-croppie-js></modal-croppie-js>
    </div>
</template>

<script>
import {
    required,
    minLength,
    maxLength,
} from 'vuelidate/lib/validators';
import ModalCroppieJs from "./modals/ModalCropieJs";

export default {
    data () {
        return {
            saving:false,
            loading:true,
            tablero:{},
            form:{
                descripcion:'',
                imagen:''
            }
        }
    },
    components:{
        ModalCroppieJs
    },
    validations:{
        form:{
            descripcion:{
                required,
                minLength:minLength(15),
                maxLength:maxLength(300),
            }
        }
    },
    created() {
        this.loadTablero();
    },
    mounted() {
        this.eventHub.$on('setImage',(data)=>{
            this.form.imagen = data.image
        })
    },
    methods: {
        cleanKudo(){
            this.$root.$emit('bv::toggle::collapse', 'collap-kudo')
            this.form.descripcion = '';
            this.form.imagen = '';
            this.$v.$reset();
        },
        openModalCropie(tipo){
            const config = {};
            config.value = tipo === 'imgKudo' ? '354x354' : '500x350'
            config.tipo = tipo;
            this.eventHub.$emit("showModalCropie",config);
        },
        loadTablero(){
            const id = this.$route.params.id;
            if (id) {
                this.loading = true;
                this.$DashboardApi
                    .getTablero(id)
                    .then((rs)=>{
                        if (rs.status === 200) {
                            this.loading = false;
                            console.log(rs);
                            this.tablero = {...rs.data.tablero}
                        }
                    })
                    .catch(({response})=>{
                        this.$router.push('/dashboard')
                    })
            }else{
                this.$router.push('/dashboard')
            }
        },
        saveKudo(){
            this.$v.$touch();
            if (!this.$v.$anyError){
                if (!this.form.imagen) {
                    this.makeToast('Debe subir una imagen','error');
                    return;
                }
                let form = new FormData();
                form.append("tablero_id",this.tablero.id);
                form.append("descripcion",this.form.descripcion);
                form.append("imagen",this.form.imagen);

                this.$DashboardApi
                    .saveKudo(form)
                    .then((rs)=>{
                        if (rs.status===200) {
                            this.loadTablero();
                            this.cleanKudo();
                            this.makeToast(`${rs.data.message}`,'success');
                        }
                    })
                    .catch(({response})=>{
                        if (response.status===401 || response.status === 404) {
                            this.makeToast(`${response.data.message}`,'error');  
                        }
                    })
            }
        },
        makeToast(message,variant = null) {
            this.$toast(message, {
                type:variant || 'info',
                timeout: 4000
            });
        }
    },
}
</script>