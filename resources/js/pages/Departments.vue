<template>
    <div class="products">
        <modal name="show" @closed ="departmentInitialState()"  height = 'auto'> 
            <div class="container"> 
                <form @submit.prevent="department.id ? updateDepartment(): addDepartment()" >
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="department.name">
                    </div>
                    <div class="form-group">
                        <label>Color</label>
                        <input type="text" class="form-control" v-model="department.color">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2" >{{department.id ? 'Update': 'Add'}} Department</button>
                </form>
            </div>
        </modal>
        <h3 class="text-center">Departments</h3>
        <button class="btn btn-primary" @click="modalShow()">Add</button>
        <div class="card mt-5">
            <div class="card-header">
            Department List
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table ">
                        <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Color</th>
                            <th>Number of Slots</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-center" v-for="department in departments" :key="department.id">
                            <td>{{ department.id }}</td>
                            <td>{{ department.name }}</td>
                            <td>{{ department.color }}</td>
                            <td>{{ department.parking_slots_count}}</td>
                            <td>
                                <div class="btn-group" role="group" style="gap: 5px">
                                    <button class="btn btn-primary" @click="modalShow(department)">Edit</button>
                                    <button class="btn btn-danger" @click="deleteDepartment(department.id)">Delete</button>
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
                departments: [],
                department:{
                    name: '',
                    color:'',
                },

            }
        },
        mounted() {
           this.initialize()
        },

        methods: {
            initialize(){
                this.$admin.get('/admin/v1/department/index').then(({data})=> {
                    this.departments = data
                })
            },  

            deleteDepartment(id) {
                this.$admin.delete(`/admin/v1/department/delete/${id}`).then(({id}) => {
                        this.initialize()
                    });
                
            },

            addDepartment() {
                this.$admin.post('/admin/v1/department/create', this.department).then(({data}) => {
                    this.initialize()
                    this.$modal.hide('show')

                })
            },
            
            updateDepartment() {
                this.$admin.post(`/admin/v1/department/update/${this.department.id}`, this.department).then(({data}) => {
                        this.initialize()
                        this.$modal.hide('show')
                    });
                
            },

            modalShow(department = null) {
                this.$modal.show('show')
                if (department != null){
                     this.department = {
                        id: department.id,
                        name: department.name,
                        color: department.color,
                    }
                }
            },

            departmentInitialState() {
                this.department = {
                    name: '',
                    color:'',
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