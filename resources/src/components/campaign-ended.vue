<template>
<div class="modal fade" tabindex="-1" aria-hidden="true" ref="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ t('thanks-title') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" v-html="compiledAnnouncement" />
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ t('thanks-close') }}</button>
            </div>
        </div>
    </div>
</div>
</template>

<script lang="ts">
import { computed, defineComponent, onMounted, ref, watch } from 'vue';
import { Modal } from 'bootstrap';
import marked from 'marked';
import { useLanguage } from '../utils/language';

export default defineComponent({
    props: {
        announcement: String,
    },

    setup(props) {
        const t = useLanguage();
        const modal = ref<Element>();
        const bsModal = ref<Modal>();
        const compiledAnnouncement = computed(() => props.announcement && marked(props.announcement));

        onMounted(() => {
            if (modal.value) {
                const instance = new Modal(modal.value);
                instance.show();
                bsModal.value = instance;
            }
        });

        watch(compiledAnnouncement, () => {
            bsModal.value?.show();
        });

        return {
            t,
            modal,
            compiledAnnouncement,
        };
    },
});
</script>
