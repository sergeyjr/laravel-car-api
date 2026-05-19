import {defineStore} from 'pinia'
import {api} from '@/api'

export const useCarStore = defineStore('cars', {

    state: () => ({
        cars: [],
        meta: null,
        loading: false,

        cache: new Map(),

        car: null,
        carLoading: false,
        carCache: new Map(),

        latest: [],
        latestLoaded: false,
        latestLoading: false
    }),

    actions: {

        async fetch(page = 1) {

            if (!page || page < 1) return

            if (this.cache.has(page)) {
                const cached = this.cache.get(page)
                this.cars = cached.items
                this.meta = cached.meta
                return
            }

            this.loading = true

            try {

                const response = await api.get('/api/cars', {
                    params: {page}
                })

                const payload = response.data || {}

                const items = Array.isArray(payload.data)
                    ? payload.data
                    : []

                const meta = {
                    current_page: payload.current_page ?? 1,
                    last_page: payload.last_page ?? 1,
                    from: payload.from ?? null,
                    to: payload.to ?? null,
                    total: payload.total ?? 0,
                    per_page: payload.per_page ?? items.length
                }

                this.cars = items
                this.meta = meta

                this.cache.set(page, {
                    items,
                    meta: {...meta}
                })

            } catch (e) {
                console.error('Ошибка загрузки машин:', e)
                this.cars = []
                this.meta = null
            } finally {
                this.loading = false
            }
        },

        async fetchCar(id) {

            if (!id) return

            if (this.carCache.has(id)) {
                this.car = this.carCache.get(id)
                return
            }

            this.carLoading = true
            this.car = null

            try {
                const {data} = await api.get(`/api/cars/${id}`)

                this.car = data.data
                this.carCache.set(id, data.data)

            } catch (e) {
                console.error('Ошибка загрузки машины:', e)
                this.car = null
            } finally {
                this.carLoading = false
            }
        },

        async fetchLatest() {

            if (this.latestLoaded) return

            this.latestLoading = true

            try {
                const {data} = await api.get('/api/cars/latest')

                this.latest = data.data ?? data
                this.latestLoaded = true

            } catch (e) {
                console.error('Ошибка загрузки новинок:', e)
                this.latest = []
            } finally {
                this.latestLoading = false
            }
        }

    }

})
