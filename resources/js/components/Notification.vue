<template>
    <div v-show="data.show" :class="`alert ${data.class} my-2`">
       {{ data.message }}
    </div>
</template>

<script setup>
    import { onMounted, reactive } from 'vue';

    const data = reactive({
        message: '',
        class: '',
        show: false
    });

    onMounted(() => {
        Echo.private('notifications')
            .listen('LoginoutEvent', (event) => {
                data.message = event.message;
                data.class = event.class;
                data.show = true;
            });
    });

</script>

<style>
</style>