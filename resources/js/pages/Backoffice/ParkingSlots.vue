<template>
    <div class="products">
        <modal name="show" @closed ="slotInitialState()"  height = 'auto'> 
            <div class="container"> 
                <form @submit.prevent="slot.id ? updateSlot(): addSlot()" >
                    <!-- <div class="form-group">
                        <label>QR Code</label>
                        <input type="text" class="form-control" v-model="slot.qr_code">
                    </div> -->
                    <div class="form-group">
                        <label>Parking Number</label>
                        <input type="text" class="form-control" v-model="slot.parking_number">
                    </div>
                    <div class="form-group" >
                        <label>Department ID</label>
                        <input type="text" class="form-control" v-model="slot.department_id">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2" >{{slot.id ? 'Update': 'Add'}} Parking Slot</button>
                </form>
            </div>
        </modal>
        <h3 class="text-center">Parking Slots</h3>
        <button class="btn btn-primary" @click="modalShow()">Add</button>
        <div class="card mt-5">
            <div class="card-header">
            Parking Slot List
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table ">
                        <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>QR Code</th>
                            <th>Parking Number</th>
                            <th>Department</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-center" v-for="slot in slots" :key="slot.id">
                            <td>{{ slot.id }}</td>
                            <td>
                                <router-link :to="{name: 'qr_code', params: { id: slot.id }}" class="btn btn-primary">Generate
                                </router-link>
                            </td>
                            <td>{{ slot.parking_number }}</td>
                            <td>{{ slot.department.name }}</td>
                            <td>
                                <div class="btn-group" role="group" style="gap: 5px">
                                    <button class="btn btn-primary" @click="modalShow(slot)">Edit</button>
                                    <button class="btn btn-danger" @click="deleteSlot(slot.id)">Delete</button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                slots: [],
                slot:{
                    // qr_code:'',
                    parking_number:'',
                    department_id:''
                },

            }
        },
        mounted() {
           this.initialize()
        },

        methods: {
            initialize(){
                this.$admin.get('/admin/v1/parking_slot/index').then(({data})=> {
                    this.slots = data
                })
            },  

            deleteSlot(id) {
                this.$admin.delete(`/admin/v1/parking_slot/delete/${id}`).then(({id}) => {
                        this.initialize()
                    });
                
            },

            addSlot() {
                this.$admin.post('/admin/v1/parking_slot/create', this.slot).then(({data}) => {
                    this.initialize()
                })
            },

            updateSlot() {
                this.$admin.post(`/admin/v1/parking_slot/update/${this.slot.id}`, this.slot).then(({data}) => {
                        this.initialize()
                        this.$modal.hide('show')
                    });
                
            },

            modalShow(slot = null) {
                this.$modal.show('show')
                if (slot != null){
                     this.slot = {
                        id: slot.id,
                        // qr_code: slot.qr_code,
                        parking_number: slot.parking_number,
                        department_id: slot.department_id
                    }
                }
            },

            slotInitialState() {
                this.slot = {
                    // qr_code: '',
                    parking_number:'',
                    department_id:'',
                }
            },

        }
    }
    
</script>

<style scoped>
h3{
  text-align: center;
  margin-top: 30px;
  margin-bottom: 20px;
}
.icon{
  margin-right: 10px;
}
.icon i{
  cursor: pointer;
}
</style>