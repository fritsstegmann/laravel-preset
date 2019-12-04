import "reflect-metadata";
import {BehaviorSubject} from "rxjs";
import VueBloc from "./_vue_bloc";


export class UserBloc extends VueBloc {
    private readonly _me: BehaviorSubject<any> = new BehaviorSubject<any>(null);

    get me(): BehaviorSubject<any> {
        return this._me;
    }

    public fetchMe() {
        this.$vue.$http.get('/api/me').then(({data}) => {
            this._me.next(data);
        }).catch((err) => {
            this._me.error(err);
        });
    }
}
