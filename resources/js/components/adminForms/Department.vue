<template>
  <v-row justify="center">
    <v-dialog
      v-model="adminManDialog"
      persistent
      max-width="25%"
    >
      <v-card>
        <v-card-title>
          <span class="text-h5">{{form.id ?'Edit' :'Add'}} Department</span>
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
                            v-model="form.name"
                            :items="departments"
                            :filter="customFilter"
                            item-text="name"
                            label="Department Name"
                            hide-no-data
                            @change="(event)=>change(event)"
                            return-object
                          ></v-autocomplete>

                          <v-text-field
                              label="Abbreviation"
                              required
                              v-model="form.abbreviation"
                          ></v-text-field>

                          <v-text-field
                              label="Color"
                              required
                              v-model="form.color"
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
                color: '',
            }
        }
    },
    data: () => ({
        show_pass : false,
        dialog: false,
        loading: false,
        departments: [
          {name:'College of Art and Science ', abbr:'CAS'},
          {name:'College of Education ', abbr:'COE'},
          {name:'College of Engineering and Technology ', abbr:'CET'},
          {name:'College of Information Technology ', abbr:'CIT'},
          {name:'College of Management ', abbr:'COM'},
          
          
          

          
        ]
    }),
    computed : {
        adminManDialog(){
            return this.dialogState
        }
    },
    

    methods: {
      customFilter (item, queryText, itemText) {
        const textOne = item.name.toLowerCase()
        const textTwo = item.abbr.toLowerCase()
        const searchText = queryText.toLowerCase()

        return textOne.indexOf(searchText) > -1 ||
          textTwo.indexOf(searchText) > -1
      },
      change(department){
        this.form.abbreviation = department.abbr
        this.form.name = department.name
      }

    },
  }
</script>
