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
     data() {
    return {
      routes: this.$router.options.routes
    };
  }
    
  }
</script>

<style scoped>
   
  .container {
    background: transparent;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: calc(100vh - 155px);
    
  }
  .info {
    color: var(--green);
    font-size: 18px;
    font-weight: bolder;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }
</style>