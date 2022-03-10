import ApiConfig from '../ApiConfig'

const resource = '/auth'

export default {
    login(payload){
       return ApiConfig.post(`${resource}/login`,payload);
    },
}