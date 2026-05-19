import {defineStore} from 'pinia'
import {api} from '@/api'
import {useAuthStore} from '@/stores/authStore'
import {useAlertStore} from '@/stores/alertStore'

export const useProfileStore = defineStore('profile', {

    state: () => ({

        form: {
            name: '',
            email: '',
            avatar: null,
            remove_avatar: false
        },

        passwordForm: {
            current_password: '',
            password: '',
            password_confirmation: ''
        },

        errors: {},

        loading: false,
        success: false,

        showAvatarModal: false

    }),

    actions: {

        /* -------------------------
           INIT
        ------------------------- */

        load(user) {
            if (!user) return

            this.form.name = user.name
            this.form.email = user.email
            this.form.avatar = null
            this.form.remove_avatar = false
        },

        onFile(e) {
            this.form.avatar = e.target.files[0]

            if (this.form.avatar) {
                this.form.remove_avatar = false
            }
        },

        openAvatar() {
            this.showAvatarModal = true
        },

        closeAvatar() {
            this.showAvatarModal = false
        },

        resetErrors() {
            this.errors = {
                name: '',
                email: '',
                subject: '',
                body: ''
            }
        },

        /* -------------------------
           UPDATE PROFILE
        ------------------------- */

        async updateProfile() {

            this.loading = true
            this.resetErrors()

            const alertStore = useAlertStore()

            try {

                const fd = new FormData()

                fd.append('name', this.form.name)
                fd.append('email', this.form.email)

                if (this.form.avatar) {
                    fd.append('avatar', this.form.avatar)
                }

                if (this.form.remove_avatar) {
                    fd.append('remove_avatar', 1)
                }

                await api.get('/sanctum/csrf-cookie')

                const {data} = await api.post('/api/profile/update', fd)

                const auth = useAuthStore()

                if (data.user) {
                    auth.user = data.user
                }

                this.form.avatar = null
                this.form.remove_avatar = false
                this.errors = {}
                this.success = true

                alertStore.add('success', data.message || 'Профиль успешно обновлён')

            } catch (e) {

                if (e.response?.status === 422) {
                    this.errors = e.response.data.errors || {}
                    return
                }

                alertStore.add('error', 'Ошибка обновления профиля')
                console.error('error:', e)

            } finally {
                this.loading = false
            }
        },

        /* -------------------------
           CHANGE PASSWORD
        ------------------------- */

        async changePassword() {

            this.loading = true
            this.resetErrors()

            const alertStore = useAlertStore()

            try {

                await api.get('/sanctum/csrf-cookie')

                const {data} = await api.post('/api/profile/password', this.passwordForm)

                this.passwordForm = {
                    current_password: '',
                    password: '',
                    password_confirmation: ''
                }

                this.errors = {}
                this.success = true

                alertStore.add('success', data.message || 'Пароль успешно обновлён')

            } catch (e) {

                if (e.response?.status === 422) {
                    this.errors = e.response.data.errors || {}
                    return
                }

                alertStore.add('error', 'Ошибка смены пароля')
                console.error('error:', e)

            } finally {
                this.loading = false
            }

        },

        /* -------------------------
           DELETE ACCOUNT
        ------------------------- */

        async deleteAccount(auth, router) {

            if (!confirm('Удалить аккаунт?')) return

            this.loading = true
            this.resetErrors()

            const alertStore = useAlertStore()

            try {

                await api.get('/sanctum/csrf-cookie')

                await api.delete('/api/profile')

                this.errors = {}
                this.success = true

                auth.user = null
                router.push('/')

            } catch (e) {

                if (e.response?.status === 422) {
                    this.errors = e.response.data.errors || {}
                    return
                }

                alertStore.add('error', 'Ошибка удаления аккаунта')
                console.error('error:', e)

            } finally {
                this.loading = false
            }

        }

    }

})
