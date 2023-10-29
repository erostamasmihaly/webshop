import './bootstrap';
import {createApp} from 'vue'
import App from './App.vue'
import router from './route'
if (window.location.href.indexOf("vue") > -1) {
    const app = createApp(App)
    app.use(router)
    app.mount("#app")
}

if (window.location.href.indexOf("react") > -1) {
    await import('./components/Main');
    await import('./components/Payed');
}