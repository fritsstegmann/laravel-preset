// ts/components/__tests__/HomePage.spec.ts
import {shallowMount} from '@vue/test-utils'
import HomePage from '../HomePage.vue'
import {UserBloc} from "../../blocs/user_bloc";
import {Vue} from "vue-property-decorator";

describe('HelloWorld.vue', () => {
    test('renders HomePage component with successful http call', (done) => {

        let $vue = new Vue({});

        // @ts-ignore
        $vue.$http = {
            // @ts-ignore
            get: (url) => Promise.resolve({data: {'name': "Test test 214"}})
        };

        const wrapper = shallowMount(HomePage, {
            provide: {
                'userBloc': new UserBloc($vue),
            },
        });
        // read this to understand why we put a timeout here
        // https://jakearchibald.com/2015/tasks-microtasks-queues-and-schedules/
        setTimeout(() => {
            expect(wrapper.text()).toBe("Dashboard  You are logged in! Test test 214")
            done()
        }, 0);
    });

    test('renders HomePage component with unsuccessful http call', async (done) => {

        let $vue = new Vue({});

        // @ts-ignore
        $vue.$http = {
            // @ts-ignore
            get: (url) => Promise.reject(new Error('test reason'))
        };

        const wrapper = shallowMount(HomePage, {
            provide: {
                'userBloc': new UserBloc($vue),
            },
        });

        // read this to understand why we put a timeout here
        // https://jakearchibald.com/2015/tasks-microtasks-queues-and-schedules/
        setTimeout(() => {
            expect(wrapper.text()).toBe("Dashboard Error: test reason");
            done()
        }, 0);

    });
});
