<script setup>
import { computed, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useCarStore } from '@/stores/carStore'
import { useAuthStore } from '@/stores/authStore'
import { useCartStore } from "@/stores/cartStore"

import BaseButton from "@/components/BaseButton.vue"

const route = useRoute()
const router = useRouter()

const store = useCarStore()
const auth = useAuthStore()
const cart = useCartStore()

const car = computed(() => store.car)
const loading = computed(() => store.carLoading)

const carImage = computed(() => {
    if (!car.value?.photo_url) {
        return '/images/default_car.jpg'
    }
    if (car.value.photo_url.startsWith('http')) {
        return car.value.photo_url
    }
    return `${car.value.photo_url}`
})

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

const loadCar = async (id) => {
    if (!id) return

    store.clearCurrent?.()

    try {
        await store.fetchCar(id)

        // если машина не пришла — редирект на 404
        if (!store.car) {
            await router.push({ name: 'not-found' })
        }
    } catch (e) {
        if (e.response?.status === 404) {
            await router.push({ name: 'not-found' })
        } else {
            store.clearCurrent?.()
        }
    }
}

onMounted(() => {
    loadCar(route.params.id)

    if (auth.isAuth && Object.keys(cart.items || {}).length === 0) {
        cart.fetch()
    }
})

watch(
    () => route.params.id,
    (newId) => loadCar(newId)
)
</script>

<template>
    <div class="container mt-4">

        <div v-if="loading">Загрузка...</div>

        <div v-else-if="!car">
            Автомобиль не найден
        </div>

        <template v-else>

            <div class="row">

                <div class="col-12">
                    <h1 class="mb-4">{{ car.title }}</h1>
                </div>

                <div class="col-12 col-md-5">
                    <img
                        :src="carImage"
                        class="img-fluid rounded"
                        style="max-height: 400px; object-fit: contain;"
                        alt=""
                    >
                </div>

                <div class="col-12 col-md-7">

                    <p><strong>Описание:</strong> {{ car.description }}</p>

                    <div v-if="car.option">
                        <p><strong>Бренд:</strong> {{ car.option.brand }}</p>
                        <p><strong>Модель:</strong> {{ car.option.model }}</p>
                        <p><strong>Год:</strong> {{ car.option.year }}</p>
                        <p><strong>Пробег:</strong> {{ car.option.mileage }}</p>

                        <p v-if="auth.user">
                            <strong>Цена:</strong> {{ formatPrice(car.price) }}
                        </p>

                        <p v-else class="text-muted">
                            Авторизуйтесь, чтобы увидеть цену
                        </p>
                    </div>

                    <div v-if="auth.user">

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

            <hr>

            <router-link to="/cars" class="btn btn-outline-secondary">
                В каталог
            </router-link>

        </template>

    </div>
</template>
