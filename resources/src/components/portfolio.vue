<template>
<div class="container">
    <hr />
    <h3>{{ t('portfolio') }}</h3>
    <div class="row" ref="row">
        <div class="col-xs-12 col-sm-6 col-md-4 mb-3" v-for="item in portfolio">
            <img :src="item" alt="" class="img-fluid rounded">
        </div>
    </div>
</div>
</template>

<script lang="ts">
import { defineComponent, onMounted, PropType, ref, watch } from 'vue';
import Masonry from 'masonry-layout';
import imageloaded from 'imagesloaded';
import { useLanguage } from '../utils/language';

export default defineComponent({
    props: {
        portfolio: Array as PropType<string[]>,
    },

    setup(props) {
        const t = useLanguage();
        const row = ref<Element>();
        const masonry = ref<Masonry>();

        onMounted(() => {
            row.value && imageloaded(row.value, () => {
                masonry.value = row.value && new Masonry(row.value);
            });
        });

        watch(() => props.portfolio, () => {
            row.value && imageloaded(row.value, () => {
                masonry.value?.layout?.();
            });
        });

        return {
            t,
            row,
        };
    },
});
</script>
