<template>
<layout :has-header="false" :has-footer="false">
    <div class="form-signin d-flex align-items-center text-center justify-content-center">
        <form class="w-100 p-3" @submit.prevent="submit">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="alert alert-warning" v-if="errors?.login">{{ errors.login }}</div>

            <div class="form-floating">
                <input type="text" class="form-control" id="login-name" placeholder="Name" v-model="form.name" required>
                <label for="login-name">Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="login-password" placeholder="Password" v-model="form.password" required>
                <label for="login-password">Password</label>
            </div>

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="on" v-model="form.remember"> Remember me
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        </form>
    </div>
</layout>
</template>

<script lang="ts">
import { computed, defineComponent, UnwrapRef } from 'vue';
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import Layout from '../components/layout.vue';

export default defineComponent({
    components: {
        Layout,
    },

    setup() {
        const errors = computed(() => usePage().props.value.errors);
        const formInstance = useForm({
            name: null,
            password: null,
            remember: null,
        });
        const form = formInstance as unknown as UnwrapRef<typeof formInstance>;

        const submit = () => {
            form.transform((data) => ({
                ...data,
                remember: data.remember ? 'on' : '',
            })).post('/login');
        }

        return {
            form,
            submit,
            errors,
        };
    }
});
</script>

<style scoped>
.form-signin {
    height: 100vh;
    background-color: #f5f5f5;
}

.form-signin form {
    max-width: 330px;
}

.form-signin .form-floating:focus-within {
  z-index: 2;
}

.form-signin input[type="text"] {
    margin-bottom: -1px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
}

.form-signin input[type="password"] {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
</style>
