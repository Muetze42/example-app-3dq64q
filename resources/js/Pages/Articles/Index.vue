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
                                    <font-awesome-icon icon="fa-solid fa-square-xmark" class="fa-fw"/>
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
import {library} from '@fortawesome/fontawesome-svg-core'
import {
    faSquareXmark,
} from '@fortawesome/free-solid-svg-icons'
library.add(
    faSquareXmark,
);
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
