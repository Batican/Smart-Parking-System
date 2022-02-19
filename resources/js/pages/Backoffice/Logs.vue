<template>
    <div class="mx-2 my-2">
        <v-card class="mx-auto px-5 pxy-5" outlined>
            <v-card-title class="font-weight-bold">
                Reservation List
                <v-spacer></v-spacer>
                <v-icon
                    x-large 
                    @click="addReservation"
                >
                    mdi-plus
                </v-icon>
            </v-card-title>
                <v-data-table
                        :headers="headers"
                        :items="reservations"
                        :items-per-page="5"
                        :loading="loading"
                        class="elevation-1"
                >   
                   
                    <template v-slot:item.generate ="{ item }">
                        <v-btn x-small class="btn btn-primary mr-2" @click="$router.push('/qr_code/'+ item.id)">Show</v-btn>
                        <v-btn v-if="!item.qrCode_path" x-small color="teal" outlined @click="generate(item.id)">Generate</v-btn>

                    </template>

                    <template v-slot:item.status ="{ item }">
                        {{item.status == 1 ? 'Available' : item.status == 2 ? 'Occupied': 'Reserved'}}
                    </template>
                    
                    <template v-slot:item.action ="{ item }">
                        <v-icon @click="deleteDialog = true, delete_id = item.id">mdi-delete</v-icon>
                    </template>
                </v-data-table>
        </v-card>
        <ReservationForm :form="reservationForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,updateReservation()" />
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
                            @click="deleteReservation(delete_id), delete_id = null"
                        >
                            Delete
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </div>
</template>
