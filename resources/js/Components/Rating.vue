<template>
    <div v-show="!hide" @mouseover="active = true" >
        <i
            v-for="star in Math.trunc(stars)"
            class="fa fa-star text-yellow-500"
            :class="{'text-blue-300': userRating}"
            v-bind:key="star"
        />
        <i
            v-if="halfStar"
            class="fa fa-star-half text-yellow-500"
        />
        <i
            v-for="star in maxRating - Math.trunc(stars) - (halfStar ? 1 : 0)"
            class="fa fa-star text-gray-200"
            v-bind:key="star"
        />
    </div>
    <div @mouseleave="active = false" class="cursor-pointer">
        <i
            v-for="star in maxRating"
            v-show="hide"
            class="fa fa-star text-gray-200"
            :class="{'text-blue-300': star <= selected}"
            @mouseover="selected = star"
            @click="$emit('storeRating', star)"
            v-bind:key="star"
        />
    </div>

</template>

<script>
    export default {
        name: "Rating",
        props: {
            rating: Number,
            userRating: Number,
            maxRating: Number,
            canRate: Boolean
        },
        data() {
            return {
                active: false,
                selected: null
            }
        },
        computed: {
            hide() {
                return this.active && this.userRating == null && this.canRate
            },
            stars() {
                if(this.userRating) {
                    return this.userRating
                }
                if(this.rating) {
                    return this.rating
                }
                return 0;
            },
            halfStar() {
                return this.stars >= Math.trunc(this.stars) + .5
            }
        },

    }
</script>

<style scoped>

</style>
