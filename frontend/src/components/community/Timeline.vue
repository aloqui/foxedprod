<template>
  <div class="timeline">

    <div class="mt-0" v-for="post in orderedUsers" :key="post.id">
      <p class="content__helper">Activity ID #{{post.id}}</p>
      <router-link class="nav-item no-decoration" :to="`/class/${post.classroom_id}`">
        <h1 class="forum__title font--semi-bold">{{post.title}}</h1>
      </router-link>
      <p class="posted content__helper">{{from(post.created_at)}}</p>
      <div v-if="post.image != 'none'">
        <img class="activity__image mt-3" :src="imagePath + post.image">
      </div>
      <p class="content__helper content__helper--negative mt-2">Instructions:</p>
      <div class="section-block mt-2">
        <p>{{post.body}}</p>
        <p class="expire content__helper">Due {{ momentize(post.due) | formatDate }}</p>
      </div>
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
        hasClass: false,
        imagePath: '',
        posts: [],
        activityOwner: []
      }
    },
    mounted() {
      this.getImagePath()
      this.$http.get('api/showTimeline')
        .then(response => {

          if (response.body.length > 0)
            this.hasClass = true;
          console.log(response.body)
          var dateNow = new Date();
          console.log(moment(dateNow).valueOf())
          response.body.forEach(res => {
            // console.log(JSON.stringify(res.class_posts))
            // this.posts = res.class_posts;
            for (var i = 0; i < res.class_posts.length; i++) {
              this.posts.push(res.class_posts[i]);
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
        return _.orderBy(this.posts, 'created_at', ['desc'])
      }
    },
    methods: {
      getImagePath() {
        this.imagePath = `${location.protocol}//${location.hostname}/images/`
        if (location.port)
          this.imagePath = `${location.protocol}//${location.hostname}:${location.port}/images/`
      },
      momentize(date) {
        return moment(date).calendar()
      },
      from(date) {
        return moment(date).fromNow();
      }
    }
  }

</script>

<style lang="scss" scoped>
  ul {
    padding: 0;
  }

  li {
    list-style: none;
    h2 {
      font-size: 17px;
    }
    padding: 20px;
    img {
      width: 100%;
      margin: 20px 0 20px 0;
    }
    .expire {
      font-size: 14px;
    }
    .posted {
      font-size: 13px;
    }
  }

</style>
