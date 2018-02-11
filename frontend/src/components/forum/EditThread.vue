<template>
  <div class="row">
      <div class="col-md-8 col-md-offser-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="thread.title">
                    </div>
                    <div class="form-group">
                        <label>Question</label>
                        <textarea type="text" class="form-control" v-model="thread.body"></textarea>
                    </div>
                    <button @click="update" class="btn btn-success" v-if="thread.body && thread.title">Update</button>
                </div>
            </div>
      </div>
  </div>
</template>
<script>
export default {
    created (){
        this.getThread();
    },
  data () {
      return {
          thread: {}
      }
  },
  methods: {
      getThread (){
          this.$http.get('api/forums/'+ this.$route.params.thread)
          .then(response => {
              this.thread = response.body
          })
      },
      update () {
          this.$http.put('api/forums/' + + this.$route.params.thread, this.thread)
          .then(response => {
              console.log(response)
                    swal("Succesfully Updated!", {
                icon: "success",
                });
              this.$router.push('/feed')
          })
      }
  },
}
</script>
