import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import App from './App'
import store from './store'

import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'vue-material-design-icons/styles.css'

Vue.use(BootstrapVue);

import History from './components/History'
import Shop from './components/Shop'


new Vue({
      el: '#app',
      render: a => a(App),
      store
})
