<template>
  <div class="user-notifications">
    <div class="dropdown ml-2">
      <a href="#" class="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="far fa-bell"></i>
        <p class="notification-count" v-if="notifications.length">{{notifications.length}}</p>
      </a>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <div v-if="notifications.length">
          <div class="" v-for="notification in notifications">
            <div @click="markAsRead(notification)">
              <router-link :to="notification.data.link">
                <li class="p-2 d-flex align-items-center">
                  <img class="picture-placeholder--notification" :src="notification.data.owner.avatar_path" alt="">
                  <p class="content__helper">{{notification.data.message}}</p>
                  <hr>
                </li>
              </router-link>
            </div>
          </div>
        </div>
        <div v-else>
          <li>
            <p class="p-2 content__helper">No current notifications.</p>
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
        this.notifications = data.data
        console.log('notif')
        console.log(this.notifications)
      },
      markAsRead(notification) {
        this.$http.delete(`api/profiles/${this.user.username}/notifications/${notification.id}`)
          .then(() => {})
          .catch(() => {})
      },
    },
    sockets: {
      notify(notification) {
        var notificationData = JSON.parse(notification)
        console.log("new not")
        console.log(notificationData)
        this.fetch()
        
      }
    }
  }

</script>
