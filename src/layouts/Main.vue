<template>
  <div class="container">
    <slot></slot>
  </div>
</template>

<script>
  import VLink from '../components/VLink.vue'
  
  export default {
    components: {
      VLink
    },
    
  }
</script>

<style scoped>
   
  .container {
    background: transparent
  }
</style>