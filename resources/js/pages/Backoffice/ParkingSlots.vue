<template>
    <div class="mx-2 my-2">
        <v-card class="mx-auto px-5 pxy-5" outlined>
            <v-card-title class="font-weight-bold">
                Parking Slots List
                <v-spacer></v-spacer>   
                <v-switch
                    v-model="switch1"
                    inset
                    color="red"
                ></v-switch>
                <v-icon
                    x-large 
                    @click="addSlot"
                >
                    mdi-plus
                </v-icon>
            </v-card-title>
                <v-data-table
                        :headers="headers"
                        :items="slots"
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
                        <v-icon class="mr-2" @click="$router.push('/parkingSlot-view/'+item.id)">mdi-eye</v-icon>
                        <v-icon class="mr-2" @click="editSlot(item)">mdi-pencil</v-icon>
                        <v-icon @click="deleteDialog = true, delete_id = item.id">mdi-delete</v-icon>
                    </template>
                </v-data-table>
        </v-card>
        <SlotForm :fromDepartment ="false" :form="slotForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,updateSlot()" />
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
                            @click="deleteSlot(delete_id), delete_id = null"
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
  import SlotForm from '../../components/adminForms/ParkingSlot.vue'

    export default {
        components: {
            SlotForm
        },
        data() {
            return {
                delete_id: null,
                switch1: false,
                deleteDialog: false,
                loading: true,
                slots: [],
                title:'',
                headers: [
                    {
                        text: 'ID',
                        align: 'center',
                        sortable: false,
                        value: 'id',
                    },
                    {text: 'QR Code', align: 'center', value: 'generate'},
                    {text: 'Parking Number',  align: 'center',value: 'parking_number'},
                    {text: 'Department', align: 'center', value: 'department.name'},
                    {text: 'Type', align: 'center', value: 'type'},
                    {text: 'Slot For', align: 'center', value: 'slotFor'},
                    {text: 'Number of Reservations', align: 'center', value: 'reservations_count'},
                    {text: 'Status', align: 'center', value: 'status'},
                    {text: 'Actions',  align: 'center', value: 'action'},

                ],
                slot:{
                    parking_number: '',
                    department_id:'',
                    type:'',
                    slotFor:'',
                   
                },
                addition_edition_dailog: false,
                slotForm: {
                id:null,
                parking_number:'',
                department_id: '',
                type:'',
                slotFor:'',

                }

            }
        },
        mounted() {
           this.initialize()
        },

        methods: {
            initialize(){
                this.slotForm = {
                id:null,
                parking_number:'',
                department_id: '',
                type:'',
                slotFor:'',

                }
                this.$admin.get('/admin/v1/parking_slot/index').then(({data})=> {
                    this.slots = data
                    this.loading = false;
                })
            },  

            deleteSlot(id) {
                this.$admin.delete(`/admin/v1/parking_slot/delete/${id}`).then(({data}) => {
                        this.deleteDialog = false;
                        this.initialize()
                        this.successNotify('Deleted');
                    });
                
            },

            generate(id){
                this.$admin.get(`/admin/v1/parking_slot/qrImage/${id}`).then(({data}) => {
                    this.initialize()
                    this.successNotify('QR Code Generated');
                });
            },

            addSlot() {
                this.slotForm = {
                id:null,
                parking_number:'',
                department_id: '',
                type:'',
                slotFor:'',

                }
                this.addition_edition_dailog = true
            },

            editSlot(slot){
                this.slotForm = {
                    id:slot.id,
                    parking_number:slot.parking_number,
                    department_id:slot.department_id,
                    type:slot.type,
                    slotFor:slot.slotFor,
                    status:slot.status,
                }
                this.addition_edition_dailog = true
            },

            updateSlot() {
                if(this.slotForm.id){
                    this.$admin.post('admin/v1/parking_slot/update/'+this.slotForm.id,this.slotForm).then(({data}) => {
                        this.initialize()
                        this.successNotify('Updated');
                    })
                }
                else{
                    this.$admin.post('admin/v1/parking_slot/create',this.slotForm).then(({data}) =>{
                        this.initialize()
                        this.successNotify('Created');
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