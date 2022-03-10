import AuthApi from './modules/AuthApi';

const SERVICES = {
    Auth: AuthApi
}

export const ApiModules = {
    get: (name) => SERVICES[name],
};