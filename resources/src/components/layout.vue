<template>
<main>
    <header v-if="hasHeader">
        <nav-bar />
    </header>
    <slot />

    <footer v-if="hasFooter">
        <hr>
        <div class="container">
            <p class="text-muted text-center small">{{ footer }}</p>
        </div>
    </footer>
</main>
</template>

<script lang="ts">
import { computed, defineComponent, watch } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { useLanguage } from '../utils/language';
import NavBar from './nav-bar.vue';

export default defineComponent({
    props: {
        hasHeader: {
            type: Boolean,
            default: true,
        },

        hasFooter: {
            type: Boolean,
            default: true,
        },
    },

    components: {
        NavBar,
    },

    setup() {
        const title = computed(() => usePage().props.value.title ?? useLanguage().value('title'));
        const footer = computed(() => useLanguage().value('footer'));
        const locale = computed(() => usePage().props.value.locale);

        watch(title, (title) => {
            document.title = title;
        });

        watch(locale, (locale) => {
            document.documentElement.lang = locale;
        });

        return {
            footer,
        };
    },
});
</script>
