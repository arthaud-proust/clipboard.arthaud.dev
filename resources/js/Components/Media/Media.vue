<script setup lang="ts">
import {MediaDto} from "@/types/generated";
import {computed, ref} from "vue";
import {ArrowDownTrayIcon, ClipboardDocumentCheckIcon, ClipboardIcon, DocumentIcon} from '@heroicons/vue/24/outline'

const props = defineProps<{
    media: MediaDto
}>()

const isImage = computed(() => props.media.mimetype.startsWith('image/'))

const copied = ref(false)
const copyMedia = async () => {
    try {
        const data = await fetch(props.media.url)
        const blob = await data.blob();
        await navigator.clipboard.write([
            new ClipboardItem({
                [blob.type]: blob
            })
        ]);
        copied.value = true
        setTimeout(() => copied.value = false, 3_000)
    } catch (err: any) {
        console.error(err.name, err.message);
    }
}
</script>
<template>
    <article class="rounded-lg border border-neutral-300 overflow-hidden relative text-lg">
        <div class="w-full flex items-center gap-2">
            <img v-if="isImage" :src="media.url" alt="" class="h-20" />
            <div v-else class="h-20 aspect-square flex items-center justify-center bg-neutral-50 text-neutral-500">
                <DocumentIcon class="size-8" />
            </div>

            <div class="p-4 overflow-hidden">
                <h2 class="overflow-hidden text-ellipsis whitespace-nowrap">{{ media.filename }}</h2>
                <p class="text-sm text-neutral-500 overflow-hidden text-ellipsis whitespace-nowrap">{{ media.humanReadableSize }} - {{
                        media.mimetype
                    }}</p>
            </div>
        </div>

        <div class="flex">
            <button v-if="isImage" type="button" @click="()=>copyMedia()"
                    class="flex-1 px-4 py-2 flex gap-1 items-center justify-center"
                    :class="copied?'bg-green-50 text-green-700': 'bg-neutral-50 hover:bg-neutral-100 text-neutral-800'"
            >
                <template v-if="copied">
                    Copied!
                    <ClipboardDocumentCheckIcon class="size-5" />
                </template>
                <template v-else>
                    Copy
                    <ClipboardIcon class="size-5" />
                </template>
            </button>

            <a :href="media.url" target="_blank" rel="noreferrer noopener"
               class="flex-1 bg-neutral-50 hover:bg-neutral-100 text-neutral-800 px-4 py-2 flex gap-1 items-center justify-center"
            >
                Download
                <ArrowDownTrayIcon class="size-6" />
            </a>

        </div>
    </article>
</template>
