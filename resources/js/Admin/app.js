import { createApp } from "vue";
import App from "./pages/App.vue";
import '@mdi/font/css/materialdesignicons.css'
import router from './router/router.js';
import VueSweetalert2 from "vue-sweetalert2";
import 'sweetalert2/dist/sweetalert2.min.css'
import 'vuetify/styles'
import { createVuetify } from "vuetify";
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '../../less/admin.less'
import '../plugins/axios'

import mitt from 'mitt';
const emitter = mitt();

const vuetify = createVuetify({
    components,
    directives,
})

const app = createApp(App);
app.use(vuetify).use(VueSweetalert2).use(router);
app.config.globalProperties.emitter = emitter;
app.mount('#admin');
