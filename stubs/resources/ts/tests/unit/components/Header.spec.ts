import {createLocalVue, shallowMount} from '@vue/test-utils'
import AuthBloc from '@app/blocs/AuthBloc.ts'
import Header from '@app/components/Header.vue'
import VueRx from 'vue-rx'
import axios from 'axios'
import UserRepository from '@app/repository/UserRepository'
import Vue from 'vue'

jest.mock('axios')
const mockAxios = axios as jest.Mocked<typeof axios>

const localVue = createLocalVue()
localVue.use(VueRx)

const userRepo = new UserRepository(mockAxios)
const authBloc = new AuthBloc(userRepo, new Vue())

describe('HelloWorld.vue', () => {
    afterEach(() => {
        jest.restoreAllMocks()
    })

    it('render successfully', (done) => {
        const data = {
            data: {
                email: 'example@test.com',
                name: 'John Doe',
            },
        }

        mockAxios.get.mockImplementation((): Promise<any> => new Promise<any>((resolve => resolve(data))))
        authBloc.getMe()

        const wrapper = shallowMount(Header, {
            localVue,
            provide: {
                'authBloc': authBloc,
            },
        })
        setTimeout(async () => {
            expect(wrapper.text())
                .toMatch(
                    'Laravel',
                )
            done()
        }, 0)
    })
})
