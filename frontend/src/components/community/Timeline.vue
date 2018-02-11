<template>
    <div>
        <div class="forum-post__header text-left font--light">
        <ul>
                <li v-for="post in orderedUsers">
                    <router-link class="nav-item no-decoration" :to="`/class/${post.classroom_id}`">
                    <h1 class="forum__title font--semi-bold">{{post.title}}</h1>
                    </router-link>
                        
                    <p  class="posted">{{from(post.created_at)}}</p>
                    <span v-if="post.image != 'none'">
                        <img :src="imagePath + post.image">
                    </span>
                    <p>{{post.body}}</p>
                    <p class="expire">Until: {{momentize(post.due)}}</p>
                    <hr>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
import moment from 'moment';
export default {
        data() {
        return {
            classes: {},
            hasClass: false,
            imagePath: '',
            posts:[]
        }
    },
        mounted() {
            this.getImagePath()
            this.$http.get('api/showTimeline')
            .then(response => { 
            this.classes = response.body
            if(response.body.length > 0)
                this.hasClass = true;
            console.log("response")

            var dateNow = new Date();
            console.log(moment(dateNow).valueOf())
            response.body.forEach( res => {
                // console.log(JSON.stringify(res.class_posts))
                // this.posts = res.class_posts;
                for (var i=0; i < res.class_posts.length; i++) {
                        this.posts.push( res.class_posts[i] );
                        console.log(moment(res.class_posts[i].created_at).valueOf())
                    }
                console.log(this.posts)
                
                })

                // this.posts.sort( ( a, b) => {
                //     this.posts = moment(a.created_at).valueOf() - moment(b.created_at).valueOf();
                // });


        })
    },
    computed: {
            orderedUsers: function () {
                return _.orderBy(this.posts, 'created_at',['desc'])
            }
        },
    methods:{
        getImagePath() {
        this.imagePath = `${location.protocol}//${location.hostname}/images/`
        if (location.port)
          this.imagePath = `${location.protocol}//${location.hostname}:${location.port}/images/`
      },
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
