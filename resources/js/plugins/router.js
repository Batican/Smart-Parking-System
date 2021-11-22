import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";
import store from './store';

import Login from '../pages/Login.vue';
import Backoffice from '../pages/Backoffice.vue';


    import Department from '../pages/Backoffice/Departments.vue';
    import ParkingSlot from '../pages/Backoffice/ParkingSlots.vue';
    import User from '../pages/Backoffice/Users.vue';
    import QrCode from '../pages/Backoffice/QrCode.vue';
    import Dashboard from '../pages/Backoffice/Dashboard.vue'

Vue.use(VueRouter);
Vue.use(Vuetify);

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes: [

        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                requiresAuth: false
            },
        },
        {
            path: '',
            name: 'main',
            component: Backoffice,
            meta: {
                requiresAuth: true
            },
            children : [
                {
                    path: '/dashboard',
                    name: 'dashboard',
                    component: Dashboard
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
        },
    ]
});

router.beforeEach(async (to, from, next) => {
    localStorage.setItem('from', from.fullPath)
    // let user = null
    const user = localStorage.getItem('token')       
    //  try {
    //     user = await store.dispatch('updateUser') 
    // } catch (error) {
    //     user = null
    // }
    
 
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    
    if (!requiresAuth && user) {
        console.log('not require auth but there is user')
        next(from)
    } else if (requiresAuth && !user) {
        console.log('require auth there is no user')
        next('/login');
    } else {
        console.log('next')
        next();
    }

})

export default router;