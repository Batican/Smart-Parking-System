<template>
  <v-container>
    <v-row justify="space-around">
      <v-card width="100%" color="#e1ad01">
        <div class="d-flex justify-content-between my-7 mx-5">

          <div class="black--text d-flex  mt-5">
            <v-avatar size="100" >
                <v-icon size="100" color="black" dark>mdi-bus-stop</v-icon>
            </v-avatar>
            <div>
                <div class="d-flex ">
                    <p class="ml-3 font-weight-bold">
                        Department: {{slot.department.name}}
                    </p>
               
                </div>
                <p class="ml-3 mb-0 pt-0 font-weight-bold">
                  ID: {{slot.id}}
                </p>
                <p class="ml-3 mb-0 pt-0 font-weight-bold">
                  Parking Number: {{slot.parking_number}}
                </p>
                <p class="ml-3 mb-0 pt-0 font-weight-bold">
                  Type: {{slot.type}}
                </p>
                <p class="ml-3 mb-0 pt-0 font-weight-bold">
                  Current Reservation Count: {{slot.reservations_count}}
                </p>
            </div>
          </div>
          <v-btn
            @click="editSlot(slot)"
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
            <v-btn  @click="addReservation(slot)" class="white--text ma-2" dark small>
              <v-icon>mdi-plus</v-icon>
              Add Reservation
            </v-btn>
          </v-card-title>
          <v-card-text>
             <v-data-table
              :items-per-page='5'
              dense
              :headers="headers"
              :items="reserve"
              item-key="name"
              class="elevation-1"
            >
              <template v-slot:item.action ="{ item }">
                  <v-icon class="mr-2"  @click="editSlot(item)">mdi-pencil</v-icon>
                  <v-icon @click="deleteDialog = true, delete_id = item.id">mdi-delete</v-icon>
              </template>
            </v-data-table>
          </v-card-text>
            <v-spacer></v-spacer>
              <div class="d-flex justify-end mb-5 mr-5">
              <v-btn color="black" outlined @click="$router.back()"> 
                <v-icon left dark>mdi-logout</v-icon>
                Back</v-btn>
              </div>
      </v-card>
    </v-row>
    <SlotForm :fromDepartment="true" :form="slotForm" :dialogState="updateDialog" @close="updateDialog = false" @save="updateDialog = false,updateSlot()" />
    <ReservationForm :form="reservationForm" :dialogState="addDialog" @close="addDialog = false" @save="addDialog = false,updateReservation()" />

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
  </v-container>
</template>
<script>
  import SlotForm from '../../components/adminForms/ParkingSlot.vue'
  import ReservationForm from '../../components/adminForms/Reservation.vue'

    export default {
      components : {
            ReservationForm,
            SlotForm
      },
      data() {
        return {
          delete_id: null,
          deleteDialog: false,
          slot: {},
          reservationForm : {},
          slotForm:{},
          updateDialog: false,
          addDialog: false,

          reserve: [],
          headers: [
            {
              text: 'ID',
              align: 'center',
              sortable: false,
              value: 'id',
            },
            {text: 'User ID', align: 'center', value: 'user_id'},
            {text: 'Date', align: 'center', value: 'date'},
            {text: 'Actions',  align: 'center', value: 'action'},
          ],
        }
      },
      
      mounted () {
          this.initialize()
      },
      methods : { 
          initialize(){
              this.$admin.get('/admin/v1/parking_slot/show/'+this.$route.params.id).then(({data}) => {
                  this.slot = data
                  this.reserve = data.reservations

                  this.slotForm = {

                      id: slot.id,
                      parking_number: slot.parking_number,
                      reservations_count: slot.reservations_count,
                  }

              })
          },

          editSlot(slot){
            this.slottForm = {
                id:slot.id,
                parking_number:slot.parking_number,
            }
            this.updateDialog = true
          },
          
          addReservation(slot) {
                this.reservationForm = {
                id:null,
                user_id:'',
                slot_id: slot.id,
                date:(new Date()).toISOString().split('T')[0],
                }
                this.addDialog = true
          },

          editReservation(reservation){
            this.reservationForm = {
                id:reservation.id,
                user_id:reservation.user_id,
                slot_id:reservation.slot_id,
                date:reservation.date,
            }
            this.addDialog = true
          },

          deleteReservation(id) {
                this.$admin.delete(`/admin/v1/reservation/delete/${id}`).then(({data}) => {
                        this.deleteDialog = false;
                        this.initialize()
                    });
                
            },

          updateReservation(){
            if(this.slotForm.id){
              this.$admin.post('/admin/v1/reservation/update/'+this.reservationForm.id,this.reservationForm).then(({data}) => {
                  this.initialize()
              })
            }
            else{
              this.$admin.post('/admin/v1/reservaion/create',this.reservationForm).then(({data}) =>{
                  this.initialize()
              })
            }     
          },

          updateSlot() {
            this.$admin.post('/admin/v1/parking_slot/update/'+this.$route.params.id,this.slotForm).then(({data}) => {
                this.initialize()
            })
                
          },

      }
  }
</script>