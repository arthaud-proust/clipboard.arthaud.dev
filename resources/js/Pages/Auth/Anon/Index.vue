<script setup lang="ts">
import VButton from '@/Components/Base/VButton.vue';
import { AnonUserDto } from '@/types/generated';
import { usePoll } from '@inertiajs/vue3';

defineProps<{
    anonUsers: Array<AnonUserDto>;
    token: string;
}>();

usePoll(2000);

const anonId = (anonUser: AnonUserDto) => anonUser.email.split('@')[0];
</script>
<template>
    <div
        class="mx-auto flex min-h-dvh max-w-lg flex-col justify-center gap-8 px-2 py-8 text-lg"
    >
        <div>
            <p class="text-neutral-500">Device B</p>
            <h1 class="text-3xl">Select session</h1>
            <p>Click on the session number of device A.</p>
        </div>

        <div class="flex flex-col gap-1">
            <VButton
                v-for="anonUser in anonUsers"
                :href="route('anon.login', [anonUser, token])"
            >
                {{ anonId(anonUser) }}
            </VButton>
        </div>
    </div>
</template>
