<template>
    <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
        <!-- Sidenav Toggle Button-->
        <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i data-feather="menu"></i></button>
   
        <a class="navbar-brand pe-3 ps-4 ps-lg-2" style="color: #343a40;" href="/dashboard">{{app_name}}</a>
        
        <!-- Navbar Items-->
        <ul class="navbar-nav align-items-center ms-auto">
            <!-- Search in Mobile -->
            <!-- <li class="nav-item dropdown no-caret me-3 d-lg-none">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="searchDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="search"></i></a>
                <div class="dropdown-menu dropdown-menu-end p-3 shadow animated--fade-in-up" aria-labelledby="searchDropdown">
                    <form class="form-inline me-auto w-100">
                        <div class="input-group input-group-joined input-group-solid">
                            <input class="form-control pe-0" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                            <div class="input-group-text"><i data-feather="search"></i></div>
                        </div>
                    </form>
                </div>
            </li> -->
            <div class="mr-2">
                <form class="form-inline me-auto d-none d-lg-block me-3">
                    <div class="input-group input-group-joined input-group-solid">
                        <input class="form-control pe-0" type="search" placeholder="Search" aria-label="Search" />
                        <div class="input-group-text"><i data-feather="search"></i></div>
                    </div>
                </form>
            </div>
            <div class="mr-2">
                <a class="nav-link">
                    <div><i class="fa-regular fa-comments fa-lg"></i></div>
                </a>
            </div>
            <div>
                <a class="nav-link">
                    <div><i class="fa-regular fa-bell fa-lg"></i></div>
                </a>
            </div>
            <!-- User Dropdown-->
            <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="/assets/img/illustrations/profiles/profile-1.png" /></a>
                <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <img class="dropdown-user-img" src="/assets/img/illustrations/profiles/profile-1.png" />
                        <div class="dropdown-user-details">
                            <div class="dropdown-user-details-name">{{user.name}}</div>
                            <div class="dropdown-user-details-email">{{ user.email }}</div>
                        </div>
                    </h6>
                    <a class="dropdown-item">
                        <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                        Account
                    </a>
                    <a class="dropdown-item" href="/logout">
                        <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        props: ['app_name','user_data'],
        mounted() {
            this.info = JSON.parse(this.user_data);

            this.loadData();
        },
        data(){
            return{
                info:[],
                user:{
                    name:null,
                    email:null,
                },
                user_role: JSON.parse(this.user_data).role,
            }
        },
        methods:{
            loadData()
            {
                if(this.info)
                {
                    this.user.name = this.info.name;
                    this.user.email = this.info.email;
                }
            }
        }
    }
</script>
