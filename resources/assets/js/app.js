import Vue from 'vue/dist/vue.js';
import axios from 'axios'
import App from './components/App.vue';
import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/en'

Vue.use(ElementUI, { locale });
Vue.use(ElementUI);
Vue.prototype.$http = axios.create();

new Vue({
    el: '#root',
    data() {
        return {
            showModal: false
        }
    },
    render: h => h(App),
});