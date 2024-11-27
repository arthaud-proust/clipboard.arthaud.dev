<script setup lang="ts">
import VButton from '@/Components/Base/VButton.vue';
import { AnonTokenDto, AnonUserDto } from '@/types/generated';
import { usePoll } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

defineProps<{
    anonUser: AnonUserDto;
    anonTokens: Array<AnonTokenDto>;
}>();

const { t } = useI18n();

usePoll(2000);

const anonId = (anonUser: AnonUserDto) => anonUser.email.split('@')[0];
</script>
<template>
    <div
        class="mx-auto flex min-h-dvh max-w-lg flex-col justify-center gap-8 px-2 py-8 text-lg"
    >
        <div>
            <p class="text-neutral-500">{{ t('device_a') }}</p>
            <h1 class="text-5xl">
                {{ t('session', { session: anonId(anonUser) }) }}
            </h1>
            <p v-if="anonTokens.length === 0">
                {{ t('waiting_for_request_from_deviceb') }}
            </p>
            <p v-else>
                {{ t('click_on_the_token_number_displayed_on_deviceb') }}
            </p>
        </div>

        <div class="flex flex-col gap-1" v-if="anonTokens.length > 0">
            <p></p>
            <VButton
                v-for="anonToken in anonTokens"
                :href="route('anon.authenticate', [anonUser, anonToken.token])"
            >
                {{ t('token', { token: anonToken.token }) }}
            </VButton>
        </div>
    </div>
</template>
