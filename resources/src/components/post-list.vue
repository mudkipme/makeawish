<template>
<div class="container mb-5" ref="container">
    <hr />
    <h3>{{ t('post') }}</h3>
    <div class="row" ref="row">
        <post-card v-for="post in posts" :post="post" />
    </div>
    <div class="d-grid gap-2">
        <button class="btn btn-success btn-lg" type="button" @click="refresh">{{ t('more-post') }}</button>
    </div>
</div>
</template>

<script lang="ts">
import { defineComponent, nextTick, onMounted, PropType, ref, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Masonry from 'masonry-layout';
import imageloaded from 'imagesloaded';
import { useLanguage } from '../utils/language';
import { Post } from '../utils/interface';
import PostCard from './post-card.vue';

export default defineComponent({
    props: {
        posts: Array as PropType<Post[]>,
    },

    components: {
        PostCard,
    },

    setup(props) {
        const t = useLanguage();
        const row = ref<Element>();
        const masonry = ref<Masonry>();
        const container = ref<Element>();

        onMounted(() => {
            if (row.value) {
                masonry.value = new Masonry(row.value);
            }
        });

        watch(() => props.posts, () => {
            nextTick(() => {
                row.value && imageloaded(row.value, () => {
                    masonry.value?.layout?.();
                });
            });
        });

        const refresh = () => {
            Inertia.reload({ only: ['posts'] });
            container.value?.scrollIntoView();
        };

        return {
            t,
            row,
            refresh,
            container,
        };
    },
});
</script>
