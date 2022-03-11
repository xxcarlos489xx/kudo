import ApiConfig from '../ApiConfig'

const resource = '/dashboard'

export default {
    getTableros(payload){
        return ApiConfig.post(`${resource}/getTableros`,payload);
    },
    eliminar(id){
        return ApiConfig.post(`${resource}/eliminar/${id}`);
    },
    enviar(id){
        return ApiConfig.post(`${resource}/enviar/${id}`);
    },
    getTablero(id){
        return ApiConfig.post(`${resource}/getTablero/${id}`);
    },
    saveTablero(payload){
        return ApiConfig.post(`${resource}/saveTablero`,payload);
    },
    saveKudo(payload){
        return ApiConfig.post(`${resource}/saveKudo`,payload);
    }
}