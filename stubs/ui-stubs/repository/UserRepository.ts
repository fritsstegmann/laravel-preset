import {AxiosInstance} from "axios";

export default class UserRepository {
    private axios: AxiosInstance

    constructor(axios: AxiosInstance) {
        this.axios = axios;
    }

    async login(username: string, password: string) {
        await this.axios.get('/sanctum/csrf-cookie')
        await this.axios.post('/login', {
            email: username,
            password: password,
        })
        return this.axios.get('/api/user')
    }

    getMe() {
        return this.axios.get('/api/user')
    }

    logout() {
        return this.axios.post('/logout')
    }
}
