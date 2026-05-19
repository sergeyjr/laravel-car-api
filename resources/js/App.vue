<template>
    <Navbar/>
    <Alerts/>
    <router-view/>
</template>

<script setup>

import Navbar from '@/components/Navbar.vue'
import Alerts from '@/components/Alerts.vue'

</script>
