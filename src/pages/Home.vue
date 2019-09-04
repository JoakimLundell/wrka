<template>
  <center-layout>
    <div class="info">
        <my-logo>Logo</my-logo>
        <p>Appen för säkrare kontakter till branschanslutna företag</p>
    </div>
    <router-link to="/branch" tag="button">
        Klicka för att hitta rätt hantverkare
    </router-link>
  </center-layout>
</template>

<script>
import CenterLayout from '../layouts/Center.vue'
import MyLogo from '../components/VLogo.vue'

export default {
    components: {
        CenterLayout,
        MyLogo
    },    
}
</script>

<style scoped>

</style>