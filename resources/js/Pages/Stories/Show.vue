<template>
    <div class="p-4 bg-primary-800 mx-auto max-w-2xl shadow-inner shadow-primary-500/50">
        <h1 class="mb-4">{{ story.title }}</h1>
        <div v-html="story.content"/>
        <div class="excerpt italic mt-4">
            {{ __('Author') }}: {{ story.author }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        story: Object,
    },
}
</script>
