<template>
    <select @change="onChange()" v-model="selected">
        <option v-for="(option, index) in options" :key="index" :value="option">
          {{option}}</option> 
    </select>   
</template>

<script>
 
  export default {
    props: {
      options: {
        type: Array,
        required: true 
      },
      index: {
        type: String,
      }
      
    },
    methods: {
      onChange () {
        if(this.selected !== 'Välj ort'){
          this.$emit('change', this.selected);
        }
      }
    },
    data: function () {
      return {
        selected: this.index
      }
    }, 
    watch: {
      index: function () {
        this.selected = this.index;
      }
    }
  }
</script>

<style scoped>
  
</style>