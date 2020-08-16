import {ReplaySubject} from "rxjs";
import UserRepository from "../repository/UserRepository";
import {Vue} from "vue/types/vue";

export enum AuthEvent {
    LOGIN = 'LOGIN',
    LOGOUT = 'LOGOUT'
}

export default class AuthBloc {
    private readonly _me: ReplaySubject<null>
    private _userRepo: UserRepository;
    private _bus: Vue

    constructor(userRepo: UserRepository, bus: Vue) {
        this._userRepo = userRepo;
        this._me = new ReplaySubject(1)
        this._bus = bus
    }

    get me() {
        return this._me.asObservable()
    }

    login(user: string, password: string) {
        return this._userRepo.login(user, password).then(({data}) => {
            this._bus.$emit(AuthEvent.LOGIN, data)
            this._me.next(data)
        }).catch((err) => {
            this._me.error(err)
        })
    }

    getMe() {
        return this._userRepo.getMe().then(({data}) => {
            this._me.next(data)
        }).catch((err) => {
            this._bus.$emit(AuthEvent.LOGOUT)
            this._me.error(err)
        })
    }

    async logout() {
        await this._userRepo.logout()
        this._bus.$emit(AuthEvent.LOGOUT)
    }
}
