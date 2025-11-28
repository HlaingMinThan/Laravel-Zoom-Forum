<template>
    <h1 class="text-3xl font-bold" v-for="question in questions" :key="question.id">{{ question.title }} - {{ question.user.name }}</h1>
</template>

<script>
export default {
    props: {
        questions: {
            type : Array
        }
    }
}
</script>

<style>

</style>