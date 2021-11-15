import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";


import Department from './pages/Departments.vue';
import ParkingSlot from './pages/ParkingSlots.vue';
import User from './pages/Users.vue';
import QrCode from './pages/QrCode.vue';
import Login from './pages/Login.vue';


Vue.use(VueRouter);
Vue.use(Vuetify);

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes: [

        {
            path: '/',
            name: 'login',
            component: Login
        },

        {
            path: '/user',
            name: 'user',
            component: User
        },
       
        {
            path: '/departments',
            name: 'Departments',
            component: Department
        },
        {
            path: '/parking_slots',
            name: 'ParkingSlot',
            component: ParkingSlot
        },
        {
            path: '/qr_code/:id',
            name: 'qr_code',
            component: QrCode
        },
        
        
        
    ]
});

export default router;