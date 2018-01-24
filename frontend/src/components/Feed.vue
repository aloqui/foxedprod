<template>
    <div>
        <h1>Main view</h1>
        <forums-view></forums-view>
    </div>
</template>
<script>
    import Forum from '../views/forums.vue'
    export default {
        components :{
            'forums-view' : Forum
        }
    }
</script>