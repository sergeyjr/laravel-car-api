<script setup>

import {onMounted} from 'vue'
import {useCarFormStore} from '@/stores/carFormStore'

import BaseInput from '@/components/BaseInput.vue'
import BaseButton from '@/components/BaseButton.vue'

const store = useCarFormStore()

onMounted(() => {
    store.reset()
})

const submit = () => store.submit()
const generate = () => store.generate()

</script>

<template>
    <div class="container mt-4">

        <h1 class="mb-4">Создание автомобиля</h1>

        <form @submit.prevent="submit">

            <div class="row">

                <div class="col-6">

                    <BaseInput
                        v-model="store.form.title"
                        name="title"
                        id="title"
                        label="Заголовок"
                        :error="store.errors.title"
                    />

                    <BaseInput
                        v-model="store.form.description"
                        name="description"
                        id="description"
                        label="Описание"
                        :error="store.errors.description"
                    />

                    <BaseInput
                        v-model="store.form.price"
                        type="number"
                        name="price"
                        id="price"
                        label="Цена"
                        :error="store.errors.price"
                    />

                    <BaseInput
                        v-model="store.form.photo_url"
                        name="photo_url"
                        id="photo_url"
                        label="Фото"
                        :error="store.errors.photo_url"
                    />

                    <BaseInput
                        v-model="store.form.contacts"
                        name="contacts"
                        id="contacts"
                        label="Контакты"
                        :error="store.errors.contacts"
                    />

                </div>

                <div class="col-6">

                    <BaseInput
                        v-model="store.form.brand"
                        name="brand"
                        id="brand"
                        label="Марка"
                        :error="store.errors.brand"
                    />

                    <BaseInput
                        v-model="store.form.model"
                        name="model"
                        id="model"
                        label="Модель"
                        :error="store.errors.model"
                    />

                    <BaseInput
                        v-model="store.form.year"
                        type="number"
                        name="year"
                        id="year"
                        label="Год"
                        :error="store.errors.year"
                    />

                    <BaseInput
                        v-model="store.form.body"
                        name="body"
                        id="body"
                        label="Кузов"
                        :error="store.errors.body"
                    />

                    <BaseInput
                        v-model="store.form.mileage"
                        type="number"
                        name="mileage"
                        id="mileage"
                        label="Пробег"
                        :error="store.errors.mileage"
                    />

                </div>

            </div>

            <div class="mt-3">

                <BaseButton
                    type="submit"
                    variant="primary"
                    :disabled="store.submitting || store.generating"
                    :loading="store.submitting"
                >
                    <template #loading>
                        Отправляем...
                    </template>
                    Отправить
                </BaseButton>

                <BaseButton
                    type="button"
                    variant="secondary"
                    class="ms-2"
                    :disabled="store.submitting || store.generating"
                    :loading="store.generating"
                    @click="generate"
                >
                    <template #loading>
                        Получаем данные...
                    </template>
                    Сгенерировать
                </BaseButton>

            </div>

        </form>

    </div>
</template>
