export default {
    data() {
        return {
            replies: {}
        }
    },
  methods: {
    add(item) {

    },
    remove(index) {
      this.replies.splice(index, 1);
    },
  }
}
