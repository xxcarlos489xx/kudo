<template>
    <div class="container-fluid mb-5">
        <div class="row p-5 row-head-kudo">
            <div class="col-12 d-flex justify-content-between">
                <div class="text-white">
                    <h1>Tablero</h1>
                </div>
                <div>
                    <b-button variant="primary" ref="btnShowNew" v-b-modal.modal-new>
                        <b-icon icon="clipboard-plus"></b-icon>
                        <span>Nuevo tablero Kudo</span>
                    </b-button>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-5 mb-5 pb-5">
                <b-tabs content-class="mt-3">
                    <b-tab @click="loadTableros(true)" title="Disponibles" active>
                        <b-col cols="12" v-if="loading">
                            <b-card no-body img-left>
                            <b-skeleton-img card-img="left" width="225px"></b-skeleton-img>
                            <b-card-body>
                                <b-skeleton animation="wave" width="85%"></b-skeleton>
                                <b-skeleton animation="wave" width="55%"></b-skeleton>
                                <b-skeleton animation="wave" width="70%"></b-skeleton>
                                <b-skeleton animation="wave" width="85%"></b-skeleton>
                                <b-skeleton animation="wave" width="55%"></b-skeleton>
                                <b-skeleton animation="wave" width="70%"></b-skeleton>
                            </b-card-body>
                            </b-card>
                        </b-col>
                        <template v-if="!loading && tableros.length > 0">
                            <template v-for="t in tableros">
                                <Kudo :all="all" :item="t" :key="t.id"></Kudo>
                            </template>
                        </template>
                        <template v-if="!loading && tableros.length === 0">
                            <b-alert show variant="info">
                                <h4 class="alert-heading">Ups...!</h4>
                                <hr>
                                <p class="mb-0">
                                No existen tableros disponibles.
                                </p>
                            </b-alert>
                        </template>
                        
                    </b-tab>
                    <b-tab @click="loadTableros(false)" title="Recibidos">
                        <b-col cols="12" v-if="loading">
                            <b-card no-body img-left>
                            <b-skeleton-img card-img="left" width="225px"></b-skeleton-img>
                            <b-card-body>
                                <b-skeleton animation="wave" width="85%"></b-skeleton>
                                <b-skeleton animation="wave" width="55%"></b-skeleton>
                                <b-skeleton animation="wave" width="70%"></b-skeleton>
                                <b-skeleton animation="wave" width="85%"></b-skeleton>
                                <b-skeleton animation="wave" width="55%"></b-skeleton>
                                <b-skeleton animation="wave" width="70%"></b-skeleton>
                            </b-card-body>
                            </b-card>
                        </b-col>
                        <template v-if="!loading && tableros.length > 0">
                            <template v-for="t in tableros">
                                <Kudo :all="all" :item="t" :key="t.id"></Kudo>
                            </template>
                        </template>
                        <template v-if="!loading && tableros.length === 0">
                            <b-alert show variant="info">
                                <h4 class="alert-heading">Ups...!</h4>
                                <hr>
                                <p class="mb-0">
                                No existen tableros disponibles.
                                </p>
                            </b-alert>
                        </template>
                    </b-tab>
                </b-tabs>
            </div>
        </div>
        <!-- Modal -->
        <b-modal    ref="myModal" 
                    id="modal-new" 
                    title="Crear tablero" 
                    @cancel="cleanModal"
                    @ok="saveTablero">
            <div class="row">
                <div class="col-12 mb-3">
                    <strong>¿Para quién es este Kudoboard?</strong> <br>
                    <v-select
                        v-model.trim="form.user"
                        :class="$v.form.user.$error ? 'is-invalid' : ''"
                        :reduce="(users) => users.id"
                        label="nombres"
                        :options="users"
                    />
                    <span class="invalid-feedback" v-if='!$v.form.user.required && $v.form.user.$anyDirty'>
                        El usuario es requerido
                    </span>
                </div>
                <div class="col-12 mb-3">
                    <strong>Por favor agregue una descripción</strong> <br>
                    <div class="form-group">
                        <input    type="text" 
                                    :class="$v.form.title.$error ? 'is-invalid' : ''"
                                    class="form-control"
                                    v-model.trim="form.title"
                                    placeholder="Kudoboard para cumpleaños, kudoboard para people team...">
                        <span   class="invalid-feedback" 
                                v-if='!$v.form.title.required && $v.form.title.$anyDirty'>
                                La descripcioón es requerida
                        </span>
                        <span   class="invalid-feedback" 
                                v-if='!$v.form.title.minLength &&  $v.form.title.$anyDirty'>
                                La descripción debe tener un minimo de 15 caracteres
                        </span>
                        <span   class="invalid-feedback" 
                                v-if='!$v.form.title.maxLength &&  $v.form.title.$anyDirty'>
                                La descripción debe tener un máximo de 50 caracteres
                        </span>
                    </div>
                </div>
                <div class="col-12">
                    <strong>Agregue una restricción (opcional)</strong> <br>
                    <div class="form-check">
                      <label class="form-check-label">
                            <template v-for="(r) in reglas">
                                <div :key="r.id">
                                    <input  type="checkbox" 
                                            :id="r.id"
                                            v-model="form.rules"
                                            class="form-check-input" 
                                            :value="r.id">
                                            {{r.name}} <br>
                                    <b-tooltip :target="r.id">
                                        {{r.descripcion}}
                                    </b-tooltip>
                                </div>
                            </template>
                      </label>
                    </div>
                </div>
            </div>
            <template #modal-footer="{ ok, cancel }">
                <b-button :disabled="$v.form.title.$error || $v.form.user.$error || saving" size="md" variant="primary" @click="ok()">
                    Crear
                </b-button>
                <b-button size="md" variant="danger" @click="cancel()">
                    Cancel
                </b-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
