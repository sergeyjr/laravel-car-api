<script setup>
const props = defineProps({
    variant: {
        type: String,
        default: 'primary' // primary | secondary | success | danger | warning | info | light | dark
    },
    loading: {
        type: Boolean,
        default: false
    },
    disabled: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['click'])

const handleClick = (e) => {
    if (props.loading || props.disabled) return
    emit('click', e)
}
</script>

<template>
    <button
        v-bind="$attrs"
        :disabled="loading || disabled"
        :class="[
            'btn',
            `btn-${variant}`,
            { disabled: loading || disabled }
        ]"
        @click="handleClick"
    >
        <!-- LOADING -->
        <span v-if="loading" class="d-inline-flex align-items-center">
            <slot name="loading">Loading...</slot>
        </span>

        <!-- DEFAULT -->
        <span v-else>
            <slot />
        </span>
    </button>
</template>
