<script setup>

import {computed, onMounted} from 'vue'
import {useRouter} from 'vue-router'

import {useAuthStore} from '@/stores/authStore'
import {useAuthActions} from '@/composables/useAuthActions'
import {useCarStore} from '@/stores/carStore'
import {useContactStore} from '@/stores/contactStore'

import BaseButton from '@/components/BaseButton.vue'

const router = useRouter()

// Статус пользователя, Быстрые действия

const auth = useAuthStore()

const {handleLogout} = useAuthActions()

const user = computed(() => auth.user)

// Новинки

import {Navigation, Pagination} from 'swiper/modules'
import {Swiper, SwiperSlide} from 'swiper/vue'

import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/pagination'

const modules = [Navigation, Pagination]

const swiperOptions = {
    slidesPerView: 3,
    slidesPerGroup: 3,
    spaceBetween: 20,
    navigation: true,
    pagination: {
        clickable: true
    },
    loop: true,
    speed: 600,
    breakpoints: {
        320: {slidesPerView: 1, slidesPerGroup: 1},
        768: {slidesPerView: 2, slidesPerGroup: 2},
        1024: {slidesPerView: 3, slidesPerGroup: 3}
    }
}

const carStore = useCarStore()

onMounted(() => {
    carStore.fetchLatest()
})

const getImage = (car) => {
    if (!car.photo_url) return '/images/default_car.jpg'
    return car.photo_url.startsWith('http') ? car.photo_url : car.photo_url
}

const formatPrice = (price) => {
    return new Intl.NumberFormat('ru-RU').format(price) + ' ₽'
}

const openCar = (id) => {
    router.push(`/cars/show/${id}`)
}

// Связаться с нами

const contactStore = useContactStore()

</script>

