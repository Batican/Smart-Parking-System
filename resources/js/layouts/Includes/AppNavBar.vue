<template>
  <v-navigation-drawer
        app
        v-model="drawerStatus"
        persistent
        color="primary"
    >   
        <v-img src="/images/nwssu.png" class="pa-4" dark>
        </v-img>
        
        <v-list>
            <v-list-item
                v-for="item in items"
                :key="item.title"
                color="black"
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
                { title: 'Reservations', icon: 'mdi-book-edit', route: '/reservation' },
                { title: 'Logs', icon: 'mdi-clipboard-text-clock', route: '/userLogs' },

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
