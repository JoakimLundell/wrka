<template>
  <center-layout>
    <div class="info">Inom vilken branch söker du företag?</div>
   
    <router-link :to="{ name: 'listing', params: { branchId: 3 }}" tag="button">SLR - Låssmed</router-link>
    <router-link :to="{ name: 'listing-ssr', params: { branchId: 2 }}" tag="button">Säkerhetsbranchen</router-link>
    <router-link to="/branch" tag="button">..nästa branch</router-link>
    
  </center-layout>
</template>

<script>
  import CenterLayout from '../layouts/Center.vue'
  import VButton from '../components/VButton.vue'

  export default {
    components: {
      CenterLayout,
      VButton
    },
    methods: {
      click (value) {
        this.$root.$emit('branch', value);
      }
    }
  }
</script>

<style scoped>
.info {
  padding: 24px;
}
</style>