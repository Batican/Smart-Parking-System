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

                            <v-text-field
                                label="Department ID"
                                required
                                v-model="form.department_id"
                            ></v-text-field>
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
               
            }
        }
    },
    data: () => ({
        show_pass : false,
        dialog: false,
    }),
    computed : {
        adminManDialog(){
            return this.dialogState
        }
    }
    
  }
</script>