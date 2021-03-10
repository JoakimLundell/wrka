<template>
    <div @click="click" :data-id="reseller.id" class="reseller" :id="'id' + reseller.id" v-bind:class="classObject">
        <div class="name">{{reseller.name}}</div>
        <div>{{reseller.street}} {{reseller.zipcode}}</div>
        <div class="contact">
            <div>{{reseller.phone}}</div>
            <div>{{reseller.email}}</div>
            <div>{{reseller.website}}</div>
        </div>
    </div>
    
</template>

<script>
import { bus } from '../bus.js';
 
  export default {
    props: {
      reseller: {
        type: Object,
        required: true 
      },
      active: {
        type: Number
      }
    },
    methods: {
      click (e) {
        //event.preventDefault();
        let id = e.currentTarget.getAttribute('data-id');
        bus.$emit('resellerClick', id);
      }
    },
    computed: {
      classObject() {
        return (this.active == this.reseller.id) ? 'active' : '';
      }
    },
    /*watch: {
      active: function() {
        bus.$emit('scrollIntoView');
      }
    }*/
    /*mounted: function() {
      console.log("HEj" + (this.active == this.reseller.id));
      
    },*/
  }
</script>

<style scoped>
    .reseller {
        width: 300px;
        height: 100px;
        padding: 12px 24px;
        background: transparent;
        color: darkslategray;
        
       
    }
    .name {
        font-weight: 700;
    }
    .contact {
        display: flex;
        flex-direction: column;
    }
    .active {
      background:var(--palegreen);
      border-radius: 6px;
    }

    /*.fade-enter-active, .fade-leave-active {
      transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to  {
      opacity: 0; 
    }*/
</style>