import Kudo from './Kudo';
import {
    required,
    minLength,
    maxLength,
} from 'vuelidate/lib/validators';
export default {
    props:["users","reglas","auth"],
    data () {
        return {
            saving:false,
            loading:false,
            all:true,
            tableros:[],
            form:{
                user:'', 
                title: '',
                rules:[]
            }
        }
    },
    validations:{
        form:{
            user:{
                required
            },
            title:{
                required,
                minLength:minLength(15),
                maxLength:maxLength(50),
            }
        }

    },
    created() {
        this.loadTableros(true);
    },
    mounted() {
        this.eventHub.$on('eliminar',(id)=>{
            this.eliminar(id);
        }),
        this.$root.$on('bv::modal::hidden', (bvEvent, modalId) => {
            this.cleanModal()
        }),
        window.Echo
                .channel(`challenge-kudo-created`)
                .listen('TableroCreatedEvent',(payload)=>{
                    this.dispatchEvent(payload);
                })
    },
        components:{
        Kudo
    },
    methods: {
        dispatchEvent(payload){
            if (payload.id != this.auth.id) {
                this.makeToast(`El usuario ${payload.name} ha creado un nuevo tablero`,'info');    
                this.loadTableros(this.all);
            }
        },
        cleanModal(){
            this.form.user = '';
            this.form.title = '';
            this.form.rules = [];
            this.$v.$reset();
        },
        saveTablero(e){
            e.preventDefault();
            this.$v.$touch();
            if (!this.$v.$anyError){
                let form = new FormData();
                form.append('usuario',this.form.user);
                form.append('descripcion',this.form.title);
                if (this.form.rules.length > 0) 
                    form.append('rules',JSON.stringify(this.form.rules));
                
                this.saving=true;
                this.$DashboardApi
                    .saveTablero(form)
                    .then((rs)=>{
                        this.saving=false;
                        if (rs.status === 200) {
                            this.$root.$emit('bv::hide::modal', 'modal-new', '#btnShowNew')
                            this.makeToast(rs.data.message,'success');
                            this.loadTableros(this.all);
                            this.cleanModal();
                        }
                    })
                    .catch(({response})=>{
                        this.saving=false;
                        if (response.status === 401) {
                            this.cleanModal();
                            this.makeToast(response.data.message,'error');
                        }
                    })
            }
        },
        loadTableros(v){
            this.all = v;
            this.loading = true;
            const form = new FormData();
            v ? form.append('all',v) : '';
            this.$DashboardApi.getTableros(form)
                .then((rs)=>{
                    const {status,data} = rs;
                    if (status === 200) {
                        this.loading=false;
                        this.tableros=[...data.tableros]
                    }
                }).catch(({response})=>{
                    this.loading = false;
                });
        },
        eliminar(id){
            this.$DashboardApi
                .eliminar(id)
                .then((rs)=>{
                    if (rs.status === 200) {
                        this.loadTableros(this.all);
                        this.makeToast(rs.data.message,'success');
                    }
                })
                .catch(({response})=>{
                    if (response.status === 401) {
                        this.makeToast(response.data.message,'error');
                    }
                })
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