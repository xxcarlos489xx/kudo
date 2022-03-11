import ApiConfig from '../ApiConfig'

const resource = '/dashboard'

export default {
    getTableros(payload){
        return ApiConfig.post(`${resource}/getTableros`,payload);
    },
    eliminar(id){
        return ApiConfig.post(`${resource}/eliminar/${id}`);
    },
    saveTablero(payload){
        return ApiConfig.post(`${resource}/saveTablero`,payload);
    }
}