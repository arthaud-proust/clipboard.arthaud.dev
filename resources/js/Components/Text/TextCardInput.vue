<script setup lang="ts">
import {TextDto} from "@/types/generated";
import {useDebounceFn} from "@vueuse/core";
import {computed, onMounted, ref} from "vue";

const props = withDefaults(
    defineProps<{
        text?: TextDto | Omit<TextDto, 'id'>
        focused?: boolean
        placeholder?: string
    }>(),
    {
        text: () => ({
            id: undefined,
            content: ''
        })
    }
)

const emit = defineEmits<{
    save: [TextDto | Omit<TextDto, 'id'>]
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
</script>
<template>
    <textarea ref="textarea" :placeholder="placeholder" class="border-neutral-300 rounded-xl resize-none text-lg" v-model="textContent"></textarea>
</template>
