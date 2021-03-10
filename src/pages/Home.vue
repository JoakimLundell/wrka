<template>
  <center-layout>
    <div class="info">
        <my-logo>Logo</my-logo>
        <p style="width: 330px">Lätt att hitta rätt bland branschanslutna företag</p>
    </div>
    <router-link to="/branch" tag="button">
        Söker som privatperson
    </router-link>
    <router-link to="/branch" tag="button">
        Söker som företag
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