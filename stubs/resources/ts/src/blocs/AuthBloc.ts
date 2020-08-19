import {Observable, ReplaySubject} from 'rxjs';
import UserRepository from '@app/repository/UserRepository';
import {Vue} from 'vue/types/vue';
import User from '@app/models/User'

export enum AuthEvent {
    LOGIN = 'LOGIN',
    LOGOUT = 'LOGOUT'
}

export default class AuthBloc {
    private readonly _me: ReplaySubject<User>
    private _userRepo: UserRepository;
    private _bus: Vue

    constructor(userRepo: UserRepository, bus: Vue) {
        this._userRepo = userRepo;
        this._me = new ReplaySubject(1)
        this._bus = bus
    }

    get me(): Observable<User> {
        return this._me.asObservable()
    }

    login(user: string, password: string): Promise<void> {
        return this._userRepo.login(user, password).then(() => {
            this._bus.$emit(AuthEvent.LOGIN)
        }).catch((err) => {
            this._me.error(err)
        })
    }

    getMe(): Promise<void> {
        return this._userRepo.getMe().then((user) => {
            this._me.next(user)
        }).catch((err) => {
            this._bus.$emit(AuthEvent.LOGOUT)
            this._me.error(err)
        })
    }

    async logout(): Promise<void> {
        await this._userRepo.logout()
        this._bus.$emit(AuthEvent.LOGOUT)
    }
}
