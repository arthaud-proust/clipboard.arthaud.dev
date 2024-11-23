<script setup lang="ts">
import {MediaDto} from "@/types/generated";
import {computed} from "vue";
import {ArrowDownTrayIcon, DocumentIcon} from '@heroicons/vue/24/outline'

const props = defineProps<{
    media: MediaDto
}>()

const isImage = computed(() => props.media.mimetype.startsWith('image/'))
</script>
<template>
    <article class="flex items-center gap-2 rounded-xl border border-neutral-300 overflow-hidden relative">
        <img v-if="isImage" :src="media.url" alt="" class="h-20" />
        <div v-else class="h-20 aspect-square flex items-center justify-center bg-neutral-50 text-neutral-500">
            <DocumentIcon class="size-8" />
        </div>
        <div class="p-4 overflow-hidden">
            <h2 class="text-lg overflow-hidden text-ellipsis whitespace-nowrap">{{ media.filename }}</h2>
            <p class="text-sm text-neutral-500 overflow-hidden text-ellipsis whitespace-nowrap">{{ media.humanReadableSize }} - {{
                    media.mimetype
                }}</p>
        </div>

        <a :href="media.url" class="absolute top-0 left-0 h-full w-full group" target="_blank" rel="noreferrer noopener">
            <span class="hidden group-hover:flex items-center justify-center h-full gap-2 bg-white opacity-90 text-lg">
                Download
                <ArrowDownTrayIcon class="size-6" />
            </span>
        </a>
    </article>
</template>
