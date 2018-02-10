<template>
    <div>
        <div class="forum-post__header text-left font--light" v-for="room in classes" v-bind:key="room">
            <router-link class="nav-item" :to="`/class/${room.id}`">
                <p class="content__sub-title" href="">{{room.name}}</p>
            </router-link>
            <ul>
                <li v-for="act in room.class_posts">
                    <h2>{{act.title}}</h2>
                    <p  class="posted">{{from(act.created_at)}}</p>
                    <span v-if="act.image != 'none'">
                        <img :src="'http://localhost:3000/images/' + act.image">
                    </span>
                    <p>{{act.body}}</p>
                    <p class="expire">Until: {{momentize(act.due)}}</p>
                    <hr>
                </li>
                
            </ul>
            <hr>
        </div>
    </div>
</template>
<script>
import moment from 'moment';
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
    methods:{
        momentize(date){
           return moment(date).calendar()
        },
        from(date){
           return moment(date).fromNow();  
        }
    }
}
</script>

<style lang="scss" scoped>
ul{
    padding: 0;
}
li{
    list-style: none;
    h2{
        font-size: 17px;
    }
    padding: 20px;
    img{
        width:100%;
        margin:20px 0 20px 0;
    }
    .expire{
        font-size: 14px;
    }
    .posted{
        font-size: 13px;
    }
}
</style>
