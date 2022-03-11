import AuthApi from './modules/AuthApi';
import DashboardApi from './modules/DashboardApi';


const SERVICES = {
    Auth: AuthApi,
    Dashboard:DashboardApi
}

export const ApiModules = {
    get: (name) => SERVICES[name],
};