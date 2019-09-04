<template>
  <div>
    <h2 class="hello">Hello</h2>
    <p>Loading: {{this.state.loading}}</p>
    <p>State: {{this.state.userCount}}</p>
    <button @click="click">+ 5</button>
  </div>
</template>

<script>
export default {
  props: {
    state: {
      type: Object
    }
  },
  methods: {
    click (event) {
  //    this.$emit('click', 'someValue')
  this.$parent.$emit('updateselection', 'test');
    }
  }
}
</script>