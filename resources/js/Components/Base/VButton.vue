<template>
    <component
        :is="href ? (external ? 'a' : Link) : 'button'"
        :type="href ? undefined : type"
        :disabled="disabled"
        :href="disabled ? undefined : href"
        class="flex items-center justify-center gap-1 rounded-lg px-4 py-2 font-bold ring-offset-2 focus:outline-none focus:ring-4 disabled:pointer-events-none disabled:opacity-50"
        :class="classes"
    >
        <slot />
    </component>
</template>
<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = withDefaults(
    defineProps<{
        href?: string;
        type?: 'button' | 'submit';
        variant?: 'primary' | 'secondary' | 'tertiary' | 'danger' | 'success';
        disabled?: boolean;
        external?: boolean;
    }>(),
    {
        type: 'button',
        variant: 'primary',
    },
);

const classes = computed(() => {
    if (props.variant === 'primary') {
        return 'bg-amber-500 ring-amber-700 hover:bg-amber-600 text-amber-50';
    }

    if (props.variant === 'secondary') {
        return 'bg-amber-50 ring-amber-700 hover:bg-amber-100 text-amber-800';
    }

    if (props.variant === 'tertiary') {
        return 'bg-neutral-50 ring-neutral-700 hover:bg-neutral-100 text-neutral-800';
    }

    if (props.variant === 'danger') {
        return 'bg-red-500 ring-red-700 hover:bg-red-600 text-red-50';
    }

    if (props.variant === 'success') {
        return 'bg-green-500 ring-green-700 hover:bg-green-600 text-green-50';
    }
});
</script>
