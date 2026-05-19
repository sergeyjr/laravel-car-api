<script setup>

import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useCarStore } from '@/stores/carStore'
import { useAuthStore } from '@/stores/authStore'
import { useCartStore } from "@/stores/cartStore"

import BaseButton from '@/components/BaseButton.vue'

const router = useRouter()
const store = useCarStore()
const auth = useAuthStore()
const cart = useCartStore()

const changePage = (page) => {
    store.fetch(page)
}

const openCar = (id) => {
    router.push(`/cars/show/${id}`)
}

const getImage = (car) => {
    if (!car.photo_url) return '/images/default_car.jpg'
    if (car.photo_url.startsWith('http')) return car.photo_url
    return `${car.photo_url}`
}

const formatPrice = (price) => {
    return new Intl.NumberFormat('ru-RU').format(price) + ' ₽'
}

const addToCart = (car) => {
    cart.add({
        id: car.id,
        name: car.title,
        price: car.price,
        qty: 1,
        photo_url: car.photo_url
    })
}

const isInCart = (carId) => {
    return Object.values(cart.items || {}).some(
        item => item && item.id === carId
    )
}

onMounted(() => {
    store.fetch(1)

    if (auth.isAuth && Object.keys(cart.items).length === 0) {
        cart.fetch()
    }
})

</script>

<template>
    <div class="container mt-4">

        <h1>Каталог</h1>

        <div v-if="store.loading">Загрузка...</div>

        <div v-else class="row">
            <div
                v-for="car in store.cars"
                :key="car.id"
                class="col-4 mb-3"
            >
                <div
                    class="card"
                    @click="openCar(car.id)"
                    style="cursor:pointer"
                >

                    <img
                        :src="getImage(car)"
                        class="card-img-top"
                        style="height:200px; object-fit:contain;"
                        alt=""
                    >

                    <div class="card-body">
                        <h5>{{ car.title }}</h5>

                        <p v-if="auth.user">
                            {{ formatPrice(car.price) }}
                        </p>

                        <p v-else class="text-muted">
                            Авторизуйтесь, чтобы увидеть цену
                        </p>
                    </div>

                    <div v-if="auth.user" class="p-3 pt-0">

                        <BaseButton
                            v-if="isInCart(car.id)"
                            variant="light"
                            class="w-100"
                            @click.stop="router.push('/cart')"
                        >
                            Товар в корзине
                        </BaseButton>

                        <BaseButton
                            v-else
                            variant="success"
                            class="w-100 d-flex align-items-center justify-content-center gap-2 py-2 rounded-3 shadow-sm"
                            @click.stop="addToCart(car)"
                        >
                            В корзину
                        </BaseButton>

                    </div>

                </div>
            </div>
        </div>

        <div v-if="store.meta" class="d-flex gap-2 mt-3">

            <BaseButton
                variant="secondary"
                :disabled="store.meta.current_page <= 1"
                @click="changePage(store.meta.current_page - 1)"
            >
                Назад
            </BaseButton>

            <BaseButton
                variant="primary"
                :disabled="store.meta.current_page >= store.meta.last_page"
                @click="changePage(store.meta.current_page + 1)"
            >
                Вперёд
            </BaseButton>

        </div>

        <div v-if="store.meta" class="mt-2">
            Страница: {{ store.meta.current_page }} / {{ store.meta.last_page }}
            <br>
            Показано {{ store.meta.from }}–{{ store.meta.to }}
            из {{ store.meta.total }} автомобилей
        </div>

    </div>
</template>
