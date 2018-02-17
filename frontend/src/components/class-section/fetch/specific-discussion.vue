<template>
  <div class="pt-4 specific-thread">
    <div class="container section-block ">
      <div class="row">
        <div class="col">
          <div class="content m-auto">
            <h1 class="content__helper">Specific Discussion</h1>
            <div class="mb-4 mt-4 d-flex">
              <router-link class="no-decoration" :to="`/${specificData.owner.username}/threads`">
                <div class="d-flex align-items-center ">
                  <div class="picture-placeholder mr-3">
                    <img class="picture mr-3" :src="specificData.owner.avatar_path" alt="">
                  </div>
                  <div class="d-flex flex-column">
                    <a class="m-0 content__username" href="">{{specificData.owner.name}}</a>
                    <span class="content__helper">@{{specificData.owner.username}} - {{specificData.created_at | formatDate}}</span>
                    <!-- <p5 class="mb-0 ml-1"> posted this 2 minutes ago</p> -->
                  </div>
                </div>
              </router-link>
            </div>
            <h1 class="forum__title" v-text="specificData.title"></h1>
            <p class="content__helper">{{ specificData.created_at | formatDateFormal }}</p>
            <p class="content--paragraph">{{ specificData.body }}</p>
            <replies :classDetails="classDetails"></replies>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import Replies from './replies.vue';
  export default {
    components: {
      'replies': Replies
    },
    data() {
      return {
        specificData: {},
        classDetails: {},
      }
    },
    mounted() {
      this.getData()


    },
    methods: {
      getData() {
        this.$http.get(`api/classroom/${this.$route.params.id}`)
          .then(
            data => {
              this.classDetails = data.body;
              if (data.body.isMember == true || data.body.isOwner == true) {
                this.isMember = true;
              }
              this.fetch()
            }
          );
      },
      fetch() {
        this.$http.get(`api/class/${this.$route.params.id}/${this.$route.params.discussionId}/discussions`)
          .then(this.refresh)
      },
      refresh(data) {
        console.log(data)
        this.specificData = data.body
      },

    }
  }

</script>
