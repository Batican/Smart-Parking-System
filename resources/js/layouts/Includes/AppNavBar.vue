<template>
  <v-navigation-drawer
        app
        v-model="drawerStatus"
        persistent
    >
        <v-img src="https://image.freepik.com/free-photo/3d-grunge-room-interior-with-spotlight-smoky-atmosphere-background_1048-11333.jpg" class="pa-4">
            <div class="text-center mt-4">
                <v-avatar class="mb-4" color="grey darken-1" size="64">
                    <v-img aspect-ratio="30" src="https://www.pngitem.com/pimgs/m/380-3801971_no-parking-car-bike-hd-png-download.png">

                    </v-img>
                </v-avatar>

                <h2 class="white--text">Admin</h2>
            </div>
        </v-img>

        <v-divider></v-divider>
        <v-list>
            <v-list-item
                v-for="item in items"
                :key="item.title"
                color="secondary"
                link
                :to="item.route"
            >
                <v-list-item-icon>
                    <v-icon>{{ item.icon }}</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
        <template v-slot:append>
            <v-list-item
                color="secondary"
                @click="logoutAdmin"
            >
                <v-list-item-icon>
                    <v-icon>mdi-logout-variant</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </template>
    </v-navigation-drawer>
</template>
<script>
export default {
    data: () => ({
        items: [
            { title: 'Dashboard', icon: 'mdi-view-dashboard', route: '/dashboard' },
            { title: 'Users', icon: 'mdi-account-supervisor', route: '/user' },
            { title: 'Departments', icon: 'mdi-office-building', route: '/departments' },
            { title: 'Parking Slots', icon: 'mdi-bus-stop', route: '/parking_slots' },
            { title: 'Logs', icon: 'mdi-clipboard-text-clock', route: '/' },

        ],
    }),
    props : {
        is_open : {
            require: true,
            type : Boolean
        }
    },

    computed: {
       drawerStatus: {
            get: function () {
                return this.is_open
            },
            set: function (newValue) {

            }
        },
    },
    methods : {
        logoutAdmin(){
            this.$admin.post('admin/v1/logout').then(({data}) => {
                localStorage.removeItem("token")
                this.$router.push('/login')
            })
        }
    },
    
}
</script>
