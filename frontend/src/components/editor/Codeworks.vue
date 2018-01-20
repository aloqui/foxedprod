<template>
  <div>
    <div >
        <div class="code-card">
      <div class="code-container" v-for="code in codes.codes">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">{{ code.title }}</h4>
              <!-- <p class="card-text">{{ code.body }}</p> -->
              <!-- <a href="#!" class="btn btn-primary">comment {{ code.user_id }}</a> -->
            </div>
            <hr>
            <p v-if="code.user_id == authenticatedUser.id">
              <!-- <a class="btn btn-danger" role="button" @click="$emit('delete-code')"> delete </a> -->
              <router-link class="btn btn-secondary" :to="'codes/' + code.id">edit</router-link>
            </p>
            <p v-else>
              <router-link class="btn btn-secondary" :to="'codes/' + code.id">view</router-link>
            </p>
          </div>
        </div>
      
      </div>
    </div>
    
  </div>
</template>
<script>
  export default {
    data() {
      return {
        codes: {}
      }
    },

    mounted() {

      this.fetch();
    },
    methods: {
      fetch() {
        this.$http.get(`api/${this.$route.params.user}/codes`)
          .then(this.refresh)
      },
      refresh(data) {
        this.codes = data.body
      }
    },
    computed: {
      authenticatedUser() {
        return this.$auth.getAuthenticatedUser()
      }
    },
  }

</script>

<style lang="scss" scoped>
.code-card{
  width: 100%;
  display: flex;
  
  .code-container{
    display: flex;
    width: 100%;
    justify-content: space-around;
  }
}
.card {
  background: #000;
  flex:1;
  width: 100%;
  .card-body{
    width: 100%;
  }
}
</style>

