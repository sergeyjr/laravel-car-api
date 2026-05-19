import {defineStore} from "pinia"
import {api} from "@/api"

function cleanItems(obj) {
    return Object.fromEntries(
        Object.entries(obj || {}).filter(([_, item]) => item != null)
    )
}

export const useCartStore = defineStore("cart", {
    state: () => {
        const raw = JSON.parse(localStorage.getItem('cartItems')) || {}

        return {
            items: cleanItems(raw),
            initialized: false
        }
    },

    getters: {
        total: (state) =>
            Object.values(state.items).reduce((sum, item) => {
                if (!item) return sum
                return sum + Number(item.price) * Number(item.qty)
            }, 0)
    },

    actions: {

        saveToLocalStorage() {
            localStorage.setItem('cartItems', JSON.stringify(this.items))
        },

        async fetch(force = false) {
            try {
                if (this.initialized && !force) return

                if (!force && Object.keys(this.items).length > 0) {
                    this.initialized = true
                    return
                }

                const res = await api.get("/api/cart")
                const serverItems = cleanItems(res.data)

                if (Object.keys(serverItems).length > 0) {
                    this.items = serverItems
                    this.saveToLocalStorage()
                }

            } catch (error) {
                console.error("Ошибка загрузки корзины:", error)
            } finally {
                this.initialized = true
            }
        },

        async add(newItem) {
            const id = newItem.id
            const backup = JSON.parse(JSON.stringify(this.items))

            if (this.items[id]) {
                this.items[id].qty += newItem.qty ?? 1
            } else {
                this.items[id] = {
                    id: newItem.id,
                    name: newItem.name,
                    price: newItem.price,
                    qty: newItem.qty ?? 1,
                    photo_url: newItem.photo_url || null
                }
            }

            this.saveToLocalStorage()

            try {
                await api.get('/sanctum/csrf-cookie')
                await api.post("/api/cart/add", {
                    id,
                    qty: newItem.qty ?? 1
                })
                console.log('cart add success', newItem.qty ?? 1)
            } catch (error) {
                console.error("Ошибка добавления в корзину:", error)
                this.items = backup
                this.saveToLocalStorage()
            }
        },

        async update(id, qty) {
            if (!id || qty < 1) return

            const backup = JSON.parse(JSON.stringify(this.items))

            if (this.items[id]) {
                this.items[id].qty = qty
            }

            this.saveToLocalStorage()

            try {
                await api.get('/sanctum/csrf-cookie')
                await api.post("/api/cart/update", {id, qty})
                console.log('cart update success', qty)
            } catch (error) {
                console.error("Ошибка обновления корзины:", error)
                this.items = backup
                this.saveToLocalStorage()
            }
        },

        async remove(id) {
            const backup = JSON.parse(JSON.stringify(this.items))

            delete this.items[id]
            this.saveToLocalStorage()

            try {
                await api.get('/sanctum/csrf-cookie')
                await api.post("/api/cart/remove", {id})
                console.log('cart remove success')
            } catch (error) {
                console.error("Ошибка удаления из корзины:", error)
                this.items = backup
                this.saveToLocalStorage()
            }
        },

        async clear() {
            const backup = JSON.parse(JSON.stringify(this.items))

            this.items = {}
            this.saveToLocalStorage()

            try {
                await api.get('/sanctum/csrf-cookie')
                await api.post("/api/cart/clear")
                console.log('cart clear success')
            } catch (error) {
                console.error("Ошибка очистки корзины:", error)
                this.items = backup
                this.saveToLocalStorage()
            }
        },

        async checkout(payload = {}) {
            const backup = JSON.parse(JSON.stringify(this.items))
            console.log('checkout')

            try {
                await api.get('/sanctum/csrf-cookie')

                const res = await api.post("/api/orders/checkout", {
                    comment: payload.comment || null
                })

                this.items = {}
                this.saveToLocalStorage()

                return res.data

            } catch (error) {
                console.error("Ошибка оформления заказа:", error)
                this.items = backup
                this.saveToLocalStorage()
                throw error
            }
        }

    }
})
