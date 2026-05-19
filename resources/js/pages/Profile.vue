<script setup>

import {computed, watch} from 'vue'
import {useAuthStore} from '@/stores/authStore'
import {useProfileStore} from '@/stores/profileStore'
import {useRouter} from 'vue-router'

const auth = useAuthStore()
const profile = useProfileStore()
const router = useRouter()

const user = computed(() => auth.user)

watch(
    () => auth.user,
    (user) => {
        if (user) {
            profile.load(user)
        }
    },
    {immediate: true}
)

const avatarUrl = computed(() => {
    if (user.value?.avatar) {
        return `/storage/${user.value.avatar}?t=${Date.now()}`
    }
    return '/images/default-avatar.png'
})

const formatDate = (date) => {
    if (!date) return ''
    return new Date(date).toLocaleDateString('ru-RU', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

</script>

<template>
    <div class="container mt-4">
        <div class="row">

            <h1 class="mb-3">Мой профиль</h1>

            <!-- LEFT -->
            <div class="col-md-4">

                <div class="card mb-3">
                    <div class="card-body d-flex flex-column align-items-center text-center">

                        <img
                            :src="avatarUrl"
                            class="rounded-circle mb-3 avatar"
                            width="120"
                            height="120"
                            @click="profile.openAvatar"
                            alt="">

                        <h4>{{ user?.name }}</h4>
                        <p class="text-muted">{{ user?.email }}</p>

                        <small class="text-muted">
                            Создан: {{ formatDate(user?.created_at) }}
                        </small>

                    </div>
                </div>

                <!-- MODAL -->
                <div
                    v-if="profile.showAvatarModal"
                    class="avatar-modal"
                    @click="profile.closeAvatar"
                >
                    <img
                        :src="avatarUrl"
                        class="avatar-full"
                        @click.stop
                        alt=""/>
                </div>

                <div class="card">
                    <div class="card-body">

                        <button
                            class="btn btn-danger w-100"
                            @click="profile.deleteAccount(auth, router)"
                        >
                            Удалить аккаунт
                        </button>

                    </div>
                </div>

            </div>

            <!-- RIGHT -->
            <div class="col-md-8">

                <!-- PROFILE UPDATE -->
                <div class="card mb-3">
                    <div class="card-header">
                        Редактирование профиля
                    </div>
                    <div class="card-body">

                        <div v-if="profile.errors.general" class="alert alert-danger mb-3">
                            {{ profile.errors.general }}
                        </div>

                        <form @submit.prevent="profile.updateProfile">

                            <div class="mb-3">
                                <label class="form-label" for="profile-name">
                                    Имя
                                </label>
                                <input
                                    id="profile-name"
                                    type="text"
                                    class="form-control"
                                    :class="{ 'is-invalid': profile.errors.name }"
                                    v-model="profile.form.name"
                                >
                                <small v-if="profile.errors.name" class="text-danger">
                                    {{ profile.errors.name[0] }}
                                </small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="profile-email">
                                    Email
                                </label>
                                <input
                                    id="profile-email"
                                    type="email"
                                    class="form-control"
                                    :class="{ 'is-invalid': profile.errors.email }"
                                    v-model="profile.form.email"
                                >
                                <small v-if="profile.errors.email" class="text-danger">
                                    {{ profile.errors.email[0] }}
                                </small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="profile-avatar">
                                    Аватар
                                </label>
                                <input
                                    id="profile-avatar"
                                    type="file"
                                    class="form-control"
                                    :class="{ 'is-invalid': profile.errors.avatar }"
                                    @change="profile.onFile"
                                    :key="profile.form.avatar ? 1 : 2"
                                >
                                <small v-if="profile.errors.avatar" class="text-danger">
                                    {{ profile.errors.avatar[0] }}
                                </small>
                            </div>

                            <div class="form-check mb-3">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="remove-avatar"
                                    v-model="profile.form.remove_avatar"
                                >
                                <label class="form-check-label" for="remove-avatar">
                                    Удалить аватар
                                </label>
                            </div>

                            <button
                                class="btn btn-primary w-100"
                                :disabled="profile.loading"
                            >
                                {{ profile.loading ? 'Сохраняем...' : 'Сохранить' }}
                            </button>

                        </form>
                    </div>
                </div>

                <!-- PASSWORD -->
                <div class="card mb-3">

                    <div class="card-header">
                        Смена пароля
                    </div>

                    <div class="card-body">
                        <form @submit.prevent="profile.changePassword">

                            <div v-if="profile.passwordSuccess" class="alert alert-success mb-3">
                                Пароль успешно обновлён!
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="current-password">
                                    Текущий пароль <span class="text-danger">*</span>
                                </label>
                                <input
                                    id="current-password"
                                    type="password"
                                    class="form-control"
                                    :class="{ 'is-invalid': profile.errors.current_password }"
                                    v-model="profile.passwordForm.current_password"
                                    required
                                >
                                <small v-if="profile.errors.current_password" class="text-danger">
                                    {{ profile.errors.current_password[0] }}
                                </small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="new-password">
                                    Новый пароль <span class="text-danger">*</span>
                                </label>
                                <input
                                    id="new-password"
                                    type="password"
                                    class="form-control"
                                    :class="{ 'is-invalid': profile.errors.password }"
                                    v-model="profile.passwordForm.password"
                                    required
                                >
                                <small v-if="profile.errors.password" class="text-danger">
                                    {{ profile.errors.password[0] }}
                                </small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="confirm-password">
                                    Подтверждение пароля <span class="text-danger">*</span>
                                </label>
                                <input
                                    id="confirm-password"
                                    type="password"
                                    class="form-control"
                                    :class="{ 'is-invalid': profile.errors.password_confirmation }"
                                    v-model="profile.passwordForm.password_confirmation"
                                    required
                                >
                                <small v-if="profile.errors.password_confirmation" class="text-danger">
                                    {{ profile.errors.password_confirmation[0] }}
                                </small>
                            </div>

                            <button
                                type="submit"
                                class="btn btn-warning w-100"
                                :disabled="profile.loading"
                            >
                                {{ profile.loading ? 'Сохраняем...' : 'Обновить пароль' }}
                            </button>

                        </form>

                    </div>
                </div>

                <router-link to="/dashboard" class="btn btn-outline-secondary">
                    Назад
                </router-link>

            </div>

        </div>
    </div>
</template>

<style scoped>

.card img.avatar {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 50%;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card img.avatar:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.avatar-modal {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.85);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.avatar-full {
    max-width: 80vw;
    max-height: 80vh;
    width: auto;
    height: auto;
    object-fit: contain;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
}

</style>
