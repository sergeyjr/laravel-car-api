<script setup>

import {onMounted, computed} from 'vue'
import {useAuthStore} from '@/stores/authStore'
import {useDashboardStore} from '@/stores/dashboardStore'

const auth = useAuthStore()
const dashboard = useDashboardStore()

const user = computed(() => auth.user)
const isApiUser = computed(() => auth.user?.role === 'api')

const ordersCount = computed(() => dashboard.ordersCount)

const recentOrders = computed(() => dashboard.orders || [])

const cartCount = computed(() =>
    Object.values(dashboard.cart || {}).reduce(
        (sum, item) => sum + (item.qty || 0),
        0
    )
)

const cartTotal = computed(() => dashboard.cartTotal || 0)

onMounted(async () => {
    if (!auth.initialized) {
        await auth.initAuth()
    }

    await dashboard.fetchDashboard()
})

</script>

<template>
    <div class="container mt-4">

        <h1 class="mb-3">Панель управления</h1>

        <div v-if="dashboard.loading">Загрузка...</div>

        <template v-else>

            <!-- GRID -->
            <div class="row">

                <!-- PROFILE -->
                <div class="col-12 col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">

                            <h5>Мой профиль</h5>
                            <p>Добро пожаловать, {{ user?.name || 'пользователь' }}</p>
                            <p>{{ user?.email || 'пользователь' }}</p>

                            <router-link
                                to="/dashboard/profile"
                                class="btn btn-outline-secondary w-100 mt-3"
                            >
                                Мой профиль
                            </router-link>

                        </div>
                    </div>
                </div>

                <!-- CARS -->
                <div class="col-12 col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">

                            <h5>Каталог</h5>

                            <p class="mb-0">Машины: <span class="fw-bold">{{ dashboard.carsCount }}</span></p>

                            <router-link
                                v-if="isApiUser"
                                to="/dashboard/car/create"
                                class="btn btn-primary w-100 mt-3"
                            >
                                Добавить авто
                            </router-link>

                            <router-link
                                to="/cars"
                                class="btn btn-outline-primary w-100 mt-3"
                            >
                                Перейти в каталог
                            </router-link>

                        </div>
                    </div>
                </div>

                <!-- ORDERS -->
                <div class="col-12 col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">

                            <div>
                                <h5>Мои заказы</h5>
                                <p class="mb-1 text-muted">Всего заказов: {{ ordersCount }}</p>
                            </div>

                            <div v-if="!recentOrders.length" class="btn btn-outline-secondary mt-3">
                                У вас пока нет заказов
                            </div>

                            <div v-else>
                                <router-link
                                    to="/orders"
                                    class="btn btn-outline-primary w-100 mt-3"
                                >
                                    Смотреть заказы
                                </router-link>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- CART -->
                <div class="col-12 col-md-4 mb-3">
                    <div class="card h-100">

                        <div class="card-body d-flex flex-column justify-content-between">

                            <div>
                                <h5>Корзина</h5>
                                <p class="mb-1 text-muted">Товаров: <span class="fw-bold">{{ cartCount }}</span></p>
                                <p class="mb-0">Стоимость: <span class="fw-bold">{{
                                        new Intl.NumberFormat('ru-RU').format(cartTotal)
                                    }} &#8381;</span></p>
                            </div>

                            <div v-if="cartTotal === 0" class="btn btn-outline-secondary w-100 mt-3">
                                Корзина пустая
                            </div>

                            <div v-else>
                                <router-link
                                    to="/cart"
                                    class="btn btn-outline-success w-100 mt-3"
                                >
                                    Перейти в корзину
                                </router-link>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

            <!-- RECENT ORDERS -->
            <div v-if="recentOrders.length" class="mt-4">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Последние заказы</h4>
                </div>

                <div
                    v-for="order in recentOrders"
                    :key="order.id"
                    class="col-12 col-md-6 col-lg-4"
                >
                    <div class="card h-100 shadow-sm border-0">

                        <div class="card-body d-flex flex-column justify-content-between">

                            <div>
                                <h6 class="mb-1 text-truncate">
                                    Заказ #{{ order.id }}
                                </h6>

                                <div class="text-muted small">
                                    {{ new Date(order.created_at).toLocaleString('ru-RU') }}
                                </div>

                                <div class="mt-2">
                                        <span
                                            class="badge"
                                            :class="{
                                                'bg-warning': order.status === 'pending',
                                                'bg-success': order.status === 'paid',
                                                'bg-danger': order.status === 'cancelled',
                                                'bg-secondary': order.status === 'completed'
                                            }"
                                        >
                                            {{ order.status }}
                                        </span>
                                </div>
                            </div>

                            <div class="mt-3 d-flex justify-content-between align-items-center">

                                <div class="fw-bold text-success">
                                    {{ new Intl.NumberFormat('ru-RU').format(order.total) }} ₽
                                </div>

                                <router-link
                                    :to="`/orders/${order.id}`"
                                    class="btn btn-sm btn-outline-primary"
                                >
                                    открыть
                                </router-link>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </template>

    </div>
</template>
