<template>
  <v-container>
    <v-row justify="space-around">
      <v-card width="100%" color="#e1ad01">
        <div class="d-flex justify-content-between my-7 mx-5">

          <div class="black--text d-flex  mt-5">
            <v-avatar size="100" >
                <v-img :src="user.image ? '/storage/'+user.image :'https://scontent.fceb1-2.fna.fbcdn.net/v/t1.6435-9/241439838_4465586350227792_3670855029139333701_n.jpg?_nc_cat=111&ccb=1-5&_nc_sid=09cbfe&_nc_eui2=AeF3vyn6YvL9o1RF9fGnpHCjWVrCGOG7wZFZWsIY4bvBkcuCY4vL-sgWetXe4FVS5q5nvK7CV6lfTNWNPwxOaLee&_nc_ohc=F9LuBllnMx8AX9eLgoc&_nc_ht=scontent.fceb1-2.fna&oh=8611d72f1b6b04d769a3f1436724f47f&oe=616A7C39'"></v-img>
            </v-avatar>
            <div>
                <div class="d-flex ">
                    <p class="ml-3 font-weight-bold">
                        ID: {{user.id}}
                    </p>
               
                </div>
                <p class="ml-3 mb-0 pt-0 font-weight-bold">
                  Name: {{user.name}}
                </p>
                <p class="ml-3 mb-0 pt-0 font-weight-bold">
                  Email: {{user.email}}
                </p>
                <p class="ml-3 mb-0 pt-0 font-weight-bold">
                  RFID Number: {{user.rfid_number}}
                </p>
                <p class="ml-3 mb-0 pt-0 font-weight-bold">
                  Current Reservation Count: {{user.reservations_count}}
                </p>
            </div>
          </div>
          <!-- <v-btn
            @click="editUser(user)"
            icon
            x-large
          >
            <v-icon dark color="black">
              mdi-pencil
            </v-icon>
          </v-btn> -->
        </div>
        <v-divider elevation="10"></v-divider>
          <v-card-title class="font-weight-bold">
            Reservations
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
              <template v-user:item.action ="{ item }">
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
    <UserForm :fromDepartment="true" :form="slotForm" :dialogState="updateDialog" @close="updateDialog = false" @save="updateDialog = false,updateUser()" />
    <ReservationForm :fromReservation='true' :form="reservationForm" :dialogState="addDialog" @close="addDialog = false" @save="addDialog = false,updateReservation()" />

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
                      @click="deleteUser(delete_id), delete_id = null"
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
  import UserForm from '../../components/adminForms/User.vue'
  import ReservationForm from '../../components/adminForms/Reservation.vue'

    export default {
      components : {
            ReservationForm,
            UserForm
      },
      data() {
        return {
          delete_id: null,
          deleteDialog: false,
          user: {},
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
            {text: 'Parking Slot ID', align: 'center', value: 'slot_id'},
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
              this.$admin.get('/admin/v1/user/show/'+this.$route.params.id).then(({data}) => {
                  this.user = data
                  this.reserve = data.reservations

                  this.slotForm = {

                      id: user.id,
                      name: user.name,
                      email: user.email,
                      rfid_number: user.rfid_number,
                      reservations_count: user.reservations_count,
                      image: '/storage/'+user.image,
                  }

              })
          },

          editUser(user){
            this.slottForm = {
                id: user.id,
                name: user.name,
                email: user.email,
                rfid_number: user.rfid_number,
                password: '',
                reservations_count: user.reservations_count,
                image: '/storage/'+user.image,
            }
            this.updateDialog = true
          },
          
          addReservation(user) {
                this.reservationForm = {
                id:null,
                slot_id:'',
                user_id: user.id,
                date:(new Date()).toISOString().split('T')[0],
                }
                this.addDialog = true
          },

          deleteReservation(id) {
                this.$admin.delete(`/admin/v1/reservation/delete/${id}`).then(({data}) => {
                        this.deleteDialog = false;
                        this.initialize()
                        this.successNotify('Deleted');

                    });
                
            },

          updateReservation(){
              this.$admin.post('/admin/v1/reservaion/create',this.reservationForm).then(({data}) =>{
                  this.initialize()
                  this.successNotify('Created');

              })
               
          },

          updateUser() {
            this.$admin.post('/admin/v1/user/update/'+this.$route.params.id,this.slotForm).then(({data}) => {
                this.initialize()
                this.successNotify('Updated');

            })
                
          },

      }
  }
</script>