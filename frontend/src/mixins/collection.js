export default {
    data() {
        return {
            replies: {}
        }
    },
  methods: {
    add(item) {
      this.replies.push(item)
    },
    remove(index) {
      this.replies.splice(index, 1);
    },
  }
}
