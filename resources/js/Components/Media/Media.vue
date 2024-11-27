<script setup lang="ts">
import { MediaDto } from '@/types/generated';
import {
    ArrowDownTrayIcon,
    ClipboardDocumentCheckIcon,
    ClipboardIcon,
    DocumentIcon,
} from '@heroicons/vue/24/outline';
import { computed, ref } from 'vue';
import { useI18n } from 'vue-i18n';

const props = defineProps<{
    media: MediaDto;
}>();

const { t } = useI18n();

const isImage = computed(() => props.media.mimetype.startsWith('image/'));

const copied = ref(false);
const copyMedia = async () => {
    try {
        const data = await fetch(props.media.url);
        const blob = await data.blob();
        await navigator.clipboard.write([
            new ClipboardItem({
                [blob.type]: blob,
            }),
        ]);
        copied.value = true;
        setTimeout(() => (copied.value = false), 3_000);
    } catch (err: any) {
        console.error(err.name, err.message);
    }
};
</script>
<template>
    <article
        class="relative overflow-hidden rounded-lg border border-neutral-300 text-lg"
    >
        <div class="flex w-full items-center gap-2">
            <img v-if="isImage" :src="media.url" alt="" class="h-20" />
            <div
                v-else
                class="flex aspect-square h-20 items-center justify-center bg-neutral-50 text-neutral-500"
            >
                <DocumentIcon class="size-8" />
            </div>

            <div class="overflow-hidden p-4">
                <h2 class="overflow-hidden text-ellipsis whitespace-nowrap">
                    {{ media.filename }}
                </h2>
                <p
                    class="overflow-hidden text-ellipsis whitespace-nowrap text-sm text-neutral-500"
                >
                    {{ media.humanReadableSize }} - {{ media.mimetype }}
                </p>
            </div>
        </div>

        <div class="flex">
            <button
                v-if="isImage"
                type="button"
                @click="() => copyMedia()"
                class="flex flex-1 items-center justify-center gap-1 px-4 py-2"
                :class="
                    copied
                        ? 'bg-green-50 text-green-700'
                        : 'bg-neutral-50 text-neutral-800 hover:bg-neutral-100'
                "
            >
                <template v-if="copied">
                    {{ t('copied') }}
                    <ClipboardDocumentCheckIcon class="size-5" />
                </template>
                <template v-else>
                    {{ t('copy') }}
                    <ClipboardIcon class="size-5" />
                </template>
            </button>

            <a
                :href="media.url"
                target="_blank"
                rel="noreferrer noopener"
                class="flex flex-1 items-center justify-center gap-1 bg-neutral-50 px-4 py-2 text-neutral-800 hover:bg-neutral-100"
            >
                {{ t('download') }}
                <ArrowDownTrayIcon class="size-6" />
            </a>
        </div>
    </article>
</template>
