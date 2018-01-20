<template>
      <div>
        <!-- <thread v-for="thread in forums" @delete-thread="deleteThread(thread)" :authenticatedUser="authenticatedUser" :thread="thread"></thread> -->
    </div>
</template>

<script>
import Threads from './Thread.vue'
import swal from 'sweetalert'

        export default {
        data () {
            return {
                forums:[],
            }
        },
        computed: {
            authenticatedUser () {
                return this.$auth.getAuthenticatedUser()
            }
        },
        components: {
            'thread' : Threads
        },
        created () {
            this.$http.get('api/forums')
            .then(response => {
                this.forums = response.body
            })
        },
        methods: {
            deleteThread(thread) {
                swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                this.$http.delete('api/forums/' + thread.id)
                .then(response => {
                    let index = this.forums.indexOf(thread)
                    this.forums.splice(index,1)
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