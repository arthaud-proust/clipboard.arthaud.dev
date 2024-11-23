<script setup lang="ts">
import {Head, router} from '@inertiajs/vue3';
import {MediaDto, TextDto} from "@/types/generated";
import TextCardInput from "@/Components/Text/TextCardInput.vue";
import {PlusIcon, XMarkIcon} from '@heroicons/vue/24/outline'
import {useFileDialog} from '@vueuse/core'
import Media from "@/Components/Media/Media.vue";

const props = defineProps<{
    texts?: Array<TextDto>;
    medias?: Array<MediaDto>;
    focusTextId?: TextDto['id']
}>();

const saveText = (text: TextDto | Omit<TextDto, "id">) => {
    if ("id" in text && text.id) {
        if (text.content === "") {
            return destroyText(text)
        }

        router.put(route('texts.update', text), {
            content: text.content,
        }, {
            preserveState: false,
        })
    } else {
        router.post(route('texts.store'), {
            content: text.content,
        }, {
            preserveState: false,
        })
    }
}

const destroyText = (text: TextDto) => {
    router.delete(route('texts.destroy', text), {
        preserveState: false,
    })
}


const {files, open, reset, onChange} = useFileDialog({
    accept: '*',
    directory: false,
})

onChange((files) => {
    const file = files?.item(0)

    if (!file) return;

    router.post(route('medias.store'), {
        file,
    }, {
        preserveState: false,
    })
})

const destroyMedia = (media: MediaDto) => {
    router.delete(route('medias.destroy', media), {
        preserveState: false,
    })
}

const order = (obj: { updatedAt: string }) => Date.parse(obj.updatedAt) / 1000;
</script>

<template>
    <Head title="Clipboard" />

    <div class="px-2 max-w-lg mx-auto flex flex-col gap-2 pt-20">
        <h1 class="text-2xl mb-2">Clipboard</h1>

        <article class="w-full flex">
            <TextCardInput class="w-full" @save="saveText" placeholder="Add note..." :focused="!focusTextId || texts?.length===0" />
        </article>

        <button type="button" @click="()=>open()" class="rounded-xl border border-neutral-300 px-4 py-2 mr-auto flex gap-1 items-center text-lg">
            Add file

            <PlusIcon class="size-5" />
        </button>

        <div class="flex flex-col-reverse gap-2">
            <div v-for="media in medias" class="w-full flex" :style="{order: order(media)}">
                <Media class="w-full" :media="media" />
                <button class="p-2 flex items-start text-black hover:text-red-700" @click="()=>destroyMedia(media)">
                    <XMarkIcon class="size-6" />
                </button>
            </div>

            <article v-for="text in texts" class="w-full flex" :style="{order: order(text)}">
                <TextCardInput :text="text" class="w-full" @save="saveText" :focused="focusTextId === text.id " />
                <button class="p-2 flex items-start text-black hover:text-red-700" @click="()=>destroyText(text)">
                    <XMarkIcon class="size-6" />
                </button>
            </article>
        </div>
    </div>
</template>
