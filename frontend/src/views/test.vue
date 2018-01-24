<template>
  <div class="test">
    <input type="text" v-model="title"> <br>
    <h1>{{title}}</h1>
    <p>{{user.firstName}}</p>
    <p v-if="showName">{{user.firstName}}</p>
    <p v-else="showName">Nobody</p>
    <ul>
      <li v-for="item in items">{{item.title}}</li>
    </ul>
    <button v-on:click="greet('hello world')">Say Greeting</button>
    <input type="text" v-on:keyup="pressKey" v-on:keyup.enter="enterHit">
    <hr>
    <label for="">First Name</label>
    <input type="text" v-model="user.firstName">
    <br>
    <label for="">Last Name</label>
    <input type="text" v-model="user.lastName">
    <h3>{{fullName}}</h3>
    <h2>{{msg}}</h2>
    <h1>Task list</h1>
  <task-list></task-list>
  </div>
  
</template>

<script>
export default {
  name: 'test',
  props: {
    msg: {
      type: String,
      default: 'Foobar'
    }
  },
  data() {
    return {
      title: 'HELLO WORLD',
      user: {
        firstName: 'John',
        lastName: 'Doe'
      },
      showName: false,
      items: [
        {title: 'Item One'},
        {title: 'Item Two'},
        {title: 'Item Three'}
      ]
    }
  },
  methods: {
    greet: (greeting) => {
      alert(greeting);
    },
    pressKey: (e) => {
      console.log(e.target.value);
    },
    enterHit: () => {
      console.log('You Hit Enter!');
    }
  },
  computed: {
    fullName: function() {
      return `${this.user.firstName} ${this.user.lastName}`;
    }
  }
}
</script>

<style scoped>

</style>

