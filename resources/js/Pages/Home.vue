<script setup lang="ts">
import {Head, router} from '@inertiajs/vue3';
import {MediaDto, TextDto} from "@/types/generated";
import TextCardInput from "@/Components/Text/TextCardInput.vue";
import {PlusIcon, XMarkIcon} from '@heroicons/vue/24/outline'
import {useFileDialog} from '@vueuse/core'
import Media from "@/Components/Media/Media.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ref} from "vue";

const props = defineProps<{
    texts?: Array<TextDto>;
    medias?: Array<MediaDto>;
    focusTextId?: TextDto['id']
}>();

const destroyedTextIds = ref<Array<TextDto['id']>>([])
const saveText = (text: TextDto | Omit<TextDto, 'id' | 'updatedAt' | 'createdAt'>) => {
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
    destroyedTextIds.value.push(text.id)
    router.delete(route('texts.destroy', text), {
        preserveState: false,
    })
}


const createMedia = (file: File) => {
    router.post(route('medias.store'), {
        file,
    }, {
        preserveState: false,
    })
}

const destroyedMediaIds = ref<Array<MediaDto['id']>>([])
const {open, onChange} = useFileDialog({
    accept: '*',
    directory: false,
})
onChange((files) => {
    const file = files?.item(0)
    if (!file) return;

    createMedia(file)
})

const destroyMedia = (media: MediaDto) => {
    destroyedMediaIds.value.push(media.id)
    router.delete(route('medias.destroy', media), {
        preserveState: false,
    })
}

const order = (obj: { updatedAt: string }) => Date.parse(obj.updatedAt) / 1000;

const handlePaste = (e: ClipboardEvent) => {
    const file = e.clipboardData?.files.item(0);
    if (file) {
        return createMedia(file)
    }
}

</script>

<template>
    <Head title="Clipboard" />

    <AuthenticatedLayout>
        <div class="px-2 max-w-lg mx-auto flex flex-col gap-2 py-20" @paste="handlePaste">
            <h1 class="text-2xl mb-2">Clipboard</h1>

            <article class="w-full flex">
                <TextCardInput class="w-full" @save="saveText" placeholder="Copy anything..." :focused="!focusTextId || texts?.length===0" />
            </article>

            <button type="button" @click="()=>open()"
                    class="rounded-lg border border-neutral-100 bg-neutral-50 text-neutral-800 px-4 py-2 mr-auto flex gap-1 items-center text-lg">
                Select file

                <PlusIcon class="size-5" />
            </button>

            <div class="mt-6 flex flex-col-reverse gap-2">
                <template v-for="media in medias">
                    <div v-if="!destroyedMediaIds.includes(media.id)" class="w-full flex" :style="{order: order(media)}">
                        <Media class="w-full" :media="media" />
                        <button class="p-2 flex items-start text-black hover:text-red-700" @click="()=>destroyMedia(media)">
                            <XMarkIcon class="size-6" />
                        </button>
                    </div>
                </template>

                <template v-for="text in texts">
                    <article v-if="!destroyedTextIds.includes(text.id)" class="w-full flex" :style="{order: order(text)}">
                        <TextCardInput :text="text" class="w-full" @save="saveText" :focused="focusTextId === text.id " copiable />
                        <button class="p-2 flex items-start text-black hover:text-red-700" @click="()=>destroyText(text)">
                            <XMarkIcon class="size-6" />
                        </button>
                    </article>
                </template>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
