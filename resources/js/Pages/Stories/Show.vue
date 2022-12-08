<template>
    <div class="p-4 bg-primary-800 mx-auto max-w-2xl shadow-inner shadow-primary-500/50">
        <h1 class="mb-4">{{ story.title }}</h1>
        <div v-html="story.content"/>
        <div class="excerpt italic mt-4">
            <font-awesome-icon icon="fa-solid fa-feather" class="fa-fw" />
            {{ __('Author') }}: {{ story.author }}
        </div>
    </div>
    <div class="comments" ref="comments" id="comments">
        <h2>
            <font-awesome-icon icon="fa-solid fa-comment" class="fa-fw" />
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
import {library} from '@fortawesome/fontawesome-svg-core'
import {
    faComment,
    faFeather,
} from '@fortawesome/free-solid-svg-icons'
library.add(
    faComment,
    faFeather,
);

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
