<template>
    <div>
           <div class="card">
  <div class="card-body">
      
    <h4 class="card-title"><router-link  :to="'/activity/' + activity.id">{{ activity.title }}</router-link></h4>
    <span v-if="activity.image != 'none'">
        <img :src="'http://localhost:8000/' + activity.image">
    </span>
    
    <p class="card-text">{{ activity.body }}</p>
    <router-link v-if="activity.type == 'code'" v-show="activity.user_id != authenticatedUser.id" class="btn btn-primary" :to="'/'+ activity.id + '/activity'">Start</router-link>
    <button v-if="activity.type == 'image'" v-show="activity.user_id != authenticatedUser.id">Submit</button>
  </div>
  <hr>
  <p  v-if="activity.user_id == authenticatedUser.id">
      <a class="btn btn-danger" role="button" @click="$emit('delete-activity')"> delete </a>
      <router-link class="btn btn-secondary" :to="'/feed/' + activity.id + '/edit'">edit</router-link>
  </p>
</div>
    </div>
</template>
<script>
    export default {
        props: [
            'activity',
            'authenticatedUser'
        ]
    }
</script>
<style lang="scss">
</style>
