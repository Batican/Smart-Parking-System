<template>
    <div class="dashboard">
        <v-subheader class="py-0 d-flex justify-space-between rounded-lg">
            <h3 class="black--text">Dashboard</h3>
            
        </v-subheader>
        <br>
        <v-row>
            <v-col lg="12" cols="12">
                <v-alert dense text type="success">
                    Login Successfully! Welcome to <strong>Smart Parking System</strong>
                </v-alert>
                <v-row >
                    <v-col cols="3" v-for="(item,index) in activityLog" :key="index">
                        <v-card elevation="2" class="rounded-lg">
                            <v-card-text class="d-flex justify-space-between align-center">
                                <div>
                                    <strong>{{ item.title }}</strong> <br>
                                    <span>{{item.description}}</span>
                                </div>
                                <v-icon 
                                    size="50"
                                >{{item.icon}}</v-icon>
                                <v-avatar size="60" :color="item.color" style="border: 3px solid #444">
                                    <span style="color: white">{{item.value}}</span>
                                </v-avatar>        
                            </v-card-text>
                            <v-card-actions class="d-flex justify-space-between">
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
            </v-col>
            <v-col>
                <v-card>
                    <v-card-title class="font-weight-bold">
                        Reservation Lists
                    </v-card-title>
                    <v-data-table
                        :items-per-page='5'
                        dense
                        :headers="headers"
                        :items="reserve"
                        item-key="name"
                        class="elevation-1"
                    >
                    </v-data-table>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<script>
    export default {
        name: "Dashboard",
        data() {
            return {
                activityLog: [
                    {title: 'Users', description: 'Total current users', value: 0, icon: 'mdi-account-group', color: 'cyan lighten-3'},
                    {title: 'Departments',description: 'Total current departments',value: 0,icon: 'mdi-office-building', color: 'green darken-2'},
                    {title: 'Parking Slots',description: 'Total current parking slots',value: 0, icon: 'mdi-bus-stop', color: 'blue-grey darken-1'},
                    {title: 'Reservations',description: 'Total current reservations',value: 0, icon: 'mdi-book-edit', color: 'blue'},
                ],
                reserve:[],
                loading: true,
                headers: [
                    {
                        text: 'ID',
                        align: 'center',
                        sortable: false,
                        value: 'id',
                    },
                    {text: 'User ID', align: 'center', value: 'user_id'},
                    {text: 'Parking Number',  align: 'center',value: 'parking_slot.parking_number'},
                    {text: 'Date', align: 'center', value: 'date'},
                ],
            }
        },

        mounted() {
           this.initialize()
        },

        methods: {
            initialize(){
                this.$admin.get('/admin/v1/dashboard/getData').then(({data})=> {
                    this.activityLog[0].value= data.users
                    this.activityLog[1].value= data.departments
                    this.activityLog[2].value= data.parking_slots
                    this.activityLog[3].value= data.reservations
                    

                })

                this.$admin.get('/admin/v1/reservation/index').then(({data})=> {
                    this.reserve = data
                    this.loading = false;
                })
            },  
        }

    }
</script>

<style scoped>
    .overlap-icon {
        position: absolute;
        top: -33px;
        text-align: center;
        padding-top: 12px;
    }
</style>
