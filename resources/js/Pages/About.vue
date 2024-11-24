<script setup lang="ts">
import VButton from "@/Components/Base/VButton.vue";

defineProps<{
    usersCount: number;
    transfersCount: number;
    sizeTransferred: number;
}>()
</script>
<template>
    <div class="min-h-dvh max-w-lg mx-auto px-2 py-8 flex flex-col gap-8 text-lg justify-center">
        <div>
            <h1 class="text-5xl">Clipboard</h1>
            <p class="pl-1">Copy content across devices with ease.</p>
        </div>

        <div>
            <h2 class="text-2xl">Statistics</h2>
            <p>{{ usersCount }} users</p>
            <p>{{ Math.round(sizeTransferred / 1000) }} kb transferred with {{ transfersCount }} transfers</p>
            <p>0 kb stored more than 1 hour</p>
        </div>

        <div>
            <h2 class="text-2xl">How it works ?</h2>
            <ol class="list-decimal list-inside">
                <li>Login on device A and paste content</li>
                <li>Login on device B, then copy content</li>
            </ol>
        </div>

        <div class="flex flex-col gap-1">
            <VButton :href="route('register')">
                Register
            </VButton>
            <VButton :href="route('login')" variant="secondary">
                Login
            </VButton>
            <VButton disabled variant="tertiary">
                Use anonymously (Soon)
            </VButton>
        </div>
    </div>
</template>
