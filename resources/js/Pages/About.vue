<script setup lang="ts">
import VButton from '@/Components/Base/VButton.vue';

defineProps<{
    usersCount: number;
    transfersCount: number;
    sizeTransferred: number;
}>();
</script>
<template>
    <div
        class="mx-auto flex min-h-dvh max-w-lg flex-col justify-center gap-12 px-2 pb-8 pt-40 text-lg"
    >
        <div>
            <h1 class="text-5xl font-bold">Clipboard</h1>
            <p class="pl-1">Copy content across devices with ease.</p>
        </div>

        <div class="space-y-1">
            <h2 class="text-2xl">How it works ?</h2>
            <ol class="list-inside list-decimal">
                <li>Login on device A and paste content</li>
                <li>Login on device B, then copy content</li>
            </ol>
        </div>

        <div class="space-y-1">
            <h2 class="text-2xl">Quick use</h2>
            <p>
                Create temporary sessions and link two devices together quickly.
            </p>
            <div class="flex flex-wrap gap-1">
                <VButton
                    :href="route('anon.register')"
                    class="flex-1 whitespace-nowrap"
                    variant="primary"
                >
                    Device A : create session
                </VButton>
                <VButton
                    :href="route('anon.index')"
                    class="flex-1 whitespace-nowrap"
                    variant="primary"
                >
                    Device B : link session
                </VButton>
            </div>
        </div>

        <div class="space-y-1">
            <h2 class="text-2xl">Recurrent user ?</h2>
            <div class="flex flex-wrap gap-1">
                <VButton
                    :href="route('register')"
                    class="flex-1"
                    variant="secondary"
                >
                    Register
                </VButton>
                <VButton
                    :href="route('login')"
                    class="flex-1"
                    variant="secondary"
                >
                    Login
                </VButton>
            </div>
        </div>

        <div class="mt-auto text-center text-base text-neutral-500">
            <p>
                {{ usersCount }} users -
                {{ Math.round(sizeTransferred / 1000) }} kb transferred with
                {{ transfersCount }} transfers
            </p>
        </div>
    </div>
</template>
