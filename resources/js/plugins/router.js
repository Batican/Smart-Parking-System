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
    import Reservation from '../pages/Backoffice/Reservations.vue';
    import QrCode from '../pages/Backoffice/QrCode.vue';
    import Dashboard from '../pages/Backoffice/Dashboard.vue';
    import departmentView from '../pages/view/Department.vue';
    import parkingSlotView from '../pages/view/ParkingSlot.vue';
    import userView from '../pages/view/User.vue';
    import UserLogs from '../pages/Backoffice/UserLogs.vue'
    import AdminLogs from '../pages/Backoffice/AdminLogs.vue'

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
                    path: '/reservation',
                    name: 'Reservation',
                    component: Reservation
                },
                {
                    path: '/qr_code/:id',
                    name: 'qr_code',
                    component: QrCode
                },
                {
                    path: '/department-view/:id',
                    name: 'department-view',
                    component: departmentView
                },
                {
                    path: '/parkingSlot-view/:id',
                    name: 'parkingSlot-view',
                    component: parkingSlotView
                },
                {
                    path: '/user-view/:id',
                    name: 'user-view',
                    component: userView
                },
                {
                    path: '/userLogs',
                    name: 'UserLogs',
                    component: UserLogs
                }, 
                {
                    path: '/adminLogs',
                    name: 'AdminLogs',
                    component: AdminLogs
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