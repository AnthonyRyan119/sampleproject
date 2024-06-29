<template>
    <div class="container-fluid p-0">
        <header class="page-header page-header-dark pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i class="fa-regular fa-user"></i></div>
                                User Management
                            </h1>
                            <!-- <div class="page-header-subtitle">Use this blank page as a starting point for creating new pages inside your project!</div> -->
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-n10">
            <div class="container p-4 rounded shadow bg-white">
                <!-- Header -->
                <div class="row">
                    <div class="col-xl col-lg col-md col-sm-6 col-xs-6 mb-2">
                        <b-form-select
                            class="text-dark"
                            style="max-width:80px;"
                            v-model="users.per_page"
                            :options="$page_options"
                            required
                        ></b-form-select>&nbsp;
                        <label class="text-md"> entries per page</label>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-xs-6 mb-2">
                        <button class="btn btn-sm btn-light text-success w-100" @click="toggleUserFunction('create', null)"><i class="fa-solid fa-user-plus"></i> Add User</button>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-2 d-flex justify-content-end">
                        <form class="form-inline w-100">
                            <div class="input-group input-group-joined input-group-solid w-100 border">
                                <input class="form-control pe-0 bg-white" type="search" placeholder="Search" v-model="users.search" aria-label="Search" />
                                <div class="input-group-text bg-white"><i data-feather="search"></i></div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Table -->
                <b-table 
                    id="users_table"
                    :items="users_items" 
                    :fields="users.fields" 
                    :per-page="users.per_page" 
                    :current-page="users.current_page"
                    :busy="users.loading"
                    responsive
                    show-empty >
                    <template #table-busy>
                        <div class="text-center text-success my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                        </div>
                    </template>
                    <template #cell(status)="row">
                        <label v-if="row.item.status" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Active"><i class="fa-solid fa-circle text-success text-xs"></i></label>
                        <label v-else data-bs-toggle="tooltip" data-bs-placement="bottom" title="Inactive"><i class="fa-solid fa-circle text-secondary text-xs"></i></label>
                    </template>
                    <template #cell(action)="row">
                        <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="View User" class="btn btn-sm btn-light text-info d-xl-none d-lg-none d-md-inline d-sm-inline" @click="row.toggleDetails"><i class="fa-solid fa-eye"></i></button>
                        <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit User" class="btn btn-sm btn-light text-primary" @click="toggleUserFunction('edit', row.item)"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete User" @click="deleteUser(row.item)" class="btn btn-sm btn-light text-danger"><i class="fa-solid fa-trash"></i></button>
                    </template>
                    <template class="details-hide" #row-details="row">
                        <b-card class="animated--fade-in">
                            <b-row class="my-1">
                                <b-col sm="3">
                                    <label>Name:</label>
                                </b-col>
                                <b-col sm="9">
                                    <span>{{row.item.name}}</span>
                                </b-col>
                            </b-row>
                            <b-row class="my-1">
                                <b-col sm="3">
                                    <label>Email:</label>
                                </b-col>
                                <b-col sm="9">
                                    <span>{{row.item.email}}</span>
                                </b-col>
                            </b-row>
                            <b-row class="my-1">
                                <b-col sm="3">
                                    <label>Role:</label>
                                </b-col>
                                <b-col sm="9">
                                    <span>{{row.item.role}}</span>
                                </b-col>
                            </b-row>
                        </b-card>
                    </template>
                </b-table>
                <!-- Footer -->
                <div class="row">
                    <div class="col-xl col-lg col-md col-sm-12 col-xs-12 mb-2">
                        <b-pagination
                            class="mb-0"
                            size="sm"
                            v-model="users.current_page"
                            :total-rows="users.items.length"
                            :per-page="users.per_page"
                            aria-controls="users_table"
                            variant="success">
                            <template #first-text><span class="text-secondary">&lt;&lt;</span></template>
                            <template #last-text><span class="text-secondary">&gt;&gt;</span></template>
                            <template #prev-text><span class="text-secondary">&lt;</span></template>
                            <template #next-text><span class="text-secondary">&gt;</span></template>
                            <template #page="{ page, active }">
                                <b class="text-white" v-if="active">{{ page }}</b>
                                <a class="text-success" v-else>{{ page }}</a>
                            </template>
                        </b-pagination>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-2 d-flex justify-content-end">
                        <label class="text-md"> {{ users_items.length }} item(s).</label>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Create Modal -->
        <b-modal v-model="user.create_modal">
          <template #modal-header="{ close }">
            <h5>Add User</h5>
          </template>

          <template #default="{ hide }">
            <div v-if="!user.form_loading">
                <div class="row p-1">
                    <div class="col-4">
                        <small class="text-secondary"><b>Full Name</b></small>
                    </div>
                    <div class="col-8">
                        <b-form-input v-model="user.employee_name" placeholder="Enter name"></b-form-input>
                    </div>
                </div>
                <div class="row p-1">
                    <div class="col-4">
                        <small class="text-secondary"><b>Email</b></small>
                    </div>
                    <div class="col-8">
                        <b-form-input type="email" v-model="user.email" placeholder="Enter email"></b-form-input>
                    </div>
                </div>
                <div class="row p-1">
                    <div class="col-4">
                        <small class="text-secondary"><b>Username</b></small>
                    </div>
                    <div class="col-8">
                        <b-form-input v-model="user.username" placeholder="Enter user name"></b-form-input>
                    </div>
                </div>
                <div class="row p-1">
                    <div class="col-4">
                        <small class="text-secondary"><b>Password</b></small>
                    </div>
                    <div class="col-8">
                        <b-form-input type="password" v-model="user.password" placeholder="Enter password"></b-form-input>
                    </div>
                </div>
                <div class="row p-1">
                    <div class="col-4">
                        <small class="text-secondary"><b>Role</b></small>
                    </div>
                    <div class="col-8">
                        <b-form-select v-model="user.role" :options="role.options"></b-form-select>
                    </div>
                </div>
            </div>
            <b-card v-if="user.form_loading">
                <b-skeleton animation="wave" width="85%"></b-skeleton>
                <b-skeleton animation="wave" width="55%"></b-skeleton>
                <b-skeleton animation="wave" width="70%"></b-skeleton>
                <b-skeleton animation="wave" width="55%"></b-skeleton>
                <b-skeleton animation="wave" width="85%"></b-skeleton>
                <b-skeleton animation="wave" width="55%"></b-skeleton>
                <b-skeleton animation="wave" width="70%"></b-skeleton>
            </b-card>
          </template>

          <template #modal-footer="{ ok, cancel, hide }">
            <b-button v-if="user.employee_name" :disabled="(!user.username || !user.password || !user.role) || user.form_loading" variant="success" size="sm" @click="createUser()">
              Create
            </b-button>
            <b-button variant="white" size="sm" @click="cancel()" :disabled="user.form_loading">
              Discard
            </b-button>
          </template>
        </b-modal>

        <!-- Edit Modal -->
        <b-modal v-model="user.edit_modal">
          <template #modal-header="{ close }">
            <h5>Update User</h5>
          </template>

          <template #default="{ hide }">
            <div v-if="!user.form_loading">
                <div class="row p-1">
                    <div class="col-4">
                        <small class="text-secondary"><b>Full Name</b></small>
                    </div>
                    <div class="col-8">
                        <b-form-input v-model="user.employee_name" disabled></b-form-input>
                    </div>
                </div>
                <div class="row p-1">
                    <div class="col-4">
                        <small class="text-secondary"><b>Email</b></small>
                    </div>
                    <div class="col-8">
                        <b-form-input v-model="user.email" disabled></b-form-input>
                    </div>
                </div>
                <div class="row p-1">
                    <div class="col-4">
                        <small class="text-secondary"><b>Username</b></small>
                    </div>
                    <div class="col-8">
                        <b-form-input v-model="user.username" disabled></b-form-input>
                    </div>
                </div>
                <div class="row p-1">
                    <div class="col-4">
                        <small class="text-secondary"><b>Role</b></small>
                    </div>
                    <div class="col-8">
                        <b-form-select v-model="user.role" :options="role.options"></b-form-select>
                    </div>
                </div>
            </div>
            <b-card v-if="user.form_loading">
                <b-skeleton animation="wave" width="85%"></b-skeleton>
                <b-skeleton animation="wave" width="55%"></b-skeleton>
                <b-skeleton animation="wave" width="70%"></b-skeleton>
                <b-skeleton animation="wave" width="55%"></b-skeleton>
                <b-skeleton animation="wave" width="85%"></b-skeleton>
                <b-skeleton animation="wave" width="55%"></b-skeleton>
                <b-skeleton animation="wave" width="70%"></b-skeleton>
            </b-card>
          </template>

          <template #modal-footer="{ ok, cancel, hide }">
            <b-button v-if="user.employee_name" :disabled="(!user.role) || user.form_loading" variant="primary" size="sm" @click="updateUser()">
              Update
            </b-button>
            <b-button variant="white" size="sm" @click="cancel()" :disabled="user.form_loading">
              Discard
            </b-button>
          </template>
        </b-modal>
    </div>
