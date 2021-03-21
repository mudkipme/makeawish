<template>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
    <div class="container">
        <span class="navbar-brand">Project Make-A-Wish</span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="me-auto">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item" v-if="user">
                        <inertia-link :class="{ 'nav-link': true, active: page === 'admin' }" :href="`/admin`" preserve-state>Admin</inertia-link>
                    </li>
                    <li class="nav-item" v-if="user">
                        <inertia-link method="POST" :class="{ 'nav-link': true }" :href="`/logout`" preserve-state>Logout</inertia-link>
                    </li>
                </ul>
            </div>
            <div class="d-flex">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item" v-for="(text, item) in availableLocales">
                        <inertia-link :class="{ 'nav-link': true, active: page === 'home' && locale === item }" :href="`/${item}`" preserve-state>{{ text }}</inertia-link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
</template>

<script lang="ts">
import { defineComponent, computed } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

export default defineComponent({
    setup() {
        const locale = computed(() => usePage().props.value.locale);
        const availableLocales = computed(() => usePage().props.value.availableLocales);
        const user = computed(() => usePage().props.value.user);
        const page = usePage().component;

        return {
            availableLocales,
            locale,
            user,
            page,
        };
    },
});
</script>
