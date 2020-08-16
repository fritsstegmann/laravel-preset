import {BehaviorSubject} from "rxjs";
import UserRepository from "../repository/UserRepository";

export default class AuthBloc {
    private readonly _me: BehaviorSubject<null>
    private _userRepo: UserRepository;

    constructor(userRepo: UserRepository) {
        this._userRepo = userRepo;
        this._me = new BehaviorSubject(null);
    }

    get me() {
        return this._me.asObservable()
    }

    login(user: string, password: string) {
        return this._userRepo.login(user, password).then(({data}) => {
            this._me.next(data)
        }).catch((err) => {
            this._me.error(err)
        })
    }

    getMe() {
        return this._userRepo.getMe().then(({data}) => {
            this._me.next(data)
        }).catch((err) => {
            console.error(err)
            this._me.error(err)
        })
    }

    logout() {
        this._userRepo.logout()
    }
}
