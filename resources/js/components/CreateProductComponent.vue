<template>
    <div class="container-fluid p-0">
        <header class="page-header page-header-dark pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i class="fa-solid fa-box"></i></div>
                                Create Product
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
                <div v-if="!product.form_loading">
                    <div class="row p-1">
                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <small class="text-secondary"><b>Product Name</b></small>
                                </div>
                                <div class="col-lg-8 col-sm-12">
                                    <b-form-input v-model="product.name" placeholder="Enter product name"></b-form-input>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <div class="col-lg-3 col-sm-12">
                                    <small class="text-secondary"><b>Category</b></small>
                                </div>
                                <div class="col-lg-9 col-sm-12">
                                    <v-select v-model="product.category" class="text-secondary" :options="category.options" placeholder="Select Category" :reduce="option => option.label"></v-select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row p-1">
                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <small class="text-secondary"><b>Date & Time</b></small>
                                </div>
                                <div class="col-lg-8 col-sm-12">
                                    <input type="datetime-local" class="h-100 w-100 form-control" v-model="product.date" style="font-size:14px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <div class="col-lg-3 col-sm-12">
                                    <small class="text-secondary"><b>Upload Image</b></small><small class="text-info ml-1"></small>
                                </div>
                                <div class="col-lg-9 col-sm-12">
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
                    <div class="d-flex justify-content-center mt-3">
                        <b-button v-if="product.name" :disabled="(!product.category || !product.date || !product.description) || product.form_loading" variant="success" size="md" @click="createProduct()">
                            Create
                        </b-button>
                        <b-button v-if="product.name" variant="white" size="md" @click="cancel()" :disabled="product.form_loading">
                            Discard
                        </b-button>
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
            </div>
        </div>
    </div>
</template>
<style scoped>
.page-header{
    background-color: #44494f;
}
.page-item.active .page-link {  
    background-color: #00ac69 !important;  
    border-color: #ffffff !important;  
}
.hide{
    display: none !important;
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
        this.getCategory();
    },
    components: {
        VueEditor
    },
    data(){
        return{
            product:{
                form_loading: false,
                id: null,
                name: null,
                category: null,
                description: null,
                image: null,
                date: null,
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
            filter_category: null,

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

        formatNames(files) {
            return files.length === 1 ? files[0].name : `${files.length} files selected`
        },

        cancel()
        {
            this.product.name = null;
            this.product.category = null;
            this.product.description = null;
            this.product.date = null;
            this.product.file_attachments = null;
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
                }else{
                    this.product.create_modal = false;
                    this.Toast.fire({
                        icon: 'success',
                        title: 'Product successfully inserted',
                    })
                    this.cancel();
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
    }
}
</script>
