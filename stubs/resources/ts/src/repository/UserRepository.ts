import {AxiosInstance, AxiosResponse} from 'axios';
import User from '@app/models/User'

export default class UserRepository {
    private axios: AxiosInstance

    constructor(axios: AxiosInstance) {
        this.axios = axios;
    }

    async login(username: string, password: string): Promise<void> {
        await this.axios.get('/sanctum/csrf-cookie')
        await this.axios.post('/login', {
            email: username,
            password: password,
        })
    }

    getMe(): Promise<User> {
        return this.axios.get('/api/user').then(({data}) => {
            return User.fromMap(data)
        })
    }

    logout(): Promise<AxiosResponse> {
        return this.axios.post('/logout')
    }
}
