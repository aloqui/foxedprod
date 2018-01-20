<template>
  <div v-if="authenticatedUser">
    <button :class="classes" @click="subscribe" v-text="subscribed"></button>
  </div>
</template>
<script>
  export default {
    props: ['active'],
    data() {
      return {
        //active: false
      }
    },
    computed: {
      classes() {
        return ['btn', this.active ? 'btn-danger' : 'btn-primary'];
      },
      authenticatedUser() {
        return this.$auth.isAuthenticated()
      },
      subscribed() {
        return this.active ? 'Unsubscribe' : 'Subscribe';
      }
    },
    methods: {
      subscribe() {

        this.$http[(this.active ? 'delete' : 'post')](`api${this.$route.path}/subscriptions`)
          .then(() => {
            this.active = !this.active;

          })
          .catch(() => {
            alert("failed");
          })
      }
    },
    mounted() {

    }
  };

</script>