</template>
<style scoped>
.page-header{
    background-image: linear-gradient(to top, #0ba360 0%, #3cba92 100%);
}
.page-item.active .page-link {  
    background-color: #00ac69 !important;  
    border-color: #ffffff !important;  
}
@media screen and (max-width: 900px) {
    .user-col-hide {
        display: none;
    }
    .details-hide{
        display: block;
    }
}
</style>
<script>
import Swal from 'sweetalert2';
export default {
    mounted() {
        this.getUsers();
    },
    data(){
        return{
            users: {
                items: [],
                fields: [
                    { key: 'name', label: 'Name', sortable: true, thStyle: { width: "23%" } },
                    { key: 'email', label: 'Email', sortable: true, 'class': 'user-col-hide', sortable: true, thStyle: { width: "25%" } },
                    { key: 'role', label: 'Role', sortable: true, 'class': 'user-col-hide', thStyle: { width: "20%" } },
                    { key: 'action', label: 'Action', thStyle: { width: "15%" } },
                ],
                per_page: 5,
                current_page: 1,
                loading: false,
                search: null,
            },
            user:{
                create_modal: false,
                edit_modal: false,
                delete_modal: false,
                form_loading: false,
                search: null,
                search_loading: false,
                id: null,
                employee_name: null,
                email: null,
                role: null,
                username:null,
                password:null,

                api_data:[],
            },
            role: {
                options: [
                    { value: null, text: 'Please select a role' },
                    { value: 'Client', text: 'Client' },
                    { value: 'Administrator', text: 'Administrator' },
                ],
                search: '',
            },
            Toast : Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            }),
        }
    },
    computed:{
        users_items() {
            return this.users.search
                ? this.users.items.filter(item => 
                item.name.toLowerCase().includes(this.users.search.toLowerCase()) ||
                item.email.toLowerCase().includes(this.users.search.toLowerCase()) ||
                item.role.toLowerCase().includes(this.users.search.toLowerCase()))
                : this.users.items;
        }
    },
    methods:{
        toggleUserFunction(modal, data){
            this.user.form_loading = false;
            this.user.search = null;
            this.user.search_loading = false;
            this.user.status = null;
            this.user.id = null;
            this.user.employee_id = null;
            this.user.employee_name = null;
            this.user.email = null;
            this.user.role = null;
            this.user.username = null;
            this.user.password = null;
            
            if(modal){
                this.user.create_modal = modal == 'create' ? true : false;
                if(modal == 'edit'){
                    this.user.id = data.id;
                    this.user.employee_id = data.employee_id;
                    this.user.employee_name = data.name;
                    this.user.email = data.email;
                    this.user.username = data.username
                    this.user.role = data.role;
                    this.user.edit_modal = true;
                }
            }
        },

        getUsers(){
            this.users.loading = true;
            this.users.items = [];
            axios.get('/get/users')
            .then((response) => {
                this.users.loading = false;
                this.users.items = response.data;
            })
            .catch((error) => {
                this.Toast.fire({
                    icon: 'error',
                    title: error.message
                })
            })
        },
        
        createUser(){
            this.user.form_loading = true;
            axios.post('/insert/user',{
                name : this.user.employee_name,
                email : this.user.email,
                username : this.user.username,
                password : this.user.password,
                role : this.user.role,
            })
            .then((response) => {
                this.user.form_loading = false;
                if(response.data.error){
                    this.Toast.fire({
                        icon: 'warning',
                        title: response.data.error
                    })
                }else{
                    this.user.create_modal = false;
                    this.Toast.fire({
                        icon: 'success',
                        title: 'User successfully inserted',
                    })
                    this.getUsers();
                }
            })
            .catch((error) => {
                this.user.form_loading = false;
                this.Toast.fire({
                    icon: 'error',
                    title: error.message
                })
            })
        }, 

        updateUser(){
            this.user.form_loading = true;
            axios.post('/update/user',{
                id : this.user.id,
                role : this.user.role
            })
            .then((response) => {
                console.log(response.data);
                this.user.form_loading = false;
                this.user.edit_modal = false;
                this.Toast.fire({
                    icon: 'success',
                    title: 'User successfully updated'
                })
                this.getUsers();
            })
            .catch((error) => {
                this.user.form_loading = false;
                this.Toast.fire({
                    icon: 'error',
                    title: error.message
                })
            })
        }, 

        deleteUser(data){
            Swal.fire({
                    title: 'Delete User?',
                    text: data.name,
                    showCancelButton: true,
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Delete',
                    confirmButtonColor: '#DC3545',
                    icon: 'question',
                }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete/user',{
                        id: data.id
                    })
                    .then((response) => {
                        this.Toast.fire({
                            icon: 'success',
                            title: 'User successfully deleted'
                        })
                        this.getUsers();
                    })
                    .catch((error) => {
                        this.Toast.fire({
                            icon: 'error',
                            title: error.message
                        })
                    })
                }
            })
        },
    }
}
</script>
