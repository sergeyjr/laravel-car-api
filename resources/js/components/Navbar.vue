<script setup>

import {onMounted, computed} from 'vue'
import {useAuthStore} from '@/stores/authStore'
import {useAuthActions} from '@/composables/useAuthActions'
import {useCartStore} from '@/stores/cartStore'

const auth = useAuthStore()
const cart = useCartStore()

const appName = import.meta.env.VITE_APP_NAME || 'My App'
const {handleLogout} = useAuthActions()

onMounted(() => {
    if (auth.isAuth) {
        cart.fetch()
    }
})

const cartCount = computed(() => {
    return Object.values(cart.items || {}).filter(Boolean).length
})

</script>

<template>
    <nav v-if="auth.initialized" class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">

            <router-link class="navbar-brand text-white text-decoration-none" to="/">
                {{ appName }}
            </router-link>

            <div class="nav-divider d-flex align-items-center">

                <router-link class="nav-link d-inline text-white" to="/cars">
                    Каталог
                </router-link>

                <span class="text-white mx-2">|</span>

                <router-link class="nav-link d-inline text-white" to="/contact">
                    Контакты
                </router-link>

                <span class="text-white mx-2">|</span>

                <router-link class="nav-link d-inline text-white" to="/page/about">
                    О проекте
                </router-link>

                <span class="text-white mx-2">|</span>

                <router-link class="nav-link d-inline text-white" to="/page/info">
                    Инфо (БД)
                </router-link>

                <template v-if="auth.isAuth">
                    <span class="text-white mx-2">|</span>

                    <router-link class="nav-link d-inline text-white" to="/dashboard">
                        Личный кабинет
                    </router-link>
                </template>

                <template v-if="auth.isAuth">
                    <span class="text-white mx-2">|</span>

                    <router-link
                        class="nav-link d-inline text-white position-relative"
                        to="/cart"
                    >
                        Корзина

                        <span
                            v-if="cartCount > 0"
                            class="badge bg-danger ms-1"
                            style="font-size: 11px;"
                        >
                            {{ cartCount }}
                        </span>
                    </router-link>
                </template>

                <span class="text-white mx-2">|</span>

                <a
                    v-if="auth.isAuth"
                    href="#"
                    class="nav-link d-inline text-white"
                    @click.prevent="handleLogout"
                >
                    Выход
                </a>

                <router-link
                    v-else
                    class="nav-link d-inline text-white"
                    to="/login"
                >
                    Вход
                </router-link>

            </div>

        </div>
    </nav>
</template>

<style scoped>

.navbar {
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
}

.navbar .nav-link {
    transition: 0.2s;
}

.navbar .nav-link:hover {
    opacity: 0.8;
    text-decoration: underline;
}

</style>
