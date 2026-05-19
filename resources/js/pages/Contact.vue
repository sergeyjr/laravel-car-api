<script setup>

import {useContactStore} from '@/stores/contactStore'

import BaseButton from '@/components/BaseButton.vue'

const store = useContactStore()

</script>

<template>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <h1 class="mb-4">Контактная форма</h1>

                <div v-if="store.contexts.contactPage.successMessage" class="alert alert-success">
                    {{ store.contexts.contactPage.successMessage }}
                </div>

                <div v-if="store.contexts.contactPage.errorMessage" class="alert alert-danger">
                    {{ store.contexts.contactPage.errorMessage }}
                </div>

                <div v-if="store.retryAfter" class="alert alert-warning mt-4">
                    Подождите {{ store.retryAfter }} сек перед повторной отправкой
                </div>

                <form @submit.prevent="store.submit">

                    <div class="mb-3">
                        <label class="form-label" for="contact-name">
                            Имя <span class="text-danger">*</span>
                        </label>
                        <input
                            id="contact-name"
                            type="text"
                            class="form-control"
                            :class="{ 'is-invalid': store.errors.name }"
                            v-model="store.form.name"
                            required
                            autocomplete="name"
                        >
                        <small v-if="store.errors.name" class="text-danger">
                            {{ store.errors.name }}
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
                            :class="{ 'is-invalid': store.errors.email }"
                            v-model="store.form.email"
                            required
                            autocomplete="email"
                        >
                        <small v-if="store.errors.email" class="text-danger">
                            {{ store.errors.email }}
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
                            :class="{ 'is-invalid': store.errors.subject }"
                            v-model="store.form.subject"
                            required
                        >
                        <small v-if="store.errors.subject" class="text-danger">
                            {{ store.errors.subject }}
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="contact-body">
                            Текст сообщения <span class="text-danger">*</span>
                        </label>
                        <textarea
                            id="contact-body"
                            class="form-control"
                            :class="{ 'is-invalid': store.errors.body }"
                            rows="5"
                            v-model="store.form.body"
                            required
                        ></textarea>
                        <small v-if="store.errors.body" class="text-danger">
                            {{ store.errors.body }}
                        </small>
                    </div>

                    <BaseButton variant="primary" type="submit" class="w-100" :loading="store.loading"
                                :disabled="store.retryAfter > 0">
                        <template #loading>Отправляем...</template>
                        Отправить сообщение
                    </BaseButton>

                </form>

            </div>
        </div>
    </div>
</template>
