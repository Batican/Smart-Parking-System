<template>
    <v-container>
    <v-row>
        <v-card width="100%" color="#e1ad01">
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
                            <div class="mt-10 mb-10 ml-10" v-html="qr_code"></div>
                        </v-col>
                        <v-col
                            cols="6"
                            sm="6"
                            md="6"
                            class="mt-10 "
                        >   
                            <h3>
                                DETAILS:
                            </h3>
                            <p class="ml-5 font-weight-bold">
                                ID: {{slot.id}}
                            </p>
                            <p class="ml-5 font-weight-bold">
                                PARKING NUMBER: {{slot.parking_number}}
                            </p>
                            <p class="ml-5 font-weight-bold">
                                DEPARTMENT: {{slot.department.name}}
                            </p>
                            <p class="ml-5 font-weight-bold">
                                STATUS: {{slot.status == 1 ? 'Available' : slot.status == 2 ? 'Occupied' : 'Reserved'}}
                            </p>
                            
                            <v-divider />
                            <v-list-item
                                color="secondary"
                                @click="$router.back()"
                            >
                                <v-list-item-icon>
                                    <v-icon>mdi-logout</v-icon>
                                </v-list-item-icon>

                                <v-list-item-content>
                                    <v-list-item-title>Back</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-card>
    </v-row>
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                qr_code: {},
                slot:{}
            }
            
        },

        mounted(){
            this.generate()
            this.initialize()
        },

        methods: {
            generate(){
                this.$admin.get(`/admin/v1/parking_slot/qrcode/${this.$route.params.id}`).then(({data}) => {
                    this.qr_code = data
                });
            },

            initialize(){
                this.$admin.get('/admin/v1/parking_slot/show/'+this.$route.params.id).then(({data})=>{
                    this.slot = data
                });
            }

        }
    }
</script>