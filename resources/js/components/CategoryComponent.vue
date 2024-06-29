<template>
    <div class="container-fluid p-0">
        <header class="page-header page-header-dark pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i class="fa-solid fa-layer-group"></i></div>
                                Category Management
                            </h1>
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
                            v-model="category_tbl.per_page"
                            :options="$page_options"
                            required
                        ></b-form-select>&nbsp;
                        <label class="text-md"> entries per page</label>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-xs-6 mb-2">
                        <button class="btn btn-sm btn-light text-success w-100" @click="toggleCategoryFunction('create', null)"><i class="fa-solid fa-layer-group"></i> Add Category</button>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-2 d-flex justify-content-end">
                        <form class="form-inline w-100">
                            <div class="input-group input-group-joined input-group-solid w-100 border">
                                <input class="form-control pe-0 bg-white" type="search" placeholder="Search" v-model="category_tbl.search" aria-label="Search" />
                                <div class="input-group-text bg-white"><i data-feather="search"></i></div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Table -->
                <b-table 
                    id="category_table"
                    :items="category_items" 
                    :fields="category_tbl.fields" 
                    :per-page="category_tbl.per_page" 
                    :current-page="category_tbl.current_page"
                    :busy="category_tbl.loading"
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
                        <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit Category" class="btn btn-sm btn-light text-primary" @click="toggleCategoryFunction('edit', row.item)"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete Category" @click="deleteCategory(row.item)" class="btn btn-sm btn-light text-danger"><i class="fa-solid fa-trash"></i></button>
                    </template>
                </b-table>
                <!-- Footer -->
                <div class="row">
                    <div class="col-xl col-lg col-md col-sm-12 col-xs-12 mb-2">
                        <b-pagination
                            class="mb-0"
                            size="sm"
                            v-model="category_tbl.current_page"
                            :total-rows="category_tbl.items.length"
                            :per-page="category_tbl.per_page"
                            aria-controls="category_table"
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
                        <label class="text-md"> {{ category_items.length }} item(s).</label>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Create Modal -->
        <b-modal v-model="category.create_modal">
          <template #modal-header="{ close }">
            <h5>Add Category</h5>
          </template>

          <template #default="{ hide }">
            <div v-if="!category.form_loading">
                <div class="row p-1">
                    <div class="col-4">
                        <small class="text-secondary"><b>Category Name</b></small>
                    </div>
                    <div class="col-8">
                        <b-form-input v-model="category.name" placeholder="Enter category name"></b-form-input>
                    </div>
                </div>
            </div>
            <b-card v-if="category.form_loading">
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
            <b-button v-if="category.name" :disabled="(!category.name) || category.form_loading" variant="success" size="sm" @click="createCategory()">
              Create
            </b-button>
            <b-button variant="white" size="sm" @click="cancel()" :disabled="category.form_loading">
              Discard
            </b-button>
          </template>
        </b-modal>

        <!-- Edit Modal -->
        <b-modal v-model="category.edit_modal">
          <template #modal-header="{ close }">
            <h5>Update Category</h5>
          </template>

          <template #default="{ hide }">
            <div v-if="!category.form_loading">
                <div class="row p-1">
                    <div class="col-4">
                        <small class="text-secondary"><b>Category Name</b></small>
                    </div>
                    <div class="col-8">
                        <b-form-input v-model="category.name"></b-form-input>
                    </div>
                </div>
            </div>
            <b-card v-if="category.form_loading">
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
            <b-button v-if="category.name" :disabled="(!category.name) || category.form_loading" variant="primary" size="sm" @click="updateCategory()">
              Update
            </b-button>
            <b-button variant="white" size="sm" @click="cancel()" :disabled="category.form_loading">
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

</style>
<script>
import Swal from 'sweetalert2';
export default {
    mounted() {
        this.getCategory();
    },
    data(){
        return{
            category_tbl: {
                items: [],
                fields: [
                    { key: 'name', label: 'Name', sortable: true, thStyle: { width: "23%" } },
                    { key: 'action', label: 'Action', thStyle: { width: "15%" } },
                ],
                per_page: 5,
                current_page: 1,
                loading: false,
                search: null,
            },
            category:{
                create_modal: false,
                edit_modal: false,
                delete_modal: false,
                form_loading: false,
                search: null,
                search_loading: false,
                id: null,
                name: null,

                api_data:[],
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
        category_items() {
            return this.category_tbl.search
                ? this.category_tbl.items.filter(item => 
                item.name.toLowerCase().includes(this.category_tbl.search.toLowerCase()))
                : this.category_tbl.items;
        }
    },
    methods:{
        toggleCategoryFunction(modal, data){
            this.category.form_loading = false;
            this.category.search = null;
            this.category.search_loading = false;
            this.category.status = null;
            this.category.id = null;
            this.category.name = null;
            
            if(modal){
                this.category.create_modal = modal == 'create' ? true : false;
                if(modal == 'edit'){
                    this.category.id = data.id;
                    this.category.name = data.name;
                    this.category.edit_modal = true;
                }
            }
        },

        getCategory(){
            this.category_tbl.loading = true;
            this.category_tbl.items = [];
            axios.get('/get/category')
            .then((response) => {
                console.log(response.data);
                this.category_tbl.loading = false;
                this.category_tbl.items = response.data;
            })
            .catch((error) => {
                this.Toast.fire({
                    icon: 'error',
                    title: error.message
                })
            })
        },
        
        createCategory(){
            this.category.form_loading = true;
            axios.post('/insert/category',{
                name : this.category.name
            })
            .then((response) => {
                this.category.form_loading = false;
                if(response.data.error){
                    this.Toast.fire({
                        icon: 'warning',
                        title: response.data.error
                    })
                }else{
                    this.category.create_modal = false;
                    this.Toast.fire({
                        icon: 'success',
                        title: 'Category successfully inserted',
                    })
                    this.getCategory();
                }
            })
            .catch((error) => {
                this.category.form_loading = false;
                this.Toast.fire({
                    icon: 'error',
                    title: error.message
                })
            })
        }, 

        updateCategory(){
            this.category.form_loading = true;
            axios.post('/update/category',{
                id : this.category.id,
                name : this.category.name
            })
            .then((response) => {
                console.log(response.data);
                this.category.form_loading = false;
                this.category.edit_modal = false;
                this.Toast.fire({
                    icon: 'success',
                    title: 'Category successfully updated'
                })
                this.getCategory();
            })
            .catch((error) => {
                this.category.form_loading = false;
                this.Toast.fire({
                    icon: 'error',
                    title: error.message
                })
            })
        }, 

        deleteCategory(data){
            Swal.fire({
                    title: 'Delete Category?',
                    text: data.name,
                    showCancelButton: true,
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Delete',
                    confirmButtonColor: '#DC3545',
                    icon: 'question',
                }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete/category',{
                        id: data.id
                    })
                    .then((response) => {
                        this.Toast.fire({
                            icon: 'success',
                            title: 'Category successfully deleted'
                        })
                        this.getCategory();
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
