<template>
    <div class="mx-2 my-2">
        <v-card class="mx-auto px-5 pxy-5" outlined>
            <v-card-title class="font-weight-bold">
                Logs
                <v-spacer></v-spacer>
            </v-card-title>
                <v-data-table
                        :headers="headers"
                        :items="reservations"
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

            headers: [
                {
                    text: 'ID',
                    align: 'center',
                    sortable: false,
                    value: 'id',
                },
                {text: 'Name',  align: 'center',value: 'name'},
                {text: 'Parking Number',  align: 'center',value: 'abbreviation'},
                {text: 'Date Time',  align: 'center', value: 'action'},

            ],
        }
        
    },
}
</script>
