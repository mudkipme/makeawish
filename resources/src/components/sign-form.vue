<template>
<div class="card">
    <div class="card-header">
        <h5 class="card-title">{{ t('form.sign') }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ t('form.total', { number: signNumber?.toLocaleString() }) }}</h6>
    </div>
    <div class="card-body">
        <form @submit.prevent="submit">
            <div class="alert alert-warning" v-if="errors && Object.keys(errors).length > 0">
                <p v-for="(msg) in errors">{{ msg }}</p>
            </div>
            <div class="alert alert-success" v-if="success">
                {{ t('success') }}
            </div>
            <div class="mb-3">
                <label for="sign-name" class="form-label">{{ t('form.name') }}</label>
                <input type="text" class="form-control" id="sign-name" :placeholder="t('form.name-placeholder')" v-model="form.name" required :disabled="campaignEnded || success" />
            </div>
            <div class="mb-3">
                <label for="sign-email" class="form-label">{{ t('form.email') }}</label>
                <input type="email" class="form-control" id="sign-email" :placeholder="t('form.email-placeholder')" v-model="form.email" required :disabled="campaignEnded || success" />
            </div>
            <div class="mb-3">
                <label for="sign-message" class="form-label">{{ t('form.message') }}</label>
                <textarea class="form-control" id="sign-message" :rows="3" v-model="form.message" :placeholder="t('message-placeholder')" :disabled="campaignEnded || success"></textarea>
            </div>
            <div class="mb-3">
                <label for="sign-upload" class="form-label">{{ t('form.upload') }}</label>
                <input type="file" name="upload" class="form-control" id="sign-upload" @change="uploadChange" accept="image/*" :disabled="campaignEnded || success" />
            </div>
            <div class="mb-3 form-check">
                <input class="form-check-input" type="checkbox" v-model="form.public" id="sign-public" :disabled="campaignEnded || success" />
                <label class="form-check-label" for="sign-public">{{ t('form.public') }}</label>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-primary btn-lg" type="submit" :disabled="campaignEnded || success">{{ campaignEnded ? t('form.submit-end') : t('form.submit') }}</button>
            </div>
        </form>
    </div>
</div>
</template>

<script lang="ts">
import { computed, defineComponent, ref, UnwrapRef } from 'vue';
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import { useLanguage } from '../utils/language';

export default defineComponent({
    props: {
        signNumber: Number,
        campaignEnded: Boolean,
    },

    setup(props) {
        const t = useLanguage();
        const errors = computed(() => usePage().props.value.errors);
        const success = ref(false);

        const formInstance = useForm({
            name: '',
            email: '',
            message: '',
            upload: null as File | null | undefined,
            public: false,
        });
        const form = formInstance as unknown as UnwrapRef<typeof formInstance>;

        const uploadChange = (e: Event) => {
            form.upload = (e.target as HTMLInputElement).files?.[0];
        };

        const submit = () => {
            if (props.campaignEnded) {
                return;
            }
            form.post('/posts', {
                preserveScroll: true,
                onSuccess() {
                    success.value = true;
                },
            });
        }

        return {
            t,
            form,
            uploadChange,
            submit,
            errors,
            success,
        };
    },
});
</script>
