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

                            <v-select
                              :items="['student','teacher']"
                              label="Type of User"
                              v-model="form.type"
                            >
                            </v-select>

                            <v-text-field
                                label="RFID Number"
                                required
                                type="number"
                                v-model="form.rfid_number"
                            ></v-text-field>

                            <v-text-field
                                label="Password"
                                required
                                v-model="form.password"
                                :type="show_pass ? 'text' : 'password'"
                                :append-icon="show_pass ? 'mdi-eye' : 'mdi-eye-off'"
                                @click:append="show_pass = !show_pass"
                            ></v-text-field>
                        </v-col>
                        <v-col
                            cols="6"
                            sm="6"
                            md="6"
                        >   
                            <v-img
                                lazy-src="https://thumbs.dreamstime.com/b/default-avatar-profile-icon-vector-social-media-user-portrait-176256935.jpg"
                                max-height="250"
                                max-width="250"
                                height="200"
                                :src="form.image ? form.image : 'https://cdn.vuetifyjs.com/images/parallax/material2.jpg'"
                            ></v-img>
                            <v-btn 
                                icon 
                                large
                                color="light-black" 
                                @click="$refs.inputUpload.click()"  
                            > 
                                <v-icon left >mdi-image-plus</v-icon>
                            </v-btn>
                            <input v-show="false" ref="inputUpload" type="file" @change="processImage" >
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
                image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',

            }
        }
    },
    data: () => ({
        show_pass : false,
        dialog: false,
    }),

    methods : {
      processImage(e){
    
        var fileReader = new FileReader()
        fileReader.readAsDataURL(e.target.files[0])
        fileReader.onload = (e) => {
          this.form.image = e.target.result
        }
      },
    },
    computed : {
        adminManDialog(){
            return this.dialogState
        }
    }
    
  }
</script>