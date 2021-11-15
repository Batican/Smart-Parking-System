<template>
    <div class="products">
        <modal name="show" @closed ="userInitialState()"  height = 'auto'> 
            <div class="container"> 
                <form @submit.prevent="user.id ? updateUser(): addUser()" >
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="user.name">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" v-model="user.email">
                    </div>
                    <div class="form-group" v-if="!user.id">
                        <label>Password</label>
                        <input type="text" class="form-control" v-model="user.password">
                    </div>
                    <div class="form-group">
                        <label>RFID Number</label>
                        <input type="text" class="form-control" v-model="user.rfid_number">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2" >{{user.id ? 'Update': 'Add'}} User</button>
                </form>
            </div>
        </modal>
        <h3 class="text-center">Users</h3>
        <button class="btn btn-primary" @click="modalShow()">Add</button>
        <div class="card mt-5">
            <div class="card-header">
                User List
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table ">
                        <thead>
                            <tr class="text-center">
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>RFID Number</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center" v-for="user in users" :key="user.id">
                                <td>{{ user.id }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.rfid_number }}</td>
                                <td>
                                    <div class="btn-group" role="group" style="gap: 5px">
                                        <button class="btn btn-primary" @click="modalShow(user)">Edit</button>
                                        <button class="btn btn-danger" @click="deleteUser(user.id)">Delete</button>
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
                users: [],
                user:{
                    name: '',
                    email:'',
                    password:'',
                    rfid_number:''
                },

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
            },  

            deleteUser(id) {
                this.$admin.delete(`/admin/v1/user/delete/${id}`).then(({id}) => {
                        this.initialize()
                    });
                
            },

            addUser() {
                this.$admin.post('/admin/v1/user/create', this.user).then(({data}) => {
                    this.initialize()
                    this.$modal.hide('show')
                })
            },

            updateUser() {
                this.$admin.post(`/admin/v1/user/update/${this.user.id}`, this.user).then(({data}) => {
                        this.initialize()
                        this.$modal.hide('show')
                    });
                
            },

            modalShow(user = null) {
                this.$modal.show('show')
                if (user != null){
                     this.user = {
                        id: user.id,
                        name: user.name,
                        email: user.email,
                        rfid_number: user.rfid_number
                    }
                }
            },

            userInitialState() {
                this.user = {
                    name: '',
                    email:'',
                    password:'',
                    rfid_number:''
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