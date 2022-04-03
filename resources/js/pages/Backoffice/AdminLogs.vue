<template>
    <div class="mx-2 my-2">
        <v-card class="mx-auto px-5 pxy-5" outlined>
            <v-card-title class="font-weight-bold">
                Admin Logs
                <v-spacer></v-spacer>
            </v-card-title>
                <v-data-table
                        :headers="headers"
                        :items="adminlogs"
                        :items-per-page="5"
                        :loading="loading"
                        class="elevation-1"
                >   
                </v-data-table>
        </v-card>
    </div>
</template>

<script>
export default {
    data() {
        return{
            loading: true,
            adminlogs: [],
            headers: [
                {
                    text: 'ID',
                    align: 'center',
                    sortable: false,
                    value: 'id',
                },
                {text: 'Name',  align: 'center',value: 'name'},
                {text: 'Email',  align: 'center',value: 'email'},
                {text: 'Action',  align: 'center',value: 'description'},
                {text: 'Date Time',  align: 'center', value: 'date_time'},

            ],
        }
        
    },

    mounted() {
           this.initialize()
    },

     methods: {
            initialize(){
                this.$admin.get('/admin/v1/adminLogs/index').then(({data})=> {
                    this.adminlogs = data
                    this.loading = false;
                })
            },  
    }
}
</script>
