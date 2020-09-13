import {Observable, ReplaySubject, Subject} from 'rxjs';
import UserRepository from '@app/repository/UserRepository';
import {Vue} from 'vue/types/vue';
import User from '@app/models/User'

export enum AuthEvent {
    LOGIN = 'LOGIN',
    LOGOUT = 'LOGOUT'
}

export default class AuthBloc {
    private readonly _me: Subject<User>
    private readonly _event: Subject<AuthEvent>

    private _userRepo: UserRepository;

    constructor(userRepo: UserRepository) {
        this._userRepo = userRepo;
        this._me = new ReplaySubject(1)
        this._event = new ReplaySubject(1)
    }

    get event(): Observable<AuthEvent> {
        return this._event.asObservable()
    }

    get me(): Observable<User> {
        return this._me.asObservable()
    }

    login(user: string, password: string): Promise<void> {
        return this._userRepo.login(user, password).then(() => {
            this._event.next(AuthEvent.LOGIN)
        }).catch((err) => {
            this._me.error(err)
        })
    }

    getMe(): Promise<void> {
        return this._userRepo.getMe().then((user) => {
            this._me.next(user)
        }).catch((err) => {
            this._event.next(AuthEvent.LOGOUT)
            this._me.error(err)
        })
    }

    async logout(): Promise<void> {
        await this._userRepo.logout()
        this._event.next(AuthEvent.LOGOUT)
    }
}
