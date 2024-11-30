<script setup lang="ts">
import VButton from '@/Components/Base/VButton.vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
</script>

<template>
    <article class="space-y-2 rounded-xl bg-amber-500 p-4 text-white">
        <p class="text-2xl font-bold">{{ t('a_better_tool_exists') }}</p>
        <p>{{ t('send_files_and_texts_in_a_more_secure_and_direct_w') }}</p>
        <VButton href="https://localsend.org/" external variant="secondary"
            >{{ t('discover_localsend') }}
        </VButton>
    </article>
</template>
