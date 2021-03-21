import { computed } from 'vue';
import get from 'lodash/get';
import { usePage } from '@inertiajs/inertia-vue3';

export const useLanguage = () => {
    return computed(() => {
        const language = usePage().props.value.language;
        return (key: string, replace?: Record<string, string | undefined>) => {
            let translation = (get(language, key) ?? '') as string;
            if (!replace) {
                return translation;
            }

            for (const [key, value] of Object.entries(replace)) {
                translation = translation.split(`:${key}`).join(value ?? '');
            }
            return translation;
        };
    });
}
