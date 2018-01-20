<template>
    <div>
           <div class="card">
  <div class="card-body">
    <h4 class="card-title">{{ thread.title }}</h4>
    <span v-if="thread.image">
        <img :src="'http://localhost:8000/' + thread.image">
    </span>
    
    <p class="card-text">{{ thread.body }}</p>
    <a href="#!" class="btn btn-primary">comment {{ thread.user_id }}</a>
  </div>
  <hr>
  <p  v-if="thread.user_id == authenticatedUser.id">
      <a class="btn btn-danger" role="button" @click="$emit('delete-thread')"> delete </a>
      <router-link class="btn btn-secondary" :to="'/feed/' + thread.id + '/edit'">edit</router-link>
  </p>
</div>
    </div>
</template>
<script>
    export default {
        props: [
            'thread',
            'authenticatedUser'
        ]
    }
</script>
