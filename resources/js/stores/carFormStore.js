import {defineStore} from 'pinia'
import {api} from '@/api'
import {useAlertStore} from '@/stores/alertStore'
import {useAuthStore} from '@/stores/authStore'

export const useCarFormStore = defineStore('carForm', {

    state: () => ({
        form: {
            title: '',
            description: '',
            price: null,
            photo_url: '',
            contacts: '',
            brand: '',
            model: '',
            year: null,
            body: '',
            mileage: null
        },

        errors: {},

        submitting: false,
        generating: false
    }),

    actions: {

        getAlertStore() {
            return useAlertStore()
        },

        showAlert(type, message) {
            this.getAlertStore().add(type, message)
        },

        reset() {
            this.form = {
                title: '',
                description: '',
                price: null,
                photo_url: '',
                contacts: '',
                brand: '',
                model: '',
                year: null,
                body: '',
                mileage: null
            }
            this.errors = {}
        },

        setError(field, message) {
            this.errors[field] = message
        },

        clearErrors() {
            this.errors = {}
        },

        validateOptions() {
            const f = this.form

            const hasAny =
                f.brand || f.model || f.year || f.body || f.mileage

            if (!hasAny) return []

            const missing = []

            if (!f.brand) missing.push('brand')
            if (!f.model) missing.push('model')
            if (!f.year) missing.push('year')
            if (!f.body) missing.push('body')
            if (!f.mileage) missing.push('mileage')

            return missing
        },

        async submit() {

            this.clearErrors()

            const missing = this.validateOptions()

            if (missing.length) {
                missing.forEach(f => this.setError(f, 'Это поле обязательно'))
                this.showAlert('danger', 'Заполните все опции автомобиля')
                return
            }

            this.submitting = true

            try {

                const authStore = useAuthStore();

                const isAuthenticated = await authStore.initAuth();

                if (!isAuthenticated) {
                    console.log('danger', 'Для этого действия требуется авторизация.');
                    return;
                }

                const {data} = await api.post(
                    '/api/v1/car/create',
                    {
                        title: this.form.title,
                        description: this.form.description,
                        price: this.form.price,
                        photo_url: this.form.photo_url,
                        contacts: this.form.contacts,
                        options: {
                            brand: this.form.brand,
                            model: this.form.model,
                            year: this.form.year,
                            body: this.form.body,
                            mileage: this.form.mileage
                        }
                    }
                )

                this.showAlert('success', data.message || 'Успешно создано! ID: ' + data.data.id)

                this.reset()

                return data

            } catch (e) {

                const status = e?.response?.status
                const data = e?.response?.data

                if (status === 401) {
                    localStorage.removeItem('api_token')
                    this.showAlert('danger', 'Сессия истекла, попробуйте снова')
                    return
                }

                if (status === 422) {

                    this.showAlert('error', data.message || 'Ошибка валидации')

                    if (data.errors) {
                        Object.keys(data.errors).forEach(f => {
                            this.setError(f, data.errors[f][0])
                        })
                    }

                } else {
                    this.showAlert('error', data?.message || 'Ошибка сервера')
                }

            } finally {
                this.submitting = false
            }
        },

        async generate() {

            this.generating = true

            try {

                const authStore = useAuthStore();

                const isAuthenticated = await authStore.initAuth();

                if (!isAuthenticated) {
                    console.log('danger', 'Для этого действия требуется авторизация.');
                    return;
                }

                const {data} = await api.get('/api/v1/car/generate-mock')

                const car = data.data

                Object.assign(this.form, {
                    title: car.title,
                    description: car.description,
                    price: car.price,
                    photo_url: car.photo_url,
                    contacts: car.contacts,
                    brand: car.options?.brand,
                    model: car.options?.model,
                    year: car.options?.year,
                    body: car.options?.body,
                    mileage: car.options?.mileage
                })

            } catch (e) {
                console.log('GEN ERROR:', e.response?.data)
                console.log('STATUS:', e.response?.status)

                this.showAlert('error', 'Ошибка генерации данных')
            } finally {
                this.generating = false
            }
        }

    }

})
