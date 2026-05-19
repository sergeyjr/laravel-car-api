import {defineStore} from 'pinia'
import {api} from '@/api'

export const usePageStore = defineStore('pages', {

    state: () => ({
        pages: {},
        current: null,
        loading: false
    }),

    actions: {

        async fetch(code) {
            if (!code) return

            // cache
            if (this.pages[code]) {
                this.current = this.pages[code]
                return
            }

            this.loading = true

            try {
                const {data} = await api.get(`/api/page/${code}`)

                this.pages[code] = data
                this.current = data

            } catch (e) {
                this.current = null
                throw e
            } finally {
                this.loading = false
            }
        },

        clearCurrent() {
            this.current = null
        }

    }
})
