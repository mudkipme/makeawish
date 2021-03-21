<template>
<layout>
    <div class="container mb-5">
        <div class="row" ref="row">
            <post-card v-for="post in posts" :post="post" :admin="true" />
        </div>
        <nav>
            <ul class="pagination flex-wrap">
                <li :class="{ 'page-item': true, disabled: page <= 1 }">
                    <inertia-link class="page-link" :href="`/admin?page=${page - 1}`">Previous</inertia-link>
                </li>
                <li v-for="i in totalPage" :class="{ 'page-item': true, active: page === i }">
                    <inertia-link class="page-link" :href="`/admin?page=${i}`">{{ i }}</inertia-link>
                </li>
                <li :class="{ 'page-item': true, disabled: page === totalPage }">
                    <inertia-link class="page-link" :href="`/admin?page=${page + 1}`">Next</inertia-link>
                </li>
            </ul>
        </nav>
    </div>
</layout>
</template>

<script lang="ts">
import { computed, defineComponent, nextTick, onMounted, PropType, ref, watch } from 'vue';
import Masonry from 'masonry-layout';
import imageloaded from 'imagesloaded';
import Layout from '../components/layout.vue';
import PostCard from '../components/post-card.vue';
import { Post } from '../utils/interface';

export default defineComponent({
    components: {
        Layout,
        PostCard,
    },
    props: {
        posts: Array as PropType<Post[]>,
        page: {
            type: Number,
            default: 1,
        },
        total: {
            type: Number,
            default: 0,
        },
    },

    setup(props) {
        const row = ref();
        const masonry = ref();

        onMounted(() => {
            masonry.value = new Masonry(row.value);
        });

        watch(() => props.posts, () => {
            nextTick(() => {
                imageloaded(row.value, () => {
                    masonry.value.layout();
                });
            });
        });

        return {
            row,
            totalPage: computed(() => Math.ceil(props.total / 30)),
        };
    },
});
</script>
