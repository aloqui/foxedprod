<template>
  <div>
    <ul class="pagination" v-if="shouldPaginate">
      <li class="page-item" v-show="prevUrl">
        <a class="page-link content__helper" href="#" aria-label="Previous" rel="prev" @click.prevent="page--">
          <span aria-hidden="true">&laquo; Previous</span>
          <span class="sr-only">Previous</span>
        </a>
      </li>
      <li class="page-item" v-show="nextUrl">
        <a class="page-link content__helper" href="#" aria-label="Next" rel="next" @click.prevent="page++">
          <span aria-hidden="true">Next &raquo;</span>
          <span class="sr-only">Next</span>
        </a>
      </li>
    </ul>
  </div>
</template>
<script>
  export default {
    props: ['dataSet'],
    data() {
      return {
        page: 1,
        prevUrl: false,
        nextUrl: false,
        currentState: `${this.$route.path}`
      }
    },
    watch: {
      dataSet() {
        this.page = this.dataSet.current_page;
        this.prevUrl = this.dataSet.prev_page_url;
        this.nextUrl = this.dataSet.next_page_url;
      },
      page() {
        this.broadcast();
        this.updateUrl();
      }
    },
    computed: {
      shouldPaginate() {
        return !!this.prevUrl || !!this.nextUrl;
      }
    },
    mounted() {
      this.dataSet();
    },
    methods: {
      broadcast() {
        this.$emit('changed', this.page);
      },
      updateUrl() {
         this.$router.replace(`${this.currentState}?page=${this.page}`);
      },
      dataSet() {
        this.page = this.dataSet.current_page;
        this.prevUrl = this.dataSet.prev_page_url;
        this.nextUrl = this.dataSet.next_page_url;
      },
    }
  }

</script>
