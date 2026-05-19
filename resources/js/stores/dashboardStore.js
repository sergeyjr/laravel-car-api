import { defineStore } from 'pinia'
import { api } from '@/api'

export const useDashboardStore = defineStore('dashboard', {

    state: () => ({
        orders: [],
        ordersCount: 0,
        carsCount: 0,

        cart: {},
        cartTotal: 0,

        loading: false,
        loaded: false,
        error: null
    }),

    actions: {

        async fetchDashboard() {
            this.loading = true

            try {

                const { data } = await api.get('/api/dashboard')

                this.carsCount = data.carsCount || 0

                this.ordersCount = data.ordersCount || 0
                this.orders = data.orders || []

                this.cart = data.cart || {}
                this.cartTotal = data.cartTotal || 0

                this.loaded = true

            } catch (e) {
                this.error = e
                console.error('Dashboard error:', e)

            } finally {
                this.loading = false
            }
        }

    }

})
