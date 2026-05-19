<script setup>

import {computed} from 'vue'
import {useAuthStore} from '@/stores/authStore'
import BaseButton from '@/components/BaseButton.vue'

const props = defineProps({
    show: {
        type: Boolean,
        required: true
    }
})

const emit = defineEmits(['close'])

const authStore = useAuthStore()
const isProcessing = computed(() => authStore.loggingOut)

const close = () => {
    emit('close')
}

const confirmLogout = async () => {
    await authStore.logout()
    close()
}

</script>

<template>
    <div class="modal-mask" @click.self="close">
        <div class="modal-wrapper">
            <div class="modal-container">
                <div class="modal-header">
                    <h3>Подтверждение выхода</h3>
                    <span class="close-modal" @click="close">×</span>
                </div>

                <div class="modal-body">
                    <p>Вы уверены, что хотите выйти из своего аккаунта?</p>
                </div>

                <div class="modal-footer">
                    <BaseButton @click="close" type="secondary" :disabled="isProcessing">Отмена</BaseButton>
                    <BaseButton @click="confirmLogout" :disabled="isProcessing" :loading="isProcessing">
                        Выход
                    </BaseButton>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-wrapper {
    display: flex;
}

.modal-container {
    background: white;
    border-radius: 4px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    width: 400px;
}

.modal-header {
    padding: 1rem;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-body {
    padding: 1rem;
}

.modal-footer {
    padding: 1rem;
    border-top: 1px solid #eee;
    display: flex;
    justify-content: flex-end;
}

.close-modal {
    cursor: pointer;
}

</style>
