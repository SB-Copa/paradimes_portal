import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

import './assets/main.css'


// import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'


import AuthComponent from './auth/AuthComponent.vue'


const vuetify = createVuetify({
  components,
  directives,
  icons: {
    defaultSet: 'mdi',
  },
})

const app = createApp(App).use(vuetify);

app.use(createPinia())
app.use(router)
app.component('auth-component' ,AuthComponent);

app.mount('#app')
