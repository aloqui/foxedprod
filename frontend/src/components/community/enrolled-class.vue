<template>
  <div class="enrolled-class">
    <div v-if="user.prof == 0">
      <join-class></join-class>
    </div>
    <div v-else>
      <create-class @enroll="enroll"></create-class>
    </div>
    <p class="text-left font--bold text-uppercase mt-3">Classes</p>
      
    <div v-if="true">
      <div class="forum-post__header text-left font--light" v-for="room in classes" v-bind:key="room.id">
        <router-link class="nav-item content__sub-title" :to="`/class/${room.id}`">
          <li>
            {{room.name}}
          </li>
        </router-link>
      </div>
    </div>
    <div v-else>
      <p class="content__helper">You have 0 enrolled class.</p>
    </div>
  </div>
</template>
<script>
  //import Thread from '../models/thread';
  import JoinClass from './join-class.vue';
  import CreateClass from './create-class.vue';
  export default {
    name: 'classroom',
    components: {
      'join-class': JoinClass,
      'create-class': CreateClass
    },
    props: ['user'],
    data() {
      return {
        classes: {},
        hasClass: false
      }
    },
    mounted() {
      this.fetch()
    },
    methods: {
      fetch() {
        this.$http.get('api/enrolledClass')
          .then(this.refresh)
      },
      refresh(data) {
        this.classes = data.body
        if (data.body.length > 0)
          this.hasClass = true;
        console.log("res:")
        console.log(data.body)
      },
      enroll(data) {
        console.log(data)
        this.classes.push(data)
      }
      // init() {
      //   console.log(this.$route); //should return object
      //   console.log(this.$route.params); //should return object 
      //   console.log(this.$route.params.id); //should return id of URL param 
      // }
    }
  }

</script>

<style lang="scss">
  .picture-placeholder {}

  .feed-block {

    width: 100%;
    .feed-block-inner {
      //border: 1px solid #000;
      .feed-block-inner__header {}
      .feed-block-inner__post {
        img {
          width: 40px;
        }
      }
    }
  }

</style>
 