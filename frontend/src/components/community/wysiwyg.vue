<template>
  <div class="trix__editor">
    
    <input id="trix" type="hidden" :value="value">
    <trix-editor ref="trix" input="trix"></trix-editor>
  </div>
</template>

<script>
import Trix from 'trix';
  export default {
    name: 'wysiwyg',
    props: ['name', 'value'],
    mounted() {
      this.$refs.trix.addEventListener('trix-change', e => {
        console.log("handling");
        this.$emit('input', e.target.innerHTML);
      })
    },
    data() {
      return {
      }
    }

  }

</script>