<template>
    <div class="container my-4">

        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold">Главная страница</h1>
            <p class="text-muted">Простой проект Laravel 13 + Vue 3</p>
        </div>

        <div class="row g-4">

            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h4 class="card-title">Статус пользователя</h4>

                        <div v-if="auth.isAuth">
                            <p class="text-muted">Добро пожаловать, {{ user?.name }}</p>
                            <p class="text-success mb-0">Вы авторизованы</p>
                        </div>

                        <div v-else>
                            <p class="text-warning mb-0">Вы гость</p>
                            <small class="text-muted">
                                Войдите или зарегистрируйтесь, чтобы получить доступ ко всем функциям
                            </small>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h4 class="card-title">Быстрые действия</h4>

                        <template v-if="auth.isAuth">

                            <BaseButton
                                variant="primary"
                                class="w-100 mb-2"
                                @click="router.push('/dashboard/profile')"
                            >
                                Профиль
                            </BaseButton>

                            <BaseButton
                                variant="danger"
                                class="w-100"
                                :loading="auth.loading"
                                @click="handleLogout"
                            >
                                <template #loading>
                                    Выход...
                                </template>
                                Выйти
                            </BaseButton>

                        </template>

                        <template v-else>

                            <BaseButton
                                variant="primary"
                                class="w-100 mb-2"
                                @click="router.push('/login')"
                            >
                                Войти
                            </BaseButton>

                            <BaseButton
                                variant="secondary"
                                class="w-100"
                                @click="router.push('/register')"
                            >
                                Регистрация
                            </BaseButton>

                        </template>

                    </div>
                </div>
            </div>

            <div class="col-12 mt-5">
                <h2 class="mb-4">Новинки</h2>

                <div v-if="carStore.latestLoading">
                    Загрузка новинок...
                </div>

                <div v-else>

                    <Swiper
                        :modules="modules"
                        v-bind="swiperOptions"
                        class="swiper-custom"
                    >

                        <SwiperSlide v-for="car in carStore.latest" :key="car.id">
                            <div class="card h-100" style="cursor:pointer" @click="openCar(car.id)">
                                <img
                                    :src="getImage(car)"
                                    class="card-img-top"
                                    style="height:200px; object-fit:contain;"
                                    alt="">

                                <div class="card-body">
                                    <h5>{{ car.title }}</h5>

                                    <p v-if="auth.user">
                                        {{ formatPrice(car.price) }}
                                    </p>

                                    <p v-else class="text-muted">
                                        Авторизуйтесь, чтобы увидеть цену
                                    </p>
                                </div>
                            </div>
                        </SwiperSlide>

                    </Swiper>

                </div>
            </div>

            <div class="col-6 offset-3 mt-5">

                <h4 class="mb-3">Связаться с нами</h4>

                <div v-if="contactStore.contexts.home.successMessage" class="alert alert-success">
                    {{ contactStore.contexts.home.successMessage }}
                </div>

                <div v-if="contactStore.contexts.home.errorMessage" class="alert alert-danger">
                    {{ contactStore.contexts.home.errorMessage }}
                </div>

                <div v-if="contactStore.retryAfter" class="alert alert-warning">
                    Подождите {{ contactStore.retryAfter }} сек перед повторной отправкой
                </div>

                <form @submit.prevent="contactStore.submit">

                    <div class="mb-3">
                        <label class="form-label" for="contact-name">
                            Имя <span class="text-danger">*</span>
                        </label>
                        <input
                            id="contact-name"
                            type="text"
                            class="form-control"
                            :class="{ 'is-invalid': contactStore.errors.name }"
                            v-model="contactStore.form.name"
                            required
                            autocomplete="name"
                        >
                        <small v-if="contactStore.errors.name" class="text-danger">
                            {{ contactStore.errors.name }}
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="contact-email">
                            Email <span class="text-danger">*</span>
                        </label>
                        <input
                            id="contact-email"
                            type="email"
                            class="form-control"
                            :class="{ 'is-invalid': contactStore.errors.email }"
                            v-model="contactStore.form.email"
                            required
                            autocomplete="email"
                        >
                        <small v-if="contactStore.errors.email" class="text-danger">
                            {{ contactStore.errors.email }}
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="contact-subject">
                            Тема сообщения <span class="text-danger">*</span>
                        </label>
                        <input
                            id="contact-subject"
                            type="text"
                            class="form-control"
                            :class="{ 'is-invalid': contactStore.errors.subject }"
                            v-model="contactStore.form.subject"
                            required
                        >
                        <small v-if="contactStore.errors.subject" class="text-danger">
                            {{ contactStore.errors.subject }}
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="contact-body">
                            Текст сообщения <span class="text-danger">*</span>
                        </label>
                        <textarea
                            id="contact-body"
                            class="form-control"
                            :class="{ 'is-invalid': contactStore.errors.body }"
                            rows="5"
                            v-model="contactStore.form.body"
                            required
                        ></textarea>
                        <small v-if="contactStore.errors.body" class="text-danger">
                            {{ contactStore.errors.body }}
                        </small>
                    </div>

                    <BaseButton variant="primary" type="submit" class="w-100" :loading="contactStore.loading"
                                :disabled="contactStore.retryAfter > 0">
                        <template #loading>Отправляем...</template>
                        Отправить сообщение
                    </BaseButton>

                </form>


            </div>

        </div>

    </div>
</template>

<style scoped>

.swiper-custom {
    padding: 20px 0 40px 0;
}

.swiper-custom :deep(.swiper-wrapper) {
    margin: 0;
}

.swiper-custom :deep(.swiper-slide) {
    overflow: visible;
}

.swiper-custom :deep(.swiper-slide) .card {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    will-change: transform;
}

.swiper-custom :deep(.swiper-slide):hover .card {
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.18);
    z-index: 10;
}

.swiper-custom :deep(.card-img-top) {
    width: 100%;
    height: 200px;
    object-fit: contain;
    display: block;
}

.swiper-custom :deep(.swiper-pagination) {
    bottom: 0 !important;
}

</style>
