<template>
  <button 
    v-bind:href="href"
     v-on:click="go"
    ><slot></slot></button>
    
</template>

<script>
 
  export default {
    props: {
      href: {
        type:String,
        required: true 
      }
    },
    methods: {
      go (event) {
        event.preventDefault()
        //this.$root.currentRoute = this.href
        //console.log(this.href)
        //
        this.$emit('click', this.href);

        /*window.history.pushState(
          null,
          routes[this.href],
          this.href
        )*/
      }
    }
  }
</script>

<style scoped>
  .active {
    color: cornflowerblue;
  }

  button {
    background: #4f8a26;
    border: 0;
    border-radius: 6px;
    padding: 12px 24px;
    margin: 3px;
    box-shadow: 3px 3px 6px rgba(0,0,0,0.6);
  }

  button.wide {
    width: 300px;
  }

  button:hover {
    background: #a3d147;
  }
</style>