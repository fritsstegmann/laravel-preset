import "reflect-metadata";
import {BehaviorSubject} from "rxjs";
import {injectable} from "vue-typescript-inject";
import axios from "axios";


@injectable()
export class UserBloc {
    private readonly _http = axios.create({
        timeout: 30000,
    });
    private readonly _user: BehaviorSubject<any> = new BehaviorSubject<any>();


    constructor() {
        console.info('creating service');
    }

    get user(): BehaviorSubject<any> {
        return this._user;
    }

    public fetchUser() {
        this._http.get('/api/user').then(({data}) => {
            this._user.next(data);
        });
    }
}

export const userBloc = {
    provide: UserBloc,
    useValue: new UserBloc()
};
