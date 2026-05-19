<script setup>
import {useRoute, useRouter} from 'vue-router'
import {onMounted, computed} from 'vue'
import {useOrderStore} from '@/stores/orderStore'
import {orderStatusLabel, orderStatusClass} from '@/shared/orderStatus'

const route = useRoute()
const router = useRouter()
const store = useOrderStore()

const orderId = computed(() => route.params.id)
const order = computed(() => store.currentOrder)

const formatPrice = (price) =>
    new Intl.NumberFormat('ru-RU').format(price)

onMounted(async () => {
    if (!orderId.value) {
        router.push('/')
        return
    }

    await store.fetchOrder(orderId.value)
})
</script>

<template>
    <div class="container py-5">

        <!-- MAIN CARD -->
        <div class="card shadow-sm mx-auto" style="max-width: 720px;">

            <div class="card-body p-4">

                <!-- HEADER -->
                <div class="text-center mb-4">

                    <div
                        class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10 text-success fw-bold mb-3"
                        style="width: 64px; height: 64px; font-size: 28px;">
                        ✔
                    </div>

                    <h3 class="fw-bold mb-2">
                        Заказ успешно оформлен
                    </h3>

                    <p class="text-muted mb-0">
                        Мы отправили подтверждение и начали обработку заказа
                    </p>

                </div>

                <!-- LOADING -->
                <div v-if="!order" class="text-center text-muted py-5">
                    Загрузка заказа...
                </div>

                <!-- CONTENT -->
                <div v-else>

                    <!-- ORDER INFO -->
                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded mb-3">

                        <div>
                            <div class="text-muted small">Номер заказа</div>
                            <div class="fw-bold">#{{ order.id }}</div>
                        </div>

                        <div class="text-end">
                            <div class="text-muted small">Сумма</div>
                            <div class="fw-bold text-primary fs-5">
                                {{ formatPrice(order.total) }} ₽
                            </div>
                        </div>

                    </div>

                    <!-- STATUS -->
                    <div class="text-center mb-4">

                        <span
                            class="badge bg-warning text-dark fs-6 px-3 py-2"
                            :class="orderStatusClass(order.status)"
                        >
                            {{ orderStatusLabel(order.status) }}
                        </span>

                    </div>

                    <!-- ITEMS -->
                    <div v-if="order.items?.length" class="d-flex flex-column gap-2">

                        <div
                            v-for="item in order.items"
                            :key="item.id"
                            class="d-flex justify-content-between align-items-center p-2 bg-light rounded"
                        >

                            <!-- LEFT -->
                            <div>
                                <div class="fw-semibold">
                                    {{ item.name || ('Товар #' + item.car_id) }}
                                </div>

                                <div class="text-muted small">
                                    {{ formatPrice(item.price) }} ₽ × {{ item.qty }}
                                </div>
                            </div>

                            <!-- RIGHT -->
                            <div class="fw-bold text-primary">
                                {{ formatPrice(item.price * item.qty) }} ₽
                            </div>

                        </div>

                    </div>

                    <!-- COMMENT -->
                    <div v-if="order.comment" class="mt-4 p-3 bg-light rounded">

                        <div class="text-muted small mb-1">
                            Комментарий
                        </div>

                        <div>
                            {{ order.comment }}
                        </div>

                    </div>

                    <!-- ACTIONS -->
                    <div class="d-flex justify-content-center gap-2 mt-4">

                        <router-link to="/cars" class="btn btn-outline-secondary">
                            Продолжить покупки
                        </router-link>

                        <router-link to="/orders" class="btn btn-primary">
                            Мои заказы
                        </router-link>

                    </div>

                </div>

            </div>

        </div>

    </div>
</template>
