<template v-cloak>
  <div v-if="authenticatedUser">
    <button :class="classes" @click="subscribe" v-text="subscribed" v-cloak></button>
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
        return ['btn content__helper text-uppercase', this.active ? 'content__button--danger' : 'content__button--passive'];
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
        setTimeout(() => {
          this.$http[(this.active ? 'delete' : 'post')](`api${this.$route.path}/subscriptions`)
            .then(() => {
              this.active = !this.active;
            })
            .catch(() => {
              alert("failed");
            })
        }, 2000)
      }
    },
    mounted() {

    }
  };

</script>

<style lang="scss" scoped>
  [v-cloak] {
    display: none;
  }
</style>
