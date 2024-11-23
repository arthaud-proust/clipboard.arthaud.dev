<template>
    <input
        :type="type"
        :disabled="disabled"
        class="font-bold rounded-lg px-4 py-2 flex gap-1 items-center justify-center disabled:pointer-events-none disabled:opacity-50 focus:outline-none focus:ring-4 ring-offset-2"
    >
</template>
<script setup lang="ts">

const props = withDefaults(
    defineProps<{
        href?: string,
        type?: 'text' | 'password' | 'number' | 'email'
        disabled?: boolean
    }>(),
    {
        type: 'text',
        variant: 'primary'
    }
)
</script>
