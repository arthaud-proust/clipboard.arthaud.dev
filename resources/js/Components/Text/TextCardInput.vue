<script setup lang="ts">
import { TextDto } from '@/types/generated';
import {
    ClipboardDocumentCheckIcon,
    ClipboardIcon,
} from '@heroicons/vue/24/outline';
import { useClipboard, useDebounceFn } from '@vueuse/core';
import { computed, onMounted, ref } from 'vue';
import { useI18n } from 'vue-i18n';

const props = withDefaults(
    defineProps<{
        text?: TextDto | Omit<TextDto, 'id' | 'updatedAt' | 'createdAt'>;
        focused?: boolean;
        placeholder?: string;
        copiable?: boolean;
    }>(),
    {
        text: () => ({
            content: '',
        }),
    },
);

const emit = defineEmits<{
    save: [typeof props.text];
}>();

const { t } = useI18n();

const text = ref(props.text);

const debouncedSave = useDebounceFn(() => {
    emit('save', text.value);
}, 1_000);

const textContent = computed({
    get: () => text.value.content,
    set: (newContent) => {
        const oldContent = text.value.content;
        text.value.content = newContent;

        if (newContent !== oldContent) {
            debouncedSave();
        }
    },
});

const textarea = ref<HTMLTextAreaElement>();
onMounted(() => {
    if (props.focused) {
        textarea.value?.focus();
    }
});

const { copy, copied } = useClipboard();
</script>
<template>
    <div
        class="flex flex-col overflow-hidden rounded-lg border border-neutral-300 text-lg"
    >
        <textarea
            ref="textarea"
            :placeholder="placeholder"
            class="resize-none border-0 px-4 py-2 text-lg"
            v-model="textContent"
        >
        </textarea>

        <button
            v-if="copiable"
            type="button"
            @click="() => copy(text.content)"
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
    </div>
</template>
