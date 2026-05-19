import {defineStore} from 'pinia'
import {api} from '@/api'

export const useContactStore = defineStore('contact', {

    state: () => ({

        form: {
            name: '',
            email: '',
            subject: '',
            body: ''
        },

        errors: {},

        loading: false,

        retryAfter: null,
        timer: null,

        contexts: {
            home: {
                successMessage: '',
                errorMessage: ''
            },
            contactPage: {
                successMessage: '',
                errorMessage: ''
            }
        }

    }),

    actions: {

        resetErrors() {
            this.errors = {
                name: '',
                email: '',
                subject: '',
                body: ''
            }
        },

        resetForm() {
            this.form = {
                name: '',
                email: '',
                subject: '',
                body: ''
            }
            this.errors = {}
        },

        resetMessages(context) {
            this.contexts[context].successMessage = ''
            this.contexts[context].errorMessage = ''
        },

        startCountdown() {
            if (this.timer) clearInterval(this.timer)

            this.timer = setInterval(() => {
                if (this.retryAfter > 0) {
                    this.retryAfter--
                } else {
                    clearInterval(this.timer)
                    this.timer = null
                }
            }, 1000)
        },

        async submit(context = 'home') {

            this.loading = true
            this.resetErrors()
            this.resetMessages(context)

            try {

                await api.get('/sanctum/csrf-cookie')
                const {data} = await api.post('/api/contact', this.form)

                this.resetForm()

                this.contexts[context].successMessage =
                    data.message || 'Сообщение отправлено успешно'

            } catch (e) {

                if (e.response?.status === 422) {
                    this.errors = e.response.data.errors || {}
                    return
                }

                if (e.response?.status === 429) {
                    this.retryAfter = e.response.data?.retry_after ?? null
                    this.startCountdown()
                    return
                }

                this.contexts[context].errorMessage =
                    'Произошла ошибка при отправке формы'

                console.error('error:', e)

            } finally {
                this.loading = false
            }
        }

    }

})
