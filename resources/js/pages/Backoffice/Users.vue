<template>
    <div class="mx-2 my-2">
        <v-card class="mx-auto px-5 pxy-5" outlined>
            <v-card-title class="font-weight-bold">
                Users List
                <v-spacer></v-spacer>
                <v-btn class="mr-5" color="success"  @click="importDialog = true">
                    Import Data
                </v-btn>
                <v-icon
                    x-large 
                    @click="addUser"
                >
                    mdi-account-plus
                </v-icon>
            </v-card-title>
                <v-data-table
                        :headers="headers"
                        :items="users"
                        :items-per-page="5"
                        :loading="loading"
                        class="elevation-1"
                >   
                    <template v-slot:item.image="{ item }">
                        <v-avatar color="#e1ad01">
                            <img v-if="item.image"
                                :src="'/storage/' + item.image"
                            >
                            <v-icon v-else dark>
                                mdi-account-tie
                            </v-icon>
                        </v-avatar>
                    </template>
                    <template v-slot:item.action ="{ item }">
                        <v-icon class="mr-2" @click="$router.push('/user-view/'+item.id)">mdi-eye</v-icon>
                        <v-icon class="mr-2" @click="editUser(item)">mdi-pencil</v-icon>
                        <v-icon @click="deleteDialog = true, delete_id = item.id">mdi-delete</v-icon>
                    </template>
                </v-data-table>
        </v-card>
        <UserForm :form="userForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,updateUser()" />
        
        <!-- Delete Dialog -->
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
                            @click="deleteDialog = false, delete_id = null"
                        >
                            Cancel
                        </v-btn>
                        <v-btn
                            color="error"
                            text
                            @click="deleteUser(delete_id), delete_id = null"
                            
                        >
                            Delete
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>

        <!-- Import Dialog -->
        <v-row justify="center">
            <v-dialog
                v-model="importDialog"
                persistent
                max-width="400"
            >
                <v-card>
                    <v-card-title  style="font-weight:bold; color:black;">
                        Import CSV
                        <v-spacer></v-spacer>
                            <v-icon @click="importDialog = false" >
                                mdi-close-circle-outline
                            </v-icon>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-actions>
                       <form action="import" method="POST" enctype="multipart/form-data">
     
                            <div class="input-group mb-3">
                                <input type="file" name="file" class="form-control">
                                
                                <button class="btn btn-primary ml-2" type="submit">Submit</button>
                            </div>
                        </form>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </div>
</template>

<script>
  import UserForm from '../../components/adminForms/User.vue'

    export default {
        components: {
            UserForm
        },
        data() {
            return {
                deleteDialog: false,
                importDialog: false,
                loading: true,
                users: [],
                delete_id: null,
                title:'',
                headers: [
                    {
                        text: 'ID',
                        align: 'center',
                        sortable: false,
                        value: 'id',
                    },
                    { text: "Image", value: "image" },
                    {text: 'First Name', value: 'first_name'},
                    {text: 'Last Name', value: 'last_name'},
                    {text: 'Type of User', value: 'type'},
                    {text: 'Vehicle Owned', value: 'vehicle'},
                    {text: 'Email', value: 'email'},
                    {text: 'RFID Number', value: 'rfid_number'},
                    {text: 'Actions', value: 'action'},

                ],
                user:{
                    first_name: '',
                    last_name: '',
                    type:'',
                    vehicle:'',
                    email:'',
                    password:'',
                    rfid_number:'',
                    image:''
                },
                addition_edition_dailog: false,
                userForm: {
                id:null,
                first_name:'',
                last_name:'',
                type:'',
                vehicle:'',
                email: '',
                rfid_number: '',
                password: '',
                image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',

                }

            }
        },
        mounted() {
           this.initialize()
        },

        methods: {
            initialize(){
                this.userForm = {
                id:null,
                first_name:'',
                last_name:'',
                type:'',
                vehicle:'',
                email: '',
                rfid_number: '',
                password: '',
                image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',

                }
                this.$admin.get('/admin/v1/user/index').then(({data})=> {
                    this.users = data
                    this.loading = false;
                })
            },  

            deleteUser(id) {
                this.$admin.delete(`/admin/v1/user/delete/${id}`).then(({data}) => {
                        this.deleteDialog = false;
                        this.initialize()
                        this.successNotify('Deleted');
                    });
                
            },

            addUser() {
                this.userForm = {
                id:null,
                first_name:'',
                last_name:'',
                vehicle:'',
                type:'',
                email: '',
                rfid_number: '',
                password: '',
                image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',

                }
                this.addition_edition_dailog = true
            },

            editUser(user){
                this.userForm = {
                    id:user.id,
                    first_name:user.first_name,
                    last_name:user.last_name,
                    type:user.type,
                    vehicle:user.vehicle,
                    email:user.email ,
                    rfid_number:user.rfid_number ,
                    password: '',
                    image: '/storage/'+user.image,
                    
                }
                this.addition_edition_dailog = true
             },

            updateUser() {
                if(this.userForm.id){
                    this.$admin.post('admin/v1/user/update/'+this.userForm.id,this.userForm).then(({data}) => {
                        this.initialize()
                        this.successNotify('Updated');
                    })
                }
                else{
                    this.$admin.post('admin/v1/user/create',this.userForm).then(({data}) =>{
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