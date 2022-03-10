<template>
    <b-card no-body class="overflow-hidden mb-3">
        <b-row no-gutters>
            <b-col md="3">
                <b-card-img src="https://picsum.photos/300/300/?image=20" alt="Image" class="rounded-0"></b-card-img>
            </b-col>
            <b-col md="9" class="align-self-center">
                <b-card-body title="Titulo tablero">
                    <a class="btn btn-primary btn-view-kudo" href="#" role="button">Ver tablero</a>
                    <b-dropdown class="btn-options" size="lg"  dropleft variant="link" toggle-class="text-decoration-none" no-caret>
                        <template #button-content>
                            <b-icon class="icon-options" icon="three-dots-vertical"></b-icon>
                        </template>
                        <b-dropdown-item href="#">Eliminar</b-dropdown-item>
                    </b-dropdown>
                    <span>
                        <strong>PARA:</strong>NOMBRE
                    </span>
                    <hr>
                    <b-card-text>
                        <div class="row">
                        <div class="col-6">
                            <label for="">Autor</label><br>
                            <small>Nombres</small><br>
                            <label for="">Posts</label><br>
                            <small>8</small>
                        </div>
                        <div class="col-6">
                            <label for="">Autor</label><br>
                            <small>Nombres</small><br>
                            <label for="">Posts</label><br>
                            <small>8</small>
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
    data () {
        

        return {}
    }
}
</script>