<template>
  <v-row justify="center">
    <v-dialog
      v-model="adminManDialog"
      persistent
      max-width="25%"
    >
      <v-card>
        <v-card-title>
          <span class="text-h5">{{form.id ?'Edit' :'Add'}} Parking Slot</span>
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
                            <v-text-field
                                label="Parking Number"
                                required
                                v-model="form.parking_number"
                            ></v-text-field>

                            <v-select
                              :items="items"
                              label="Department "
                              item-text= "name"
                              item-value= "id"
                              v-model="form.department_id"
                              v-if="!fromDepartment"
                              
                            >
                            </v-select>

                            <v-select
                              :items="['Car', 'Motor']"
                              label="Type"
                              v-model="form.type"
                              
                            >
                            </v-select>

                            <v-select
                              :items="['Public', 'Guest']"
                              label="Slot For"
                              v-model="form.slotFor"
                              
                            >
                            </v-select>

                            <v-select
                              :items="status"
                              item-text="text"
                              item-value="id"
                              v-model="form.status"
                              v-if="form.id"
                            >
                            </v-select>
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
                parking_number:'',
                department_id: '',
                type: '',
                slotFor: ''
               
            }
        },
        fromDepartment: {
            type: Boolean,
            required: false
        },
    },
    data: () => ({
        show_pass : false,
        dialog: false,
        items:[],
        status:[
          { 
            id: 1,
            text: 'Available'
          },
          { 
            id: 2,
            text: 'Occupied'
          },
          { 
            id: 3,
            text: 'Reserved'
          },

        ]
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
            this.$admin.get('/admin/v1/department/index').then(({data})=> {
                this.items = data
    
            })
        },
    }  
  }
</script>