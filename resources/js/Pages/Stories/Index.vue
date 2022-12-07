<template>
    <h1 class="sr-only">{{ __('Stories') }}</h1>
    <div class="flex flex-col space-y-4 mx-auto max-w-2xl">
        <Link class="quote" v-for="story in stories.data" :href="'/stories/'+story.id">
            <h2>{{ story.title }}</h2>
            <span class="excerpt italic">
                {{ __('Author') }}: {{ story.author }}
            </span>
        </Link>
    </div>
    <Pagination :links="stories.links" />
</template>

<script>
export default {
    props: {
        stories: Object,
    },
}
</script>
