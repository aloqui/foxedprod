<template>
      <div>
        <activity v-for="activity in activities" @delete-activity="deleteActivity(activity)" :authenticatedUser="authenticatedUser" :activity="activity"></activity>
    </div>
</template>

<script>
import Activity from './Activity.vue'
import swal from 'sweetalert'

        export default {
        data () {
            return {
                activities:[],
            }
        },
        computed: {
            authenticatedUser () {
                return this.$auth.getAuthenticatedUser()
            }
        },
        components: {
            'activity' : Activity
        },
        created () {
            this.$http.get(`api/activities/${this.$route.params.id}`)
            .then(response => {
                this.activities = response.body
            })
        },
        methods: {
            deleteActivity(activities) {
                swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                this.$http.delete('api/activity/' + activities.id)
                .then(response => {
                    let index = this.activities.indexOf(activities)
                    this.activities.splice(index,1)
                    swal("Poof! Your imaginary file has been deleted!", {
                icon: "success",
                });
                })
                
            } else {
                swal("Your imaginary file is safe!");
            }
            });
            }
        }
    }
</script>