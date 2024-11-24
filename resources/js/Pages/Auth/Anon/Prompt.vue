<script setup lang="ts">
import VButton from '@/Components/Base/VButton.vue';
import { AnonTokenDto, AnonUserDto } from '@/types/generated';
import { usePoll } from '@inertiajs/vue3';

defineProps<{
    anonUser: AnonUserDto;
    anonTokens: Array<AnonTokenDto>;
}>();

usePoll(2000);

const anonId = (anonUser: AnonUserDto) => anonUser.email.split('@')[0];
</script>
<template>
    <div
        class="mx-auto flex min-h-dvh max-w-lg flex-col justify-center gap-8 px-2 py-8 text-lg"
    >
        <div>
            <p class="text-neutral-500">Device A</p>
            <h1 class="text-5xl">Session {{ anonId(anonUser) }}</h1>
            <p v-if="anonTokens.length === 0">
                Waiting for request from device B...
            </p>
            <p v-else>Click on the token number displayed on device B.</p>
        </div>

        <div class="flex flex-col gap-1" v-if="anonTokens.length > 0">
            <p></p>
            <VButton
                v-for="anonToken in anonTokens"
                :href="route('anon.authenticate', [anonUser, anonToken.token])"
            >
                Token {{ anonToken.token }}
            </VButton>
        </div>
    </div>
</template>
