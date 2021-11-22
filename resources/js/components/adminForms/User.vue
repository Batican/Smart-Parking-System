<template>
  <v-row justify="center">
    <v-dialog
      v-model="adminManDialog"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-card-title>
          <span class="text-h5">{{form.id ?'Edit' :'Add'}} User</span>
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
                            sm="6"
                            md="6"
                        >
                            <v-text-field
                                label="Name"
                                required
                                v-model="form.name"
                            ></v-text-field>

                            <v-text-field
                                label="Email"
                                required
                                v-model="form.email"
                            ></v-text-field>
                        </v-col>
                        <v-col
                            cols="6"
                            sm="6"
                            md="6"
                        >
                            <v-text-field
                                label="RFID Number"
                                required
                                type="number"
                                v-model="form.rfid_number"
                            ></v-text-field>

                            <v-text-field
                                v-if="form.id == '' || form.id == null"
                                label="Password"
                                required
                                v-model="form.password"
                                :type="show_pass ? 'text' : 'password'"
                                :append-icon="show_pass ? 'mdi-eye' : 'mdi-eye-off'"
                                @click:append="show_pass = !show_pass"
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
                name:'',
                email: '',
                password: '',
                rfid_number: '',
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