<script setup lang="ts">
import {TextDto} from "@/types/generated";
import {useClipboard, useDebounceFn} from "@vueuse/core";
import {computed, onMounted, ref} from "vue";
import {ClipboardDocumentCheckIcon, ClipboardIcon} from "@heroicons/vue/24/outline";

const props = withDefaults(
    defineProps<{
        text?: TextDto | Omit<TextDto, 'id' | 'updatedAt' | 'createdAt'>
        focused?: boolean
        placeholder?: string
        copiable?: boolean
    }>(),
    {
        text: () => ({
            content: ''
        })
    }
)

const emit = defineEmits<{
    save: [typeof props.text]
}>()

const text = ref(props.text)

const debouncedSave = useDebounceFn(() => {
    emit('save', text.value)
}, 1_000)

const textContent = computed({
    get: () => text.value.content,
    set: (newContent) => {
        const oldContent = text.value.content;
        text.value.content = newContent;

        if (newContent !== oldContent) {
            debouncedSave()
        }
    }
})

const textarea = ref<HTMLTextAreaElement>();
onMounted(() => {
    if (props.focused) {
        textarea.value?.focus();
    }
});

const {copy, copied} = useClipboard()
</script>
<template>
    <div class="flex flex-col border border-neutral-300 overflow-hidden rounded-lg text-lg">
        <textarea
            ref="textarea" :placeholder="placeholder" class="px-4 py-2 border-0 resize-none text-lg"
            v-model="textContent"
        >

        </textarea>

        <button v-if="copiable" type="button" @click="()=>copy(text.content)"
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
    </div>
</template>
