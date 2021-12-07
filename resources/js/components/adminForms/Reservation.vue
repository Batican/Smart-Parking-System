<template>
  <v-row justify="center">
    <v-dialog
      v-model="adminManDialog"
      persistent
      max-width="25%"
    >
      <v-card>
        <v-card-title>
          <span class="text-h5">{{form.id ?'Edit' :'Add'}} Reservation</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col      
                  cols="12"
                  sm="12"
                  md="12"
              >
                  <v-row>
                      <v-col
                          cols="6"
                          sm="12"
                          md="12"
                      >
                        <v-autocomplete
                          v-model="form.user_id"
                          :items="users"
                          item-text="name"
                          item-value="id"
                          label="User"
                          hide-no-data
                        ></v-autocomplete>

                        <v-select
                          :items="slots"
                          label="Parking Slot Number "
                          item-text= "parking_number"
                          item-value= "id"
                          v-model="form.slot_id"
                          v-if="!fromReservation"
                        >
                        </v-select>

                        <v-menu
                          v-model="date_pick"
                          :close-on-content-click="false"
                          :nudge-right="40"
                          transition="scale-transition"
                          offset-y
                          min-width="auto"
                        >
                          <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                              v-model="form.date"
                              label="Date"
                              prepend-icon="mdi-calendar"
                              readonly
                              color="light-blue"
                              v-bind="attrs"
                              v-on="on"
                            ></v-text-field>
                          </template>
                          <v-date-picker
                            color="light-blue"
                            v-model="form.date"
                            @input="date_pick = false"
                          ></v-date-picker>
                        </v-menu>  
                      </v-col>
                    </v-row>
                </v-col>
            </v-row>
          </v-container>
       
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="$emit('save')"
          >
            Save
          </v-btn>
          <v-btn
             color="error"
            text
            @click="$emit('close')"
          >
            Close
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
  export default {
    props: {
        dialogState: {
            type: Boolean,
            required: true
        },
        form: {
            type: Object,
            required: true,
            default: {
                id:null,
                user_id:'',
                slot_id: '',
                date: '',
               
            }
        },
        fromReservation: {
            type: Boolean,
            required: false
        },
    },
    data: () => ({
        show_pass : false,
        dialog: false,
        users: [],
        slots: [],
        date_pick: false,
      
    }),

    computed : {
        adminManDialog(){
            return this.dialogState
        }
    },

    mounted() {
      this.initialize()
    },

    methods: {
        initialize(){    
            this.$admin.get('/admin/v1/user/index').then(({data})=> {
                this.users = data
            })

            this.$admin.get('/admin/v1/parking_slot/index').then(({data})=> {
                this.slots = data
            })
        },
    }  
  }
</script>