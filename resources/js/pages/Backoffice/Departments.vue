<template>
    <div class="mx-2 my-2">
        <v-card class="mx-auto px-5 pxy-5" outlined>
            <v-card-title class="font-weight-bold">
                Departments List
                <v-spacer></v-spacer>
                <v-icon
                    x-large 
                    @click="addDepartment"
                >
                    mdi-plus
                </v-icon>
            </v-card-title>
                <v-data-table
                        :headers="headers"
                        :items="departments"
                        :items-per-page="5"
                        :loading="loading"
                        class="elevation-1"
                >   
                   
                    
                    <template v-slot:item.action ="{ item }">
                        <v-icon class="mr-2" @click="$router.push('/department-view/'+item.id)">mdi-eye</v-icon>
                        <v-icon class="mr-2" @click="editDepartment(item)">mdi-pencil</v-icon>
                        <v-icon @click="deleteDialog = true, delete_id = item.id">mdi-delete</v-icon>
                    </template>
                </v-data-table>
        </v-card>
        <DepartmentForm :form="departmentForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,updateDepartment()" />
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
                            @click="deleteDepartment(delete_id), delete_id = null"
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
  import DepartmentForm from '../../components/adminForms/Department.vue'

    export default {
        components: {
            DepartmentForm
        },
        data() {
            return {
                deleteDialog: false,
                delete_id: null,
                loading: true,
                departments: [],
                title:'',
                headers: [
                    {
                        text: 'ID',
                        align: 'center',
                        sortable: false,
                        value: 'id',
                    },
                    {text: 'Name',  align: 'center',value: 'name'},
                    {text: 'Color', align: 'center', value: 'color'},
                    {text: 'Number of Slots', align: 'center', value: 'parking_slots_count'},
                    {text: 'Actions',  align: 'center', value: 'action'},

                ],
                department:{
                    name: '',
                    color:'',
                   
                },
                addition_edition_dailog: false,
                departmentForm: {
                id:null,
                name:'',
                color: '',
                }

            }
        },
        mounted() {
           this.initialize()
        },

        methods: {
            initialize(){
                this.departmentForm = {
                id:null,
                name:'',
                color: '',
                }
                this.$admin.get('/admin/v1/department/index').then(({data})=> {
                    this.departments = data
                    this.loading = false;
                })
            },  

            deleteDepartment(id) {
                this.$admin.delete(`/admin/v1/department/delete/${id}`).then(({data}) => {
                        this.deleteDialog = false;
                        this.initialize()
                    });
                
            },

            addDepartment() {
                this.departmentForm = {
                id:null,
                name:'',
                color: '',
                }
                this.addition_edition_dailog = true
            },

            editDepartment(department){
            this.departmentForm = {
                id:department.id,
                name:department.name,
                color:department.color ,
            }
            this.addition_edition_dailog = true
             },

            updateDepartment() {
                if(this.departmentForm.id){
                    this.$admin.post('admin/v1/department/update/'+this.departmentForm.id,this.departmentForm).then(({data}) => {
                        this.initialize()
                    })
                }
                else{
                    this.$admin.post('admin/v1/department/create',this.departmentForm).then(({data}) =>{
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