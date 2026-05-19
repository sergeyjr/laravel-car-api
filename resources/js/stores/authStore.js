import {defineStore} from 'pinia'
import {api} from '@/api'
import {useAlertStore} from '@/stores/alertStore'

export const useAuthStore = defineStore('auth', {

    state: () => ({
        user: null,
        initialized: false,
        loading: false,
        error: null,
        errors: {},
        success: null,
        token: localStorage.getItem('api_token') || null,
        loggingOut: false,
    }),

    getters: {
        isAuth: (state) => !!state.user,
    },

    actions: {

        resetMessages() {
            this.error = null
            this.errors = {}
            this.success = null
        },

        async fetchUser() {
            try {
                const {data} = await api.get('/me')
                this.user = data.user
                return true
            } catch (e) {
                console.log('ME ERROR', e.response?.status)
                this.user = null
                return false
            }
        },

        async initAuth() {
            if (this.initialized) {
                return this.isAuth
            }
            try {
                return await this.fetchUser()
            } catch (e) {
                console.error(e)
                this.user = null
                return false
            } finally {
                this.initialized = true
            }
        },

        async register(payload, router) {
            this.loading = true
            this.resetMessages()
            try {
                await api.get('/sanctum/csrf-cookie')
                const {data} = await api.post('/register', payload)
                this.user = data.user
                const alertStore = useAlertStore()
                alertStore.add('success', data.message)
                // this.token = data.token
                // localStorage.setItem('api_token', data.token)
                // router.push(data.redirect || '/dashboard')
                return true
            } catch (e) {
                if (e.response?.status === 422) {
                    this.errors = e.response.data.errors || {}
                } else {
                    this.error =
                        e.response?.data?.message ||
                        'Ошибка регистрации'
                }
                return false
            } finally {
                this.loading = false
            }
        },

        async login(email, password) {
            this.loading = true
            this.resetMessages()
            try {
                await api.get('/sanctum/csrf-cookie')
                const {data} = await api.post('/login', {
                    email,
                    password
                })
                this.user = data.user
                this.token = data.token
                localStorage.setItem('api_token', data.token)
                return true
            } catch (e) {
                console.log(e)
                if (e.response?.status === 422) {
                    this.errors = e.response.data.errors || {}
                } else {
                    this.error =
                        e.response?.data?.message ||
                        'Ошибка авторизации'
                }
                return false
            } finally {
                this.loading = false
            }
        },

        async logout() {
            this.loggingOut = true;
            try {
                await api.get('/sanctum/csrf-cookie')
                await api.post('/logout')
            } catch (e) {
                console.error(e)
            } finally {
                this.user = null
                this.token = null;
                this.loggingOut = false;
                localStorage.removeItem('api_token')
            }
        }

    }

})
