<template>
  <v-container>
    <v-row justify="space-around">
      <v-card width="100%" color="#e1ad01">
        <div class="d-flex justify-content-between my-7 mx-5">

          <div class="black--text d-flex  mt-5">
            <v-avatar size="100" >
                <v-icon size="200" color="red" dark>mdi-alpha-a-box</v-icon>
            </v-avatar>
            <div>
                <div class="d-flex ">
                    <p class="ml-3 font-weight-bold">
                        Name: {{department.name}}
                    </p>
               
                </div>
                <p class="ml-3 mb-0 pt-0 font-weight-bold">
                Color : {{department.color}}
                </p>
                <p class="ml-3 mb-0 pt-0 font-weight-bold">
                Current Parking Slot Count: {{department.parking_slots_count}}
                </p>
            </div>
          </div>
          <v-btn
            @click="editDepartment(department)"
            icon
            x-large
          >
            <v-icon dark color="black">
              mdi-pencil
            </v-icon>
          </v-btn>
        </div>
        <v-divider elevation="10"></v-divider>
          <v-card-title class="font-weight-bold">
            Parking Slots
            <v-spacer></v-spacer>
            <v-btn  @click="addSlot(department)" class="white--text ma-2" dark small>
              <v-icon>mdi-plus</v-icon>
              Add Parking Slot
            </v-btn>
          </v-card-title>
          <v-card-text>
             <v-data-table
              :items-per-page='5'
              dense
              :headers="headers"
              :items="slots"
              item-key="name"
              class="elevation-1"
            >
              <template v-slot:item.status ="{ item }">
                        {{item.status == 1 ? 'Available' : item.status == 2 ? 'Occupied': 'Reserved'}}
              </template>

              <template v-slot:item.action ="{ item }">
                  <v-icon class="mr-2">mdi-pencil</v-icon>
                  <v-icon>mdi-delete</v-icon>
              </template>
            </v-data-table>
          </v-card-text>
          
      </v-card>
    </v-row>
    <SlotForm :form="slotForm" :dialogState="addDialog" @close="addDialog = false" @save="addDialog = false,updateSlot()" />
    <DepartmentForm :form="departmentForm" :dialogState="updateDialog" @close="updateDialog = false" @save="updateDialog = false,updateDepartment()" />
  </v-container>
</template>
<script>
  import DepartmentForm from '../../components/adminForms/Department.vue'
  import SlotForm from '../../components/adminForms/ParkingSlot.vue'

    export default {
      components : {
            DepartmentForm,
            SlotForm
      },
      data() {
        return {
          department: {},
          departmentForm : {},
          slotForm:{},
          updateDialog: false,
          addDialog: false,

          slots: [],
          headers: [
            {
              text: 'ID',
              align: 'center',
              sortable: false,
              value: 'id',
            },
            {text: 'QR Code', align: 'center', value: 'generate'},
            {text: 'Parking Number',  align: 'center',value: 'parking_number'},           
            {text: 'Status', align: 'center', value: 'status'},
            {text: 'Actions', align: 'center', value: 'action'},
          ],
        }
      },
      
      mounted () {
          this.initialize()
      },
      methods : { 
          initialize(){
              console.log(this.$route.params.id);
              this.$admin.get('/admin/v1/department/show/'+this.$route.params.id).then(({data}) => {
                  this.department = data
                  this.slots = data.parking_slots

                  this.departmentForm = { 
                      id: department.id,
                      name: department.name,
                      color: department.color,
                      parking_slots_count: department.parking_slots_count,
                  }

              })
          },

          editDepartment(department){
            this.departmentForm = {
                id:department.id,
                name:department.name,
                color:department.color ,
            }
            this.updateDialog = true
          },
          
          addSlot(department) {
                this.slotForm = {
                id:null,
                parking_number:'',
                department_id: department.id,
                }
                this.addDialog = true
            },

          updateSlot(){
            this.$admin.post('/admin/v1/parking_slot/create',this.slotForm).then(({data}) =>{
                this.initialize()
            })
          },

          updateDepartment() {
            this.$admin.post('/admin/v1/department/update/'+this.$route.params.id,this.departmentForm).then(({data}) => {
                this.initialize()
            })
                
          }
      }
  }
</script>