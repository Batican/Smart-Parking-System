<template>
    <div class="mx-2 my-2">
        <v-card class="mx-auto px-5 pxy-5" outlined>
            <v-card-title class="font-weight-bold">
                Reservation List
                <v-spacer></v-spacer>
                <v-icon
                    x-large 
                    @click="addReservation"
                >
                    mdi-plus
                </v-icon>
            </v-card-title>
                <v-data-table
                        :headers="headers"
                        :items="reservations"
                        :items-per-page="5"
                        :loading="loading"
                        class="elevation-1"
                >   
                   
                    <template v-slot:item.generate ="{ item }">
                        <v-btn x-small class="btn btn-primary mr-2" @click="$router.push('/qr_code/'+ item.id)">Show</v-btn>
                        <v-btn v-if="!item.qrCode_path" x-small color="teal" outlined @click="generate(item.id)">Generate</v-btn>

                    </template>

                    <template v-slot:item.status ="{ item }">
                        {{item.status == 1 ? 'Available' : item.status == 2 ? 'Occupied': 'Reserved'}}
                    </template>
                    
                    <template v-slot:item.action ="{ item }">
                        <v-icon class="mr-2" @click="editReservation(item)">mdi-pencil</v-icon>
                        <v-icon @click="deleteDialog = true, delete_id = item.id">mdi-delete</v-icon>
                    </template>
                </v-data-table>
        </v-card>
        <ReservationForm :form="reservationForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,updateReservation()" />
        <v-row justify="center">
            <v-dialog
                v-model="deleteDialog"
                persistent
                max-width="290"
            >
                <v-card>
                    <v-card-title class="error headline" style="font-weight:bold; color:white;">
                        Confirm Delete
                    </v-card-title>
                    <v-card-text class="mt-4">Are you sure you want to delete this?</v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            text
                            @click="deleteDialog = false, delete_id= null"
                        >
                            Cancel
                        </v-btn>
                        <v-btn
                            color="error"
                            text
                            @click="deleteReservation(delete_id), delete_id = null"
                        >
                            Delete
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </div>
</template>

<script>
  import ReservationForm from '../../components/adminForms/Reservation.vue'

    export default {
        components: {
            ReservationForm
        },
        data() {
            return {
                delete_id: null,
                deleteDialog: false,
                loading: true,
                reservations: [],
                title:'',
                headers: [
                    {
                        text: 'ID',
                        align: 'center',
                        sortable: false,
                        value: 'id',
                    },
                    {text: 'User Name', align: 'center', value: 'user.name'},
                    {text: 'Parking Number',  align: 'center',value: 'parking_slot.parking_number'},
                    {text: 'Date', align: 'center', value: 'date'},
                    {text: 'Actions',  align: 'center', value: 'action'},

                ],
                reservation:{
                    user_id: '',
                    slot_id:'',
                    date:'',
                   
                },
                addition_edition_dailog: false,
                reservationForm: {
                    id:null,
                    user_id: '',
                    slot_id:'',
                    date:'',
                }

            }
        },
        mounted() {
           this.initialize()
        },

        methods: {
            initialize(){
                this.reservationForm = {
                    id:null,
                    user_id: '',
                    slot_id:'',
                    date:'',
                }
                this.$admin.get('/admin/v1/reservation/index').then(({data})=> {
                    this.reservations = data
                    this.loading = false;
                })
            },  

            deleteReservation(id) {
                this.$admin.delete(`/admin/v1/reservation/delete/${id}`).then(({data}) => {
                        this.deleteDialog = false;
                        this.initialize()
                    });
                
            },

            addReservation() {
                this.reservationForm = {
                    id:null,
                    user_id: '',
                    slot_id:'',
                    date:(new Date()).toISOString().split('T')[0],
                }
                this.addition_edition_dailog = true
            },

            editReservation(reservation){
                this.reservationForm = {
                    id:reservation.id,
                    user_idr:reservation.user_id,
                    slot_id:reservation.slot_id,
                   date:reservation.date,
                }
                this.addition_edition_dailog = true
            },

            updateReservation() {
                if(this.reservationForm.id){
                    this.$admin.post('admin/v1/reservation/update/'+this.reservationForm.id,this.reservationForm).then(({data}) => {
                        this.initialize()
                    })
                }
                else{
                    this.$admin.post('admin/v1/reservation/create',this.reservationForm).then(({data}) =>{
                        this.initialize()
                    })
                }      
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