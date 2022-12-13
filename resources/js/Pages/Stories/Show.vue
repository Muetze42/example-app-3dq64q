<template>
    <div class="p-4 bg-primary-800 mx-auto max-w-2xl shadow-inner shadow-primary-500/50">
        <h1 class="mb-4">{{ story.title }}</h1>
        <div v-html="story.content"/>
        <div class="excerpt italic mt-4">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M278.5 215.6L23 471c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l57-57h68c49.7 0 97.9-14.4 139-41c11.1-7.2 5.5-23-7.8-23c-5.1 0-9.2-4.1-9.2-9.2c0-4.1 2.7-7.6 6.5-8.8l81-24.3c2.5-.8 4.8-2.1 6.7-4l22.4-22.4c10.1-10.1 2.9-27.3-11.3-27.3l-32.2 0c-5.1 0-9.2-4.1-9.2-9.2c0-4.1 2.7-7.6 6.5-8.8l112-33.6c4-1.2 7.4-3.9 9.3-7.7C506.4 207.6 512 184.1 512 160c0-41-16.3-80.3-45.3-109.3l-5.5-5.5C432.3 16.3 393 0 352 0s-80.3 16.3-109.3 45.3L139 149C91 197 64 262.1 64 330v55.3L253.6 195.8c6.2-6.2 16.4-6.2 22.6 0c5.4 5.4 6.1 13.6 2.2 19.8z"/></svg>
            {{ __('Author') }}: {{ story.author }}
        </div>
    </div>
    <div class="comments" ref="comments" id="comments">
        <h2>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M512 240c0 114.9-114.6 208-256 208c-37.1 0-72.3-6.4-104.1-17.9c-11.9 8.7-31.3 20.6-54.3 30.6C73.6 471.1 44.7 480 16 480c-6.5 0-12.3-3.9-14.8-9.9c-2.5-6-1.1-12.8 3.4-17.4l0 0 0 0 0 0 0 0 .3-.3c.3-.3 .7-.7 1.3-1.4c1.1-1.2 2.8-3.1 4.9-5.7c4.1-5 9.6-12.4 15.2-21.6c10-16.6 19.5-38.4 21.4-62.9C17.7 326.8 0 285.1 0 240C0 125.1 114.6 32 256 32s256 93.1 256 208z"/></svg>
            {{ __('Comments') }}
        </h2>
        <div v-if="comments.data.length" class="flex flex-col space-y-2">
            <div class="comment" v-for="comment in comments.data">
                <h3 class="italic text-primary-400">
                    <img :src="comment.avatar" v-if="comment.avatar" :alt="comment.author" class="rounded-full h-5 w-5 inline-block mb-1">
                    {{ comment.title }}:
                </h3>
                <div v-html="comment.content" />
            </div>
        </div>
        <div class="text-center text-lg" v-else>
            {{ __('No comments available yet') }}
        </div>
        <Pagination :links="comments.links" />
        <form v-if="authorizedToAddComment" @submit.prevent="submit" class="mt-2">
            <label for="content" class="block">{{ __('Write comment') }}</label>
            <textarea :maxlength="commentMaxLength" id="content" v-model="form.content" class="form-textarea w-full text-black p-1 rounded" required />
            <div v-if="errors.content" class="error mb-2">{{ errors.content }}</div>
            <button type="submit" class="btn">{{__('Save comment') }}</button>
        </form>
    </div>
</template>

<script>
import { useForm } from '@inertiajs/inertia-vue3'

export default {
    props: {
        story: Object,
        comments: Object,
        authorizedToAddComment: Boolean,
        commentMaxLength: Number,
        errors: Object,
    },
    data() {
        return {
            commented: false,
        }
    },
    setup () {
        const form = useForm({
            content: null
        })

        return { form }
    },
    methods: {
        submit() {
            this.form.post(this.story.id+'/add-comment', {
                preserveScroll: true,
                onSuccess: () => {
                    this.commented = true
                    this.form.reset()
                    this.$inertia.visit(this.story.id,
                        {
                            preserveScroll: true,
                            onFinish: () => {
                                const comments = this.$refs.comments;
                                comments.scrollIntoView({behavior: 'smooth'});
                            }
                        })
                }
            })
        },
    },
}
</script>
