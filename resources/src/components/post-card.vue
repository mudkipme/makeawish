<template>
<div class="col-xs-12 col-sm-4 col-lg-3 mb-3">
    <div class="card">
        <img class="card-img-top" v-if="post?.upload_filename" :src="`${post.upload_filename}`" alt="" :width="post.upload_width" :height="post.upload_height" />
        <div class="card-body" v-if="post?.message">
            <p class="card-text">{{ post.message }}</p>
        </div>
        <div class="card-footer d-flex text-muted">
            <div class="post-author me-auto">
                -- <em>{{ post?.name }}</em>
            </div>
            <div :class="{'post-like': true, 'post-liked': post?.liked, 'text-nowrap': true}" @click="like" v-if="!admin">
                <i class="bi-heart-fill me-1"></i>
                <span class="num">{{ post?.like_num || '' }}</span>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between" v-if="admin">
            <button class="btn btn-success" @click="approval">Approval</button>
            <button class="btn btn-warning" @click="hide">Hide</button>
        </div>
    </div>
</div>
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue';
import axios from 'axios';
import { Post } from '../utils/interface';
import { Inertia } from '@inertiajs/inertia';

export default defineComponent({
    props: {
        post: Object as PropType<Post>,
        admin: {
            type: Boolean,
            default: false,
        },
    },

    setup(props) {
        async function like() {
            if (!props.post) {
                return;
            }
            const response = await axios.post<Post>(`/posts/${props.post.id}/like`);
            props.post.like_num = response.data.like_num;
            props.post.liked = response.data.liked;
        }

        async function approval() {
            if (!props.post) {
                return;
            }
            await axios.post<Post>(`/admin/posts/${props.post.id}/approval`);
            await Inertia.reload({ preserveScroll: true });
        }

        async function hide() {
            if (!props.post) {
                return;
            }
            await axios.post<Post>(`/admin/posts/${props.post.id}/hide`);
            await Inertia.reload({ preserveScroll: true });
        }

        return {
            like,
            approval,
            hide,
        };
    },
});
</script>

<style scoped>
.post-like {
    color: #c31a1e;
    opacity: .5;
}

.post-like:not(.post-liked) {
    cursor: pointer;
}

.post-like:not(.post-liked):hover {
    opacity: 1;
}

.card-img-top {
    width: auto;
    height: auto;
    max-width: 100%;
}
</style>
