<template>
    <v-app-bar app absolute  color="primary" class="text-white">
        <v-app-bar-nav-icon @click="$emit('changeStatusDrawer')" color="white"></v-app-bar-nav-icon>
        <v-toolbar-title class=" black--text">Smart Parking System</v-toolbar-title>
        <v-col />
        <v-spacer />
        <v-menu offset-y>
            <template v-slot:activator="{ attrs, on }">
                <span style="cursor: pointer" v-bind="attrs" v-on="on">
                <v-chip link>
                    <v-badge dot bottom color="green" offset-y="10" offset-x="10">
                    <v-avatar size="40">
                        <v-img src= "https://cdn.vuetifyjs.com/images/lists/1.jpg" />
                    </v-avatar>
                    </v-badge>
                    <span class="ml-3">Daniel Matsunaga</span>
                </v-chip>
                </span>
            </template>
            <v-list width="250" class="py-0">
                <v-list-item two-line>
                <v-list-item-avatar>
                    <img src= "https://cdn.vuetifyjs.com/images/lists/1.jpg" />
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title>Daniel Matsunaga</v-list-item-title>
                    <v-list-item-subtitle>Logged In</v-list-item-subtitle>
                </v-list-item-content>
                </v-list-item>
                <v-divider />
                <v-list-item
                color="secondary"
                @click="logoutAdmin"
            >
                <v-list-item-icon>
                    <v-icon>mdi-logout</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            </v-list>
        </v-menu>
    </v-app-bar>
</template>

<script>
export default {
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