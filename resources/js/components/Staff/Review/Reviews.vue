<template>
    <div class="reviews md:max-w-4xl mx-auto">
        <div class="flex items-center gap-4 mb-2">
            <h2 class="text-xl font-medium">Total of Reviews</h2>
            <Rating />
        </div>
        <hr />
        <ReviewList class="mt-8" />
    </div>
</template>

<script>
import Rating from "../../Rating.vue";
import ReviewList from "./ReviewList.vue";
export default {
    components: { Rating, ReviewList },
};
</script>

<style></style>
