import Vue from 'vue'
import VueRouter from 'vue-router'
//import routes from './routes'
//import MainLayout from './layouts/Main.vue'
import Hello from './Hello.vue'
import Listing from './pages/Listing.vue'
import ListingSsr from './pages/ListingSsr.vue'
import Home from './pages/Home.vue'
import Branch from './pages/Branch.vue'

Vue.use(VueRouter)



const routes = [
  { path: '/', component: Home },
  { path: '/home', component: Home },
  { path: '/branch', component: Branch },
  { path: '/listing', component: Listing },
  { path: '/listing-ssr', component: ListingSsr, name:'listing-ssr' },
  { path: '/listing/:id', component: Listing, props:true, name: 'listing' },
]

const router = new VueRouter({
  routes // short for `routes: routes`
})

const app = new Vue({
  router,
  template: `
    <div id="app">
      <header>
        <nav>
          <ul>
            <li><router-link to="/home">WRKA</router-link></li> 
            <li><router-link to="/branch"> > Branch</router-link></li>
          </ul>
        </nav>
      </header>

      <router-view :state="state" class="content"></router-view>
    </div>
  `,
  data: {
    state : {
      userCount: 0,
      loading: false,
      branch: null,
      resellers: []
    }
  },
  
  methods: {
    clickHandler (event) {
      alert("click!");
    },
    branchHandler(value) {
      this.state.branch = value;
      router.go('listing')
    },
  },

  created: function() {
    this.$on('updateselection', function(value){
        console.log(value);
        this.state.userCount++;
    });
    this.$on('current-route', function(value){
      console.log(value);
      router.go('branch')
    });
    this.$on('branch', function(value){
      console.log("Branch = " + value);
      this.branchHandler(value);
    });
   
  }
  
}).$mount('#app')


/*window.addEventListener('popstate', () => {
  app.currentRoute = window.location.pathname
})*/