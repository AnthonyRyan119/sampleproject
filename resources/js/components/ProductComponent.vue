<template>
    <div class="container-fluid p-0">
        <header class="page-header page-header-dark pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i class="fa-solid fa-box"></i></div>
                                Product Management
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
                            v-model="products.per_page"
                            :options="$page_options"
                            required
                        ></b-form-select>&nbsp;
                        <label class="text-md"> entries per page</label>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-xs-6 mb-2">
                        <button class="btn btn-sm btn-light text-success w-100" @click="toggleProductFunction('create', null)"><i class="fa-solid fa-boxes-stacked"></i> Add Product</button>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-2 d-flex justify-content-end">
                        <form class="form-inline w-100">
                            <div class="input-group input-group-joined input-group-solid w-100 border">
                                <input class="form-control pe-0 bg-white" type="search" placeholder="Search" v-model="products.search" aria-label="Search" />
                                <div class="input-group-text bg-white"><i data-feather="search"></i></div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Table -->
                <b-table 
                    id="products_table"
                    :items="product_items" 
                    :fields="products.fields" 
                    :per-page="products.per_page" 
                    :current-page="products.current_page"
                    :busy="products.loading"
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
                        <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Product" class="btn btn-sm btn-light text-info d-xl-none d-lg-none d-md-inline d-sm-inline" @click="row.toggleDetails"><i class="fa-solid fa-eye"></i></button>
                        <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit Product" class="btn btn-sm btn-light text-primary" @click="toggleProductFunction('edit', row.item)"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete Product" @click="deleteProduct(row.item)" class="btn btn-sm btn-light text-danger"><i class="fa-solid fa-trash"></i></button>
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
                                    <label>Category:</label>
                                </b-col>
                                <b-col sm="9">
                                    <span>{{row.item.category}}</span>
                                </b-col>
                            </b-row>
                            <b-row class="my-1">
                                <b-col sm="3">
                                    <label>Description:</label>
                                </b-col>
                                <b-col sm="9">
                                    <span>{{row.item.description}}</span>
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
                            v-model="products.current_page"
                            :total-rows="products.items.length"
                            :per-page="products.per_page"
                            aria-controls="products_table"
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
                        <label class="text-md"> {{ product_items.length }} item(s).</label>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Create Modal -->
        <b-modal v-model="product.create_modal" size="lg">
          <template #modal-header="{ close }">
            <h5>Add Product</h5>
          </template>

          <template #default="{ hide }">
            <div v-if="!product.form_loading">
                <div class="row p-1">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <small class="text-secondary"><b>Product Name</b></small>
                            </div>
                            <div class="col-8">
                                <b-form-input v-model="product.name" placeholder="Enter product name"></b-form-input>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <small class="text-secondary"><b>Category</b></small>
                            </div>
                            <div class="col-8">
                                <v-select v-model="product.category" class="text-secondary" :options="category.options" placeholder="Select Category" :reduce="option => option.label"></v-select>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row p-1">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <small class="text-secondary"><b>Date & Time</b></small>
                            </div>
                            <div class="col-8">
                                <input type="datetime-local" class="h-100 w-100 form-control" v-model="product.date" style="font-size:14px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <small class="text-secondary"><b>Upload Image</b></small><small class="text-info ml-1"></small>
                            </div>
                            <div class="col-8">
                                <b-form-group>
                                    <template>
                                        <b-form-file class="mt-1"
                                         v-model="product.file_attachments" 
                                         multiple
                                         accept=".jpg, .png"
                                        :file-name-formatter="formatNames"
                                        ></b-form-file>
                                    </template> 
                                </b-form-group>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row p-1" style="margin-top: -20px">
                    <div>
                        <small class="text-secondary ml-1"><b>Description</b></small>
                    </div>
                </div>
                <div class="row p-1">
                    <div>
                        <vue-editor v-model="product.description" :editorToolbar="customToolbar"></vue-editor>
                    </div>
                </div>
            </div>
            <b-card v-if="product.form_loading">
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
            <b-button v-if="product.name" :disabled="(!product.category || !product.date || !product.description) || product.form_loading" variant="success" size="sm" @click="createProduct()">
              Create
            </b-button>
            <b-button variant="white" size="sm" @click="cancel()" :disabled="product.form_loading">
              Discard
            </b-button>
          </template>
        </b-modal>

        <!-- Edit Modal -->
        <b-modal v-model="product.edit_modal" size="lg">
          <template #modal-header="{ close }">
            <h5>Update Product</h5>
          </template>

          <template #default="{ hide }">
            <div v-if="!product.form_loading">
                <div class="row p-1">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <small class="text-secondary"><b>Product Name</b></small>
                            </div>
                            <div class="col-8">
                                <b-form-input v-model="product.name" placeholder="Enter product name"></b-form-input>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <small class="text-secondary"><b>Category</b></small>
                            </div>
                            <div class="col-8">
                                <v-select v-model="product.category" class="text-secondary" :options="category.options" placeholder="Select Category" :reduce="option => option.label"></v-select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row p-1">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <small class="text-secondary"><b>Date & Time</b></small>
                            </div>
                            <div class="col-8">
                                <b-input-group v-if="show_default_date">
                                    <template #append>
                                    <b-button variant="outline-info" size="sm" @click="showDatePicker()"><i class="fa-solid fa-pen-to-square"></i></b-button>
                                    </template>
                                    <b-form-input v-model="product.date"></b-form-input>
                                </b-input-group>
                                <input type="datetime-local" v-if="show_datepicker" class="h-100 w-100 form-control" v-model="product.new_date" style="font-size:14px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <small class="text-secondary"><b>Upload Image</b></small>
                            </div>
                            <div class="col-8">
                                <b-form-group>
                                    <template>
                                        <b-form-file class="mt-1" v-model="product.file_attachments" 
                                        multiple 
                                        :file-name-formatter="formatNames"
                                        accept=".jpg, .png"
                                        ></b-form-file>
                                    </template> 
                                </b-form-group>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row p-1" v-if="uploaded_img.length != 0">
                    <div>
                        <small class="text-secondary"><b>Uploaded Image(s)</b></small>
                    </div>
                </div>
                <div class="row p-1" v-if="uploaded_img.length != 0">
                    <div class="col-3" v-for="(img,index) in uploaded_img" :key="index">
                        <b-card class="rounded shadow">
                            <img :src="'/storage/'+img+'?timestamp='+timestamp" alt="" style="width: 100%;">
                        </b-card>
                    </div>
                </div>
                <div class="row p-1">
                    <div>
                        <small class="text-secondary ml-1"><b>Description</b></small>
                    </div>
                </div>
                <div class="row p-1">
                    <div>
                        <vue-editor v-model="product.description" :editorToolbar="customToolbar"></vue-editor>
                    </div>
                </div>
            </div>
            <b-card v-if="product.form_loading">
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
            <b-button v-if="product.name" :disabled="(!product.category || !product.description) || product.form_loading" variant="primary" size="sm" @click="updateProduct()">
              Update
            </b-button>
            <b-button variant="white" size="sm" @click="cancel()" :disabled="product.form_loading">
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
var moment = require('moment');
import { VueEditor } from "vue2-editor";
export default {
    mounted() {
        this.getProduct();
        this.getCategory();
    },
    components: {
        VueEditor
    },
    data(){
        return{
            products: {
                items: [],
                fields: [
                    { key: 'name', label: 'Name', sortable: true, thStyle: { width: "23%" } },
                    { key: 'category', label: 'Category', sortable: true, 'class': 'user-col-hide', sortable: true, thStyle: { width: "25%" } },
                    { key: 'action', label: 'Action', thStyle: { width: "15%" } },
                ],
                per_page: 5,
                current_page: 1,
                loading: false,
                search: null,
            },
            product:{
                create_modal: false,
                edit_modal: false,
                delete_modal: false,
                form_loading: false,
                search: null,
                search_loading: false,
                id: null,
                name: null,
                category: null,
                description: null,
                image: null,
                date: null,
                new_date: null,
                file_attachments:[],

                api_data:[],
            },
            category: {
                options: [],
            },
            customToolbar: [
                ["bold", "italic", "underline"],
                [{ list: "ordered" }, { list: "bullet" }],
                ["code-block"]
            ],
            show_datepicker: false,
            show_default_date: true,
            timestamp: new Date().getTime(),
            uploaded_img: [],

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
        product_items() {
            return this.products.search
                ? this.products.items.filter(item => 
                item.name.toLowerCase().includes(this.products.search.toLowerCase()) ||
                item.email.toLowerCase().includes(this.products.search.toLowerCase()) ||
                item.role.toLowerCase().includes(this.products.search.toLowerCase()))
                : this.products.items;
        }
    },
    methods:{
        
        getCategory(){
            axios.get('/get/category/option')
            .then((response) => {
                this.category.options = response.data;
            })
            .catch((error) => {
                this.Toast.fire({
                    icon: 'error',
                    title: error.message
                })
            })
        },

        getProduct(){
            this.products.loading = true;
            this.products.items = [];
            axios.get('/get/product')
            .then((response) => {
                this.products.loading = false;
                this.products.items = response.data;
            })
            .catch((error) => {
                this.Toast.fire({
                    icon: 'error',
                    title: error.message
                })
            })
        },

        formatNames(files) {
            return files.length === 1 ? files[0].name : `${files.length} files selected`
        },

        toggleProductFunction(modal, data){
            this.product.form_loading = false;
            this.product.search = null;
            this.product.search_loading = false;
            this.product.status = null;
            this.product.id = null;
            this.product.name = null;
            this.product.category = null;
            this.product.description = null;
            this.product.date = null;
            this.product.new_date = null;
            this.product.file_attachments = null;
            
            if(modal){
                this.product.create_modal = modal == 'create' ? true : false;
                if(modal == 'edit'){
                    this.product.id = data.id;
                    this.getFileAttachment();
                    this.product.name = data.name;
                    this.product.category = data.category;
                    this.product.description = data.description
                    this.product.date = data.date;
                    this.product.new_date = null;
                    this.show_datepicker = false;
                    this.show_default_date = true;
                    this.product.edit_modal = true;
                }
            }
        },

        showDatePicker()
        {
            this.show_datepicker = true;
            this.show_default_date = false;
        },

        getFileAttachment()
        {
            axios.post('/get/file/attachment',
            {
                id: this.product.id,
            })
            .then((response)=>
            {
                this.uploaded_img = response.data;
                
            })
        },
        
        createProduct(){
            this.product.form_loading = true;

            let formData = new FormData();
            formData.append('name',this.product.name);
            formData.append('category',this.product.category);
            formData.append('date',moment(this.product.date).format('YYYY-MM-DD hh:mm a'));
            formData.append('description',this.product.description);

            if(this.product.file_attachments)
            {
                for (var i = 0; i < this.product.file_attachments.length; i++) 
                {
                    formData.append('file_attachments[' + i + ']', this.product.file_attachments[i]);
                }
            }  
            axios.post('/insert/product',formData)
            .then((response) => {
                this.product.form_loading = false;
                if(response.data.error){
                    this.product.create_modal = false;
                    this.Toast.fire({
                        icon: 'warning',
                        title: response.data.error
                    })
                    this.getProduct();
                }else{
                    this.product.create_modal = false;
                    this.Toast.fire({
                        icon: 'success',
                        title: 'Product successfully inserted',
                    })
                    this.getProduct();
                }
            })
            .catch((error) => {
                this.product.form_loading = false;
                this.Toast.fire({
                    icon: 'error',
                    title: error.message
                })
            })
        }, 

        updateProduct(){
            //validate if date is updated
            var date = null;
            if(this.show_datepicker == true)
            {   
                this.product.new_date ? date = this.product.new_date : date = this.product.date;
            }
            else
            {
                date = this.product.date;
            }

            this.product.form_loading = true;

            let formData = new FormData();
            formData.append('id',this.product.id);
            formData.append('name',this.product.name);
            formData.append('category',this.product.category);
            formData.append('date',moment(date).format('YYYY-MM-DD hh:mm a'));
            formData.append('description',this.product.description);

            if(this.product.file_attachments)
            {
                for (var i = 0; i < this.product.file_attachments.length; i++) 
                {
                    formData.append('file_attachments[' + i + ']', this.product.file_attachments[i]);
                }
            }

            axios.post('/update/product',formData)
            .then((response) => {
                this.product.form_loading = false;
                this.product.edit_modal = false;
                this.Toast.fire({
                    icon: 'success',
                    title: 'Product successfully updated'
                })
                this.getProduct();
                
            })
            .catch((error) => {
                this.product.form_loading = false;
                this.Toast.fire({
                    icon: 'error',
                    title: error.message
                })
            })
        }, 

        deleteProduct(data){
            Swal.fire({
                    title: 'Delete Product?',
                    text: data.name,
                    showCancelButton: true,
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Delete',
                    confirmButtonColor: '#DC3545',
                    icon: 'question',
                }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete/product',{
                        id: data.id
                    })
                    .then((response) => {
                        this.Toast.fire({
                            icon: 'success',
                            title: 'Product successfully deleted'
                        })
                        this.getProduct();
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
