import {defineStore} from "pinia"
import {api} from "@/api"

export const useOrderStore = defineStore("order", {
    state: () => ({
        currentOrder: null,
        orders: [],

        loading: false,
        error: null
    }),

    actions: {

        async fetchOrder(id) {
            this.loading = true
            this.error = null

            try {
                const res = await api.get(`/api/orders/${id}`)
                this.currentOrder = res.data
            } catch (e) {
                this.error = e
                console.error(e)
            } finally {
                this.loading = false
            }
        },

        async fetchOrders() {
            this.loading = true
            this.error = null

            try {
                const res = await api.get('/api/orders')
                this.orders = res.data
            } catch (e) {
                this.error = e
                console.error(e)
            } finally {
                this.loading = false
            }
        }

    }

})
