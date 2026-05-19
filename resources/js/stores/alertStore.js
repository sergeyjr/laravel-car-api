import {defineStore} from 'pinia'

export const useAlertStore = defineStore('alert', {

    state: () => ({
        alerts: []
    }),

    actions: {
        add(type, message) {
            const id = Date.now()

            const timeout = setTimeout(() => {
                this.remove(id)
            }, 60000)

            this.alerts.push({id, type, message, timeout})
        },

        remove(id) {
            const alert = this.alerts.find(a => a.id === id)
            if (alert?.timeout) {
                clearTimeout(alert.timeout)
            }

            this.alerts = this.alerts.filter(a => a.id !== id)
        },

        clear() {
            this.alerts = []
        }
    }

})
