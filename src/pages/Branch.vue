<template>
  <center-layout>
    <div class="info">Klicka på den ruta inom vilken branch du söker företag.</div>
   
    <router-link :to="{ name: 'listing', params: { branchId: 1 }}" tag="button">El</router-link>
    <router-link :to="{ name: 'listing', params: { branchId: 2 }}" tag="button">VVS</router-link>
    <router-link :to="{ name: 'listing', params: { branchId: 3 }}" tag="button">Låssmed</router-link>
   
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

</style>