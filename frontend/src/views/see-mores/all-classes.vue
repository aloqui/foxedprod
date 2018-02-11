<template>
  <div class="forums mt-5 pt-5">
    <div class="container">
      <div class="row">
        <div class="col section-block">
          <h1 class="font--semi-bold">Classes</h1>
          <hr>
          <div>
            <div v-for="room in classes" v-bind:key="room.id">
              <div class="mb-4">

                <router-link class="no-decoration" :to="`/class/${room.id}`">
                  <h1 class="forum__title">{{room.name}}</h1>
                  <p class="content__helper mt-2">About the class:</p>
                  <p class="content--paragraph" v-text="room.body"></p>
                <hr>
                </router-link>
              </div>
            </div>
            <!-- <ais-index index-name="classrooms" app-id="TN5MR9QHP4" api-key="a933713f38f230be88643278a41c7281">
            
              <p class="content__helper">Search for classroom</p>
              <ais-search-box autofocus>
                <ais-input class="" placeholder="Find a class" autofocus v-on:click="resetPage"></ais-input>
              </ais-search-box>
              <p class="content__helper">Classroom Name</p>
              <ais-results>
                <template slot-scope="{ result }">
                  <div class="mb-2">
                    <router-link class="no-decoration" :to="`/class/${result.id}`">
                      <div class="d-flex flex-column">
                        <div class="forum__title">
                          <ais-highlight :result="result" attribute-name="name">
                          </ais-highlight>
                        </div>
                        <p class="content__helper">About the class:</p>
                        <p class="content--paragraph" v-text="result.body"></p>
                      </div>
                    </router-link>
                  </div>
                </template>
              </ais-results>
            </ais-index> -->
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
        classes: {}
      }
    },
    mounted() {
      this.fetch()
    },
    methods: {
      fetch() {
        this.$http.get('api/classroom/all')
          .then(this.refresh)
      },
      refresh(data) {
        this.classes = data.body
      }
    }
  }

</script>
