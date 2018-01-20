<template>
  <div>
    <div class="dropdown ml-2">
      <a href="#" class="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="far fa-bell"></i>
      </a>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <div v-if="notifications.length">
        <router-link :to="notification.data.link" @click.prevent="markAsRead(notification)" v-for="notification in notifications">
          <li class="p-2">
            <p>{{notification.data.message}}</p>
          </li>
        </router-link>
        </div>
        <div v-else>
          <li>
            <p class="p-2">No current notifications.</p>
          </li>
        </div>
      </ul>
    </div>
  </div>
</template>
<script>
  export default {
    props: ['user'],
    data() {
      return {
        notifications: false
      }
    },
    mounted() {
      this.fetch()

    },
    methods: {
      fetch() {
        this.$http.get(`api/profiles/${this.user.username}/notifications`)
          .then(this.refresh)
      },
      refresh(data) {
        console.log(data)
        this.notifications = data.data
      },
      markAsRead(notification) {
        this.$http.delete(`api/profiles/${this.user.username}/notifications/${notification.id}`)
          .then(() => {})
          .catch(() => {
            alert("failed");
          })
      }

    }

  }

</script>
