<template>
  <div class="join-class">
    <b-btn class="form__button--register-dark m-0" v-b-modal.modalPrevent>Create Classroom</b-btn>
    <!-- Main UI -->
    <!-- Modal Component -->
    <b-modal id="modalPrevent" ref="modal" title="Classroom Details:" @ok="create">
      <form @submit.stop.prevent="create">
        <div class="form-group">
          <b-form-input type="text" placeholder="Name" v-model="classroom.name" v-validate="'required'"></b-form-input>
          <div class="help-block alert alert-danger" v-show="errors.has('name')">
            {{errors.first('name')}}
          </div>
        </div>
        <div class="form-group">
          <b-form-input type="text" placeholder="Description" v-model="classroom.body" v-validate="'required'"></b-form-input>
          <div class="help-block alert alert-danger" v-show="errors.has('question')">
            {{errors.first('question')}}
          </div>
        </div>
      </form>
    </b-modal>
  </div>
</template>

<script>
  import swal from "sweetalert";
  export default {
    name: 'join-class',
    data() {
      return {
        modalShow: false,
        classroom: {}
      }
    },
    methods: {
      create() {
        this.$validator.validateAll().then(() => {
          this.$http.post("api/classroom/create/a", this.classroom).then(data => {
            this.$router.push(`/class/${data.body.id}`)
            this.$emit('enroll', data.body);
            swal("Succesfully created!", {
              icon: "success"
            });
          });
        });
      },

      authenticatedUser() {
        return this.$auth.getAuthenticatedUser();
      }
    }
  }

</script>
