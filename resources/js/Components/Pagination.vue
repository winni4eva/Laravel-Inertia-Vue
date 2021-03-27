<template>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
        <div class="flex-1 flex justify-between sm:hidden">
            <button @click="$emit('load', prev)" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500">
                Previous
            </button>
            <button @click="$emit('load', next)" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500" >
                Next
            </button>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    <span class="font-medium">{{ from }}</span>
                    to
                    <span class="font-medium">{{ to }}</span>
                    of
                    <span class="font-medium">{{ total }}</span>
                    results
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <template v-for="link in pageLinks">
                        <button @click="$emit('load', link.url)" v-html="link.label" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700" :class="{'bg-blue-100': link.active, ' hover:bg-gray-500': !link.active}"/>
                    </template>
                </nav>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "pagination",
        props: {
            meta: Object,
            links: Object,
        },
        emits: ['load'],
        computed: {
            pageLinks() {
                return _.get(this.meta, 'links')
            },
            from() {
                return _.get(this.meta, 'from')
            },
            to() {
                return _.get(this.meta, 'to')
            },
            total() {
                return _.get(this.meta, 'total')
            },
            next() {
                return _.get(this.links, 'next')
            },
            previous() {
                return _.get(this.links, 'prev')
            },

        }
    }
</script>

<style scoped>

</style>
