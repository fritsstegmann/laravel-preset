import "reflect-metadata";
import {BehaviorSubject} from "rxjs";
import VueBloc from "./_vue_bloc";


export class UserBloc extends VueBloc {
    private readonly _user: BehaviorSubject<any> = new BehaviorSubject<any>(null);

    get user(): BehaviorSubject<any> {
        return this._user;
    }

    public fetchUser() {
        this.$vue.$http.get('/api/user').then(({data}) => {
            this._user.next(data);
        });
    }
}
