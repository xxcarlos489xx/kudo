<template>
    <div class="row">
        <div class="col-lg-12 text-center">
            <section class="flexbox-container">
                    <div class="card m-0">
                        <div class="card-header no-border">
                            <div class="card-title text-xs-center">
                                <div class="p-1">
                                    <img class="img-responsive mb-4" src="/kudo-icon-color.png" width="100">
                                    <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2">
                                        <span>Dashboard Kudo</span>
                                    </h6>
                                </div>
                            </div>
                            
                        </div>
                        <div class="card-body">
                            <div class="card-block">
                                <fieldset class="form-group mb-2">
                                    <input  pattern="[^@\s]+@[^@\s]+\.[^@\s]+" 
                                            type="email" 
                                            :class="$v.form.email.$error ? 'is-invalid' : ''"
                                            class="form-control form-control-lg input-lg" 
                                            placeholder="Ingrese correo" 
                                            v-model.trim="form.email" 
                                            required>
                                    <div class="invalid-feedback" v-if='!$v.form.email.required && $v.form.email.$anyDirty'>
                                        Por favor, ingrese un correo.
                                    </div>
                                    <span class="invalid-feedback" v-if='!$v.form.email.email && $v.form.email.$anyDirty'>
                                        El formato de correo electronico es incorrecto
                                    </span>
                                </fieldset>
                                <fieldset class="form-group">
                                    <input  type="password" 
                                            class="form-control form-control-lg input-lg" 
                                            :class="$v.form.password.$error ? 'is-invalid' : ''"
                                            v-model.trim="form.password" 
                                            placeholder="Ingresa tu contraseña" 
                                            required>
                                    <span class="invalid-feedback" v-if='!$v.form.password.required && $v.form.password.$anyDirty'>
                                        La contraseña es requerida.
                                    </span>
                                    <span class="invalid-feedback" v-if='!$v.form.password.minLength &&  $v.form.password.$anyDirty'>La contraseña debe tener un minimo de 8 caracteres</span>
                                </fieldset>
                                <button type="button" 
                                        @click="login()"
                                        :disabled="loading"
                                        class="btn btn-primary btn-lg btn-block mt-4 mb-4">
                                        <b-spinner small v-show="loading"></b-spinner>
                                        Iniciar sesión
                                </button>
                                <b-alert    :show="dismissCountDown"
                                            fade
                                            variant="danger"
                                            @dismiss-count-down="countDownChanged"
                                            >
                                    {{message}}
                                </b-alert>
                            </div>
                        </div>
                    </div>
            </section>
        </div>
    </div>
</template>

<script>
import {
    required,
    email,
    minLength,
} from 'vuelidate/lib/validators';
export default {
    data () {
        return {
            dismissSecs: 3,
            dismissCountDown: 0,
            loading: false,
            form:{
                email:'',
                password:''
            },
            message:''
        }
    },
    validations:{
        form:{
            email:{
                required,
                email
            },
            password:{
                required,
                minLength:minLength(8)
            }
        }

    },
    methods: {
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
        login(){
            this.$v.$touch();
            if (!this.$v.$anyError){
                this.loading=true;
                let form = new FormData();
                form.append("email",this.form.email);
                form.append("password",this.form.password);

                this.$AuthApi.login(form)
                    .then((rs)=>{
                        if (rs.status === 200) {
                            window.location = '/dashboard';
                            this.loading=false;
                        }
                    }).catch(({response})=>{
                        this.loading=false;
                        if (response.status === 401) {
                            this.dismissCountDown = this.dismissSecs
                            this.message = response.data.message
                        }
                    });
            }
            
        },
    },
}
</script>