import './bootstrap';


import {createApp} from 'vue/dist/vue.esm-bundler.js';
import Notification from './components/Notification.vue';
import Chat from './components/Chat.vue';


const app = createApp({});

app.component('notification-component', Notification);
app.component('chat-component', Chat);

app.mount("#app");
