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
    background: transparent;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    padding: 12px;
  }
  .info {
    color: var(--green);
    font-size: 18px;
    font-weight: bolder;
    text-align: center;
    height: 30vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }
</style>