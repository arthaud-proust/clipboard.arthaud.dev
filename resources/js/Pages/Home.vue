<script setup lang="ts">
import {Head, router} from '@inertiajs/vue3';
import {TextDto} from "@/types/generated";
import TextCardInput from "@/Components/Text/TextCardInput.vue";
import {XMarkIcon} from '@heroicons/vue/20/solid'

defineProps<{
    texts?: Array<TextDto>;
    focusTextId?: TextDto['id']
}>();

const save = (text: TextDto | Omit<TextDto, "id">) => {
    if ("id" in text) {
        if (text.content === "") {
            return destroy(text)
        }

        router.put(route('texts.update', text.id), {
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

const destroy = (text: TextDto) => {
    router.delete(route('texts.destroy', text), {
        preserveState: false,
    })
}
</script>

<template>
    <Head title="Clipboard" />

    <div class="max-w-lg mx-auto flex flex-col gap-2 pt-20">
        <h1 class="text-2xl mb-2">Clipboard</h1>

        <article class="w-full">
            <TextCardInput class="w-full" @save="save" placeholder="Nouvelle note..." />
        </article>
        <article v-for="text in texts" class="w-full flex">
            <TextCardInput :text="text" class="w-full" @save="save" :focused="focusTextId === text.id " />
            <button class="p-2 flex items-start text-black hover:text-red-700" @click="()=>destroy(text)">
                <XMarkIcon class="size-6" />
            </button>
        </article>
    </div>
</template>
