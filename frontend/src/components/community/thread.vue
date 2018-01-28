<script>
  import Wysiwyg from './wysiwyg.vue';
  import SubscribeButton from './subscribe-button';
  export default {
    components: {
      'wysiwyg': Wysiwyg,
      'subscribe-button': SubscribeButton
    },
    props: ['attriThread', 'owner'],
    name: 'thread',
    data() {
      return {
        editThread: {
          body: this.attriThread.body,
          title: this.attriThread.title
        },
        editingThread: false,
        active: false,
        isAuth: false,
        authUser: {},
        show: false
      }
    },
    methods: {
      deleteThread() {
        this.$http.delete(`api/community/${this.$route.params.slug}/${this.$route.params.id}`)
          .then(function (response) {
            this.$router.push(`/community/${this.$route.params.slug}`);
            swal("Deleted!", {
              icon: "success",
            });
          }, function (response) {
            this.$router.push(`/community/${this.$route.params.slug}`);
            swal("Error!", {
              icon: "error",
            });

          });
      },
      editThread() {
        this.editingThread = true;
      },
      update() {
        this.$http.patch(`api/community/${this.$route.params.slug}/${this.$route.params.id}`, this.editThread)
          .then(data => {
            this.attriThread.body = this.editThread.body
            this.attriThread.title = this.editThread.title
            this.editingThread = false
            swal("Edited!", {
              icon: "success",
            });
          }, function (response) {
            //this.$router.push(`/community/${this.$route.params.slug}/${this.$route.params.id}`);
            swal("Error!", {
              icon: "error",
            });

          });
      },
      fetch() {
        this.active = this.attriThread.isSubscribedTo
        this.$nextTick(function () {
          this.isAuth = this.$auth.isAuthenticated();
        })
        this.$http.get('api/user')
          .then(response => {
            this.authUser = response.body
            this.show = true
          })
      }
    },
    mounted() {
      this.$nextTick(function () {
        this.fetch()
      })
    },
    
  }

</script>

<style scoped lang="scss">


</style>
