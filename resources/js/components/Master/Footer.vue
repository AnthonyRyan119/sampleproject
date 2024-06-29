<template>
    <footer class="footer-admin mt-auto footer-light">
        <div class="container-xl px-4">
            <div class="row">
                <div class="col-md-6 small">Copyright &copy; {{ app_name }} 2023</div>
                <div class="col-md-6 text-md-end small">
                    <a href="mailto: tso_dev@unilab.com.ph"><i class="fa-regular fa-envelope"></i> sample_support@gmail.com</a>
                    &middot;
                    <a href="#!"><i class="fa-solid fa-phone"></i> 1234</a>
                </div>
            </div>
        </div>
    </footer>
</template>
<style>

</style>
<script>
    export default {
        props:['app_name'],
        mounted() {
            
        },
        data(){
            return{

            }
        },
        computed:{
        },
        methods:{

        }
    }
</script>
