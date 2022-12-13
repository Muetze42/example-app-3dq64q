<template>
    <header class="flex p-2">
        <div>
            <Link href="/" :class="{ 'active': $page.url === '/' }" class="mr-2">
                {{ __('Articles') }}
            </Link>
            <Link href="/stories" :class="{ 'active': $page.url === '/stories' }">
                {{ __('Stories') }}
            </Link>
        </div>
        <Menu as="div" class="menu">
            <MenuButton class="btn" v-if="user">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0S96 57.3 96 128s57.3 128 128 128zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
                {{ user.name }}
            </MenuButton>
            <MenuButton class="btn" v-else>
                {{ __('Login') }}
            </MenuButton>
            <transition
                enter-active-class="transition duration-100 ease-out"
                enter-from-class="transform scale-95 opacity-0"
                enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-75 ease-in"
                leave-from-class="transform scale-100 opacity-100"
                leave-to-class="transform scale-95 opacity-0">
                <MenuItems class="menu-items" v-if="user" ref="userMenu">
                    <MenuItem class="menu-item" v-if="user.backend">
                        <a  href="/admin">{{ __('Administration') }}</a>
                    </MenuItem>
                    <MenuItem class="menu-item">
                        <button @click="logout" type="submit">
                            {{ __('Logout') }}
                        </button>
                    </MenuItem>
                </MenuItems>
                <MenuItems class="menu-items" v-else>
                    <div class="menu-item-p">
                        <MenuItem class="menu-item" :disabled="true" @keydown="stopPropagation">
                            <form @submit.prevent="login" class="form-top">
                                <div class="form-row">
                                    <label for="email">{{ __('Email Address') }}</label>
                                    <input id="email" class="form-input" v-model="form.email" type="email" :placeholder="__('Email Address')" required/>
                                    <div v-if="form.errors.email" class="danger">{{ form.errors.email }}</div>
                                </div>
                                <div class="form-row">
                                    <label for="password">{{ __('Password') }}</label>
                                    <input id="password" class="form-input" v-model="form.password" type="password" :placeholder="__('Password')" required/>
                                </div>
                                <div class="form-row">
                                    <input type="checkbox" class="form-checkbox mr-0.5" id="remember" v-model="form.remember">
                                    <label for="remember">{{ __('Remember me') }}</label>
                                </div>
                                <div class="form-row">
                                    <button type="submit" class="btn" id="login-btn">{{ __('Log In') }}</button>
                                </div>
                            </form>
                        </MenuItem>
                    </div>
                </MenuItems>
            </transition>
        </Menu>
    </header>
    <main>
        <slot/>
    </main>
</template>

<script>
import {
    Menu,
    MenuButton,
    MenuItems,
    MenuItem,
    TransitionRoot,
    TransitionChild,
} from '@headlessui/vue'
import { computed } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'

export default {
    name: "Layout",
    components: {
        Menu,
        MenuButton,
        MenuItems,
        MenuItem,
        TransitionRoot,
        TransitionChild,
    },
    setup() {
        const user = computed(() => usePage().props.value.auth.user)
        return { user }
    },
    data() {
        return {
            form: this.$inertia.form({
                email: '',
                password: '',
                remember: false,
            }),
        }
    },
    methods: {
        logout() {
            if (confirm(this.__('Are you sure you want to log out?'))) {
                this.$inertia.post('/logout')
            }
        },
        login() {
            this.form.post('/login', {
                preserveScroll: true,
                preserveState: (page) => Object.keys(page.props.errors).length,
            })
            this.form.reset('password')
        },
        stopPropagation(e) {
            e.stopPropagation();
        },
    }
}
</script>
