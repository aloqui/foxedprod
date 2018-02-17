<template>
  <div>
    <form @submit.prevent="addDiscussion">
      <div class="d-flex flex-column">
        <div>
          <p class="content__helper">Title</p>
          <input type="text" v-model="discussionData.title" class="form-control">
        </div>
        <div>
          <p class="content__helper">Body</p>
          <input type="text" v-model="discussionData.body" class="form-control">
        </div>
        <div class="form-group mt-5">
          <vue-recaptcha ref="recaptcha" @verify="onVerify" :sitekey="'6LdNMUQUAAAAANCzAoEF4rLP5xK4zOk-nsneku70'"></vue-recaptcha>
        </div>
        <div class="col-12 mt-2">
          <input type="submit" class="btn content__button--passive content__helper pull-right m-0" data-toggle="modal" data-target="#createDiscussion"
            value="Post Activity">
        </div>
      </div>
    </form>
  </div>
</template>
<script>
  import VueRecaptcha from 'vue-recaptcha'
  export default {
    components: {
      VueRecaptcha
    },
    props: ['classDetails'],
    data() {
      return {
        discussionData: {}
      }
    },
    mounted() {

    },
    methods: {
      onVerify(response) {
        this.discussionData.recaptcha = response
      },
      addDiscussion() {
        this.$http.post(`api/classroom/discussion/${this.classDetails.id}`, this.discussionData)
        
      }
    }
  }

</script>
