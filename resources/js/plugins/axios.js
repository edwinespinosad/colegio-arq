import axios from 'axios';
import { createApp } from 'vue';

const app = createApp({});
app.config.globalProperties.$axios = axios;
