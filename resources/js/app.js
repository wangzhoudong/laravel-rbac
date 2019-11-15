import Vue from 'vue';
import axios from 'axios';
import api from './api' // 导入api接口
import store from './store'

import { router } from './router';

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

Vue.use(ElementUI);



Vue.prototype.$api = api // 将api挂载到vue的原型上

Vue.prototype.$http = axios.create();



new Vue({
    router,
    store,
    el: '#app'
});
