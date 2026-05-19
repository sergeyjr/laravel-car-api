<script setup>
import {useContactStore} from '@/stores/contactStore'
import BaseButton from '@/components/BaseButton.vue'

const store = useContactStore()
</script>

<template>
    <div class="col-6 offset-3 mt-5">

        <h4 class="mb-3">Связаться с нами</h4>

        <div v-if="store.retryAfter" class="alert alert-warning">
            Подождите {{ store.retryAfter }} сек перед повторной отправкой
        </div>

        <form @submit.prevent="store.submit">

            <input
                class="form-control mb-2"
                placeholder="Имя"
                v-model="store.form.name"
            />
            <small v-if="store.errors.name" class="text-danger">{{ store.errors.name }}</small>

            <input
                class="form-control mb-2"
                placeholder="Email"
                v-model="store.form.email"
            />
            <small v-if="store.errors.email" class="text-danger">{{ store.errors.email }}</small>

            <input
                class="form-control mb-2"
                placeholder="Тема"
                v-model="store.form.subject"
            />
            <small v-if="store.errors.subject" class="text-danger">{{ store.errors.subject }}</small>

            <textarea
                class="form-control mb-2"
                rows="4"
                placeholder="Сообщение"
                v-model="store.form.body"
            ></textarea>
            <small v-if="store.errors.body" class="text-danger">{{ store.errors.body }}</small>

            <BaseButton
                class="w-100"
                type="submit"
                variant="primary"
                :loading="store.loading"
                :disabled="store.retryAfter > 0"
            >
                <template #loading>Отправка...</template>
                Отправить
            </BaseButton>

        </form>

    </div>
</template>
