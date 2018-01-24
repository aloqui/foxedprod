<template>
  <div class="join-class">
    <b-btn class="form__button--register-dark pl-2 pr-2" v-b-modal.modalPrevent>Join A Class</b-btn>
    <!-- Main UI -->
    <!-- Modal Component -->
    <b-modal id="modalPrevent" ref="modal" title="Enter class code" @ok="subscribe">
      <form @submit.stop.prevent="subscribe">
        <b-form-input type="number" placeholder="#" v-model="classCode"></b-form-input>
      </form>
    </b-modal>
  </div>
</template>

<script>
  export default {
    name: 'join-class',
    data() {
      return {
        modalShow: false,
        classCode: ''
      }
    },
    methods: {
      subscribe() {
        this.$http.post(`api/classroom/${this.classCode}/join`)
          .then(response => {
            swal("Success!", {
              icon: "success",
            });
            this.$router.push(`/class/${this.classCode}`)
          })
          .catch(error => {
            swal("Error!", {
              icon: "error",
            });
          });
      }
    }
  }

</script>
