<script setup lang="ts">

import {computed, useSlots} from "vue";

const slots = useSlots()

const sorted = computed(() => {
    console.log(slots)
    return slots
})
</script>
<template>
    <div>
        <template v-for="slot in slots" v-slot:[slot.slotName]="slotProps">
            <component :key="slot.Id" :someProp="slotProps"></component>
        </template>
    </div>
</template>
