<script setup>

import {onMounted, computed} from 'vue'
import {useRoute} from 'vue-router'
import {useOrderStore} from '@/stores/orderStore'

import {orderStatusLabel} from '@/shared/orderStatus'

const route = useRoute()
const store = useOrderStore()

const order = computed(() => store.currentOrder)

onMounted(async () => {
    await store.fetchOrder(route.params.id)
})

</script>

<template>
    <div class="container mt-4">

        <div v-if="!order">
            Загрузка...
        </div>

        <div v-else>

            <h2>Заказ #{{ order.id }}</h2>

            <p class="text-muted">
                Статус: <strong>{{ orderStatusLabel(order.status) }}</strong>
            </p>

            <hr>

            <div class="row g-3">

                <div
                    v-for="item in order.items"
                    :key="item.id"
                    class="col-12"
                >
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3">

                        <!-- LEFT: IMAGE + INFO -->
                        <div class="d-flex align-items-center gap-3">

                            <router-link :to="`/cars/show/${item.car_id}`">
                                <img
                                    :src="item.photo_url || '/images/default_car.jpg'"
                                    alt="car"
                                    style="width: 90px; height: 60px; object-fit: contain; border-radius: 6px;"
                                />
                            </router-link>

                            <div>
                                <strong>
                                    {{ item.name || ('Машина #' + item.car_id) }}
                                </strong>

                                <div class="text-muted small">
                                    {{ item.qty }} × {{ item.price }} ₽
                                </div>
                            </div>

                        </div>

                        <!-- RIGHT: TOTAL -->
                        <div class="fw-bold">
                            {{ item.qty * item.price }} ₽
                        </div>

                    </div>
                </div>

            </div>

            <h4 class="text-success mt-3">
                Итого: {{ order.total }} ₽
            </h4>

        </div>

    </div>
</template>
