<script setup>
import { onMounted, computed } from 'vue'
import { useOrderStore } from '@/stores/orderStore'
import { useRouter } from 'vue-router'

const store = useOrderStore()
const router = useRouter()

const orders = computed(() => store.orders || [])
const loading = computed(() => store.loading)

onMounted(async () => {
    await store.fetchOrders()
})

const formatPrice = (price) => {
    return new Intl.NumberFormat('ru-RU').format(price) + ' ₽'
}

const goToOrder = (id) => {
    router.push(`/orders/${id}`)
}

const goBack = () => {
    // нормальный fallback
    if (window.history.length > 1) {
        router.back()
    } else {
        router.push('/dashboard')
    }
}
</script>

<template>
    <div class="container mt-4">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Мои заказы</h2>

            <button
                class="btn btn-outline-secondary"
                @click="goBack"
            >
                ← Назад
            </button>
        </div>

        <!-- LOADING -->
        <div v-if="loading" class="alert alert-light">
            Загружается...
        </div>

        <!-- EMPTY -->
        <div v-else-if="!orders.length" class="row">
            <div class="col-12">
                <div class="alert alert-light">
                    У вас пока нет заказов
                </div>

                <router-link
                    to="/dashboard"
                    class="btn btn-outline-secondary"
                >
                    В панель управления
                </router-link>
            </div>
        </div>

        <!-- ORDERS LIST -->
        <div v-else class="row g-3">

            <div
                v-for="order in orders"
                :key="order.id"
                class="col-12 col-md-6 col-lg-4"
            >
                <div class="card h-100 shadow-sm border-0 mb-3">

                    <div class="card-body d-flex flex-column justify-content-between">

                        <div>
                            <h5 class="mb-1">
                                Заказ #{{ order.id }}
                            </h5>

                            <div class="text-muted small">
                                {{ new Date(order.created_at).toLocaleString('ru-RU') }}
                            </div>

                            <div class="mt-2">
                                <span class="badge">
                                    {{ order.status }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-3 d-flex justify-content-between align-items-end">

                            <div>
                                <div class="fw-bold text-success fs-5">
                                    {{ formatPrice(order.total) }}
                                </div>

                                <small class="text-muted">
                                    {{ order.items?.length || 0 }} товаров
                                </small>
                            </div>

                            <button
                                class="btn btn-outline-primary btn-sm"
                                @click="goToOrder(order.id)"
                            >
                                Подробнее
                            </button>

                        </div>

                    </div>

                </div>
            </div>

            <div class="col-12 mt-3">
                <button
                    class="btn btn-outline-secondary"
                    @click="router.back()"
                >
                    ← Назад
                </button>
            </div>

        </div>

    </div>
</template>
