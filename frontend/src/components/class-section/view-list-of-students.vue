<template>
  <div class="list-of-students">
    <div class="row">
      <div class="col">
        <p class="content__helper text-uppercase">List of Students</p>
        <hr>
        <p class="content__helper mb-3">{{ classDetails.members.length }} students enrolled.</p>
        <div class="list-of-students__student d-flex flex-column justify-content-center" v-for="member in classDetails.members" :key="member.id">
          <div class="d-flex justify-content-between align-items-center">
            <router-link :to="`/${member.user.username}/codes`" class="d-flex align-items-center ">
              <div class="picture-placeholder mr-3">
                <img class="picture" :src="member.user.avatar_path" alt="">
              </div>
              <div class="d-flex flex-column">
                <p class="font--semi-bold">{{ member.user.name }}</p>
                <p class="content__helper">@{{ member.user.username }}</p>
              </div>
            </router-link>
            <div class="d-flex">
              <p class="content__helper content__helper--negative pr-2 pl-2 hover-pointer font--semi-bold" @click.prevent="removeUser(member.user.id)">Remove</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    props: ['classDetails'],
    data() {
      return {

      }
    },
    mounted() {

    },
    methods: {
      removeUser(data) {
        this.$http.delete(`api/classroom/${this.classDetails.id}/${data}/remove`)
          .then(response => {
            swal("Successfully removed user!", {
              icon: "success",
            });
          })
          .catch(response => {
              swal("Oops!", {
              icon: "error",
            });
          })
      }
    }
  }

</script>
