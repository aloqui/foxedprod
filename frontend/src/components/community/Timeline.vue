<template>
    <div>
        <div class="forum-post__header text-left font--light" v-for="room in classes" v-bind:key="room">
            <router-link class="nav-item" :to="`/class/${room.id}`">
                <a class="content__sub-title" href="">{{room.name}}</a>
            </router-link>
            <ul>
                <li v-for="act in room.class_posts">
                    <h2>{{act.title}}</h2>
                    <span v-if="act.image != 'none'">
                        <img :src="'http://localhost:8000/' + act.image">
                    </span>
                    <p>{{act.body}}</p>
                </li>
                
            </ul>
            <hr>
        </div>
    </div>
</template>
<script>
export default {    
        data() {
        return {
            classes: {},
            hasClass: false
        }
    },
        mounted() {
            this.$http.get('api/showTimeline')
            .then(response => {
            this.classes = response.body
            if(response.body.length > 0)
                this.hasClass = true;
            console.log(response.body)
        })
    },
}
</script>

<style lang="scss" scoped>
li{
    padding: 20px;
    img{
        width: 200px;
    }
}
</style>
