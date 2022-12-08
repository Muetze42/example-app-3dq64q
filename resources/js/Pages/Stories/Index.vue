<template>
    <h1 class="sr-only">{{ __('Stories') }}</h1>
    <div class="flex flex-col space-y-4 mx-auto max-w-2xl">
        <Link class="quote" v-for="story in stories.data" :href="'/stories/'+story.id">
            <h2>{{ story.title }}</h2>
            <span class="excerpt italic">
                <font-awesome-icon icon="fa-solid fa-feather" class="fa-fw" />
                {{ __('Author') }}: {{ story.author }}
            </span>
            <span class="excerpt block">
                <font-awesome-icon icon="fa-solid fa-comment" class="fa-fw" />
                {{ story.comments }} {{ story.comments == 1 ? __('Comment') : __('Comments') }}
            </span>
        </Link>
    </div>
    <Pagination :links="stories.links" />
</template>

<script>
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
        stories: Object,
    },
}
</script>
