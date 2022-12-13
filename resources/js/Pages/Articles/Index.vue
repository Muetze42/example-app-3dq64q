<template>
    <h1 class="sr-only">{{ __('Articles') }}</h1>
    <div class="flex flex-col space-y-4 mx-auto max-w-2xl">
        <div v-for="article in articles.data"
             class="flex article cursor-pointer"
             @click="show(article)">
            <div class="left">
                <img :src="article.thumb" :alt="article.title">
            </div>
            <div>
                <h2>{{ article.title }}</h2>
                <div class="excerpt">
                    {{ article.excerpt }}
                </div>
            </div>
        </div>
    </div>
    <Pagination :links="articles.links" />
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="dialog" @close="open = false">
            <div class="dialog-container">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <DialogOverlay class="dialog-overlay" />
                </TransitionChild>
                <span class="dialog-fix" aria-hidden="true">&#8203;</span>
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div class="dialog-content">
                        <DialogTitle as="div" class="dialog-title">
                            <div class="grow font-semibold">
                                {{ article.title }}
                            </div>
                            <div class="text-right">
                                <button @click="open = false">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm79 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"/></svg>
                                </button>
                            </div>
                        </DialogTitle>
                        <img :src="article.image" :alt="article.title">
                        <div class="dialog-scroll">
                            <div v-html="article.content"/>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    DialogDescription,
    DialogOverlay,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'
export default {
    props: {
        articles: Object,
    },
    methods: {
        show(article) {
            this.open = true
            this.article = article
        }
    },
    data() {
        return {
            open: false,
            article: null,
        }
    },
    components: {
        Dialog,
        DialogPanel,
        DialogTitle,
        DialogDescription,
        DialogOverlay,
        TransitionChild,
        TransitionRoot,
    },
}
</script>
