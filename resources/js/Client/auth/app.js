import { createApp } from "vue";
import Login from './Login.vue';
import '@mdi/font/css/materialdesignicons.css'
//import router from './router';
import VueSweetalert2 from "vue-sweetalert2";
import 'sweetalert2/dist/sweetalert2.min.css'
import 'vuetify/styles'
import { createVuetify } from "vuetify";
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '../../../less/login.less'
import '../../plugins/axios'
const vuetify = createVuetify({
    components,
    directives,
})

createApp(Login).use(vuetify).use(VueSweetalert2).mount('#client_login')
