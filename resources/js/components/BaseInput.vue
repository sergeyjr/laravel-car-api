<script setup>

import { computed } from 'vue'

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: ''
    },
    type: {
        type: String,
        default: 'text'
    },
    label: {
        type: String,
        default: ''
    },
    required: {
        type: Boolean,
        default: false
    },
    placeholder: {
        type: String,
        default: ''
    },
    hint: {
        type: String,
        default: ''
    },
    error: {
        type: String,
        default: ''
    },
    disabled: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['update:modelValue'])

const value = computed({
    get: () => props.modelValue,
    set: (val) => emit('update:modelValue', val)
})

</script>

<template>
    <div class="form-group mb-3">

        <!-- LABEL -->
        <label v-if="label" class="form-label">
            {{ label }}
            <span v-if="required" class="text-danger ms-1">*</span>
        </label>

        <!-- INPUT -->
        <input
            :type="type"
            v-model="value"
            :placeholder="placeholder"
            :disabled="disabled"
            class="form-control"
            :class="{ 'is-invalid': error }"
        />

        <!-- HINT -->
        <small v-if="hint && !error" class="form-text text-muted">
            {{ hint }}
        </small>

        <!-- ERROR -->
<!--        <div v-if="error" class="invalid-feedback d-block">-->
<!--            {{ error }}-->
<!--        </div>-->

    </div>
</template>
