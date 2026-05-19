import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

import axiosPlugin from './plugins/axios'

import './bootstrap'

const app = createApp(App)

const pinia = createPinia()

pinia.use(axiosPlugin)

app.use(pinia)
app.use(router)

app.mount('#app')

console.log('SPA App loaded');

// Debug

const api_token = localStorage.getItem('api_token');
console.log('api_token', api_token);
