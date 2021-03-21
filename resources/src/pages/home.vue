<template>
<layout>
    <div class="container">
        <div class="row">
            <div class="col-sm-8" v-html="compiledLetter" />
            <aside class="col-sm-4">
                <sign-form :sign-number="signNumber" :campaign-ended="campaignEnded" />
            </aside>
        </div>
    </div>
    <portfolio v-if="portfolio?.length" :portfolio="portfolio" />
    <post-list :posts="posts" />
    <campaign-ended :announcement="announcement" v-if="campaignEnded && announcement" />
</layout>
</template>

<script lang="ts">
import { computed, defineComponent, PropType } from 'vue';
import marked from 'marked';
import Layout from '../components/layout.vue';
import Portfolio from '../components/portfolio.vue';
import SignForm from '../components/sign-form.vue';
import PostList from '../components/post-list.vue';
import CampaignEnded from '../components/campaign-ended.vue';
import { Post } from '../utils/interface';

export default defineComponent({
    components: {
        Layout,
        Portfolio,
        SignForm,
        PostList,
        CampaignEnded,
    },
    props: {
        letter: String,
        announcement: String,
        posts: Array as PropType<Post[]>,
        portfolio: Array as PropType<string[]>,
        signNumber: Number,
        campaignEnded: Boolean,
    },

    setup(props) {
        const compiledLetter = computed(() => props.letter && marked(props.letter));

        return {
            compiledLetter,
        };
    },
});
</script>
