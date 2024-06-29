<template>
    <div id="layoutSidenav_nav">
        <nav class="sidenav" style="background-color: #343a40;">
            <div class="sidenav-menu">
                <div class="nav accordion" id="accordionSidenav">
                    <!-- Account Info -->
                    <div class="justify-content-center text-center p-2 mt-4">
                        <b-avatar size="6rem" class="mb-2" src="/assets/img/illustrations/profiles/profile-1.png"></b-avatar>
                        <br>
                        <i class="text-gray-400"><b>{{user_name}}</b></i>
                        <br>
                        <!-- User Role -->
                        <i class="text-gray-400"><b>{{user_role}}</b></i>
                        <br>
                        <i class="text-gray-500 text-xs">June 05, 2020 05:05:05 am</i>
                    </div>

                    <hr class="text-gray-500">
                    
                    <div v-if="user_role == 'Administrator'">
                        <!-- Sidenav Accordion (Dashboard)-->
                        <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseMaintenance" aria-expanded="false" aria-controls="collapseMaintenance">
                            <div class="text-gray-400"><i data-feather="settings"></i> Maintenance</div>
                            <div class="sidenav-collapse-arrow text-gray-400"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseMaintenance" data-bs-parent="#acordionMaintenance">
                            <nav class="sidenav-menu-nested nav accordion" id="maintenanceSideNav">
                                <a class="text-gray-400" href="/user">
                                    <i class="fa-solid fa-user"></i> Users
                                </a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseProduct" aria-expanded="false" aria-controls="collapseMaintenance">
                            <div class="text-gray-400"><i class="fa-solid fa-boxes-stacked"></i> Products</div>
                            <div class="sidenav-collapse-arrow text-gray-400"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseProduct" data-bs-parent="#acordionProduct">
                            <nav class="sidenav-menu-nested nav accordion" id="productSideNav">
                                <a class="text-gray-400 mb-2" href="/category">
                                    <i class="fa-solid fa-layer-group"></i> Category
                                </a>
                                <a class="text-gray-400" href="/product">
                                    <i class="fa-solid fa-box"></i> Items
                                </a>
                            </nav>
                        </div>
                    </div>
                    <div v-if="user_role == 'Client'">
                        <a class="nav-link" href="/product">
                            <div class="text-gray-400"><i class="fa-solid fa-box"></i> Product</div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Sidenav Footer-->
            <div class="sidenav-footer" v-if="user_data.name">
                <!-- <div class="sidenav-footer-content">
                    <div class="sidenav-footer-subtitle">Logged in as:</div>
                    <div class="sidenav-footer-title">Valerie Luna</div>
                </div> -->
            </div>
        </nav>
    </div>
</template>
<style>

</style>
<script>
    export default {
        props:['user_data'],
        mounted() {
        },
        data(){
            return{
                user_role: JSON.parse(this.user_data).role,
                user_name: JSON.parse(this.user_data).name,
            }
        },
        computed:{
        },
        methods:{

        }
    }
</script>
