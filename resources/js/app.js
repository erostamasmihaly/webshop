import './bootstrap';
import {createApp} from 'vue'
import App from './App.vue'
import router from './route'
if (window.location.href.indexOf("vue") > -1) {
    const app = createApp(App)
    app.use(router)
    app.mount("#app")
}