<template>
    <div class="container-fluid mb-3 mt-0" style="background-color: #ffffff;">
        <!--Overview-->
        <div class="row pl-4 pr-0 mt-3">
            <div class="row p-0 mt-2">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <div class="card shadow" style="cursor:pointer;border-radius: 0.5rem !important;background-color:#52A2FF; overflow: hidden; height: 85%;">
                        <div class="card-body">
                            <div style="position:absolute; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(0px); -webkit-backdrop-filter: blur(5px); height: 130px; width: 130px; border-radius: 50%; right: -25px; top: -63px;"></div>
                            <div class="row no-gutters">
                                <div>
                                    <h6 style="color:#ffffff;"><b>Total</b></h6>
                                </div>
                                <div class="mt-1">
                                    <div>
                                        <i class="fa-solid fa-boxes-stacked mr-2" style="color:#ffffff;"></i><div id="received_text" class="odometer h4 mb-0 font-weight-bold" style="color:#ffffff;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="chart-1">
                            <apexchart type="area" height="65" width="100%" :options="chartOptions2" :series="series2"></apexchart>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <div class="card shadow" style="cursor:pointer;border-radius: 0.5rem !important;background-color:#3DDBBB; overflow: hidden; height: 85%;">
                        <div class="card-body">
                            <div style="position:absolute; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(0px); -webkit-backdrop-filter: blur(5px); height: 130px; width: 130px; border-radius: 50%; right: -25px; top: -63px;"></div>
                            <div class="row no-gutters">
                                <div>
                                    <h6 style="color:#ffffff;"><b>Sent</b></h6>
                                </div>
                                <div class="mt-1">
                                    <div>
                                        <i class="fa-solid fa-paper-plane mr-2" style="color:#ffffff;"></i><div id="sent_text" class="odometer h4 mb-0 font-weight-bold" style="color:#ffffff;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="chart-1">
                            <apexchart type="area" height="65" width="100%" :options="chartOptions2" :series="series2"></apexchart>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <div class="card shadow" style="cursor:pointer;border-radius: 0.5rem !important;background-color:#FFBF62; overflow: hidden; height: 85%;">
                        <div class="card-body">
                            <div style="position:absolute; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(0px); -webkit-backdrop-filter: blur(5px); height: 130px; width: 130px; border-radius: 50%; right: -25px; top: -63px;"></div>
                            <div class="row no-gutters">
                                <div>
                                    <h6 style="color:#ffffff;"><b>Delivered</b></h6>
                                </div>
                                <div class="mt-1">
                                    <div>
                                        <i class="fa-solid fa-clipboard-check mr-2" style="color:#ffffff;"></i><div id="delivered_text" class="odometer h4 mb-0 font-weight-bold" style="color:#ffffff;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="chart-1">
                            <apexchart type="area" height="65" width="100%" :options="chartOptions2" :series="series2"></apexchart>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <div class="card shadow" style="cursor:pointer;border-radius: 0.5rem !important;background-color:#FF6881; overflow: hidden; height: 85%;">
                        <div class="card-body">
                            <div style="position:absolute; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(0px); -webkit-backdrop-filter: blur(5px); height: 130px; width: 130px; border-radius: 50%; right: -25px; top: -63px;"></div>
                            <div class="row no-gutters">
                                <div>
                                    <h6 style="color:#ffffff;"><b>Pending</b></h6>
                                </div>
                                <div class="mt-1">
                                    <div>
                                        <i class="fa-solid fa-truck mr-2" style="color:#ffffff;"></i><div id="pending_text" class="odometer h4 mb-0 font-weight-bold" style="color:#ffffff;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="chart-1">
                            <apexchart type="area" height="65" width="100%" :options="chartOptions2" :series="series2"></apexchart>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row pl-4 pr-0 mt-3">
            <div class="row">
                <div class="col-xl col-lg-6 col-md-6 bg-white shadow rounded border">
                    <div class="p-2">
                        <div align="left"> <i class="icon-signal text-secondary"></i>
                            <small class="text-secondary"><b>Online Store Visitors</b></small>
                        </div>
                        <div class=" h-100 w-100">
                            <apexchart width="550" type="bar" :options="chartOptions1" :series="chartData1" />
                        </div>
                    </div>
                </div>
                &nbsp;&nbsp;
                <div class="col-xl col-lg-6 col-md-6 bg-white shadow rounded">
                    <div class="p-2">
                        <div align="left"> <i class="icon-signal text-secondary"></i>
                            <small width="50%" class="text-secondary"><b>Sales</b></small>
                        </div>
                        <div class=" h-100 w-100">
                            <apexchart width="550" type="line" :options="chartOptions3" :series="chartData3" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>

</style>
<script>
var moment = require('moment');
    export default {
        props: [],
        mounted() {
            setTimeout(function(){
                received_text.innerText = 1500;
                sent_text.innerText = 800;
                delivered_text.innerText = 525;
                pending_text.innerText = 600;
            }, 2000);
        },
        data () {
            return {
                //sparkline chart
                series2: [{
                    data: [12, 14, 2, 47, 42, 15, 47, 75, 65, 19, 14]
                }],

                chartOptions2: {
                    colors: ['#ffffff'],
                    chart: {
                    type: 'area',
                    width: 100,
                    height: 35,
                    sparkline: {
                        enabled: true
                    }
                    },
                    tooltip: {
                        enabled: false,
                        fixed: {
                            enabled: false
                        },
                        x: {
                            show: false
                        },
                        y: {
                            title: {
                                formatter: function (seriesName) {
                                    return ''
                                }
                            }
                        },
                        marker: {
                            show: false
                        }
                    }
                },
                //end of sparkline

                //sample bar chart
                chartData1: [
                    { name: "Series 1", data: [55, 62, 89, 66, 98, 72, 101, 75, 94, 120, 117, 139] },
                ],
                chartOptions1: {
                    chart: {
                    // Responsive options
                    responsive: [{
                        breakpoint: 480, // Adjust breakpoint as needed (e.g., for mobile devices)
                        options: {
                        chart: {
                            width: '100%' // Set chart width to 100% for responsive behavior
                        },
                        legend: {
                            position: 'bottom' // Adjust legend position for smaller screens
                        }
                        }
                    }]
                    },
                    xaxis: {
                    categories: [
                        "Jan",
                        "Feb",
                        "Mar",
                        "Apr",
                        "May",
                        "Jun",
                        "Jul",
                        "Aug",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dec"]
                    },
                },
                //end sample bar chart

                //sample line chart
                chartData3: [
                    { name: "Series 1", data: [55, 62, 89, 66, 98, 72, 101, 75, 94, 120, 117, 139] },
                ],
                chartOptions3: {
                    chart: {
                    // Responsive options
                    responsive: [{
                        breakpoint: 480, // Adjust breakpoint as needed (e.g., for mobile devices)
                        options: {
                        chart: {
                            width: '100%' // Set chart width to 100% for responsive behavior
                        },
                        legend: {
                            position: 'bottom' // Adjust legend position for smaller screens
                        }
                        }
                    }]
                    },
                    xaxis: {
                        categories: [
                        "Jan",
                        "Feb",
                        "Mar",
                        "Apr",
                        "May",
                        "Jun",
                        "Jul",
                        "Aug",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dec"]
                    },
                },
                //end sample bar chart
                    
            }
        },
        methods:{
            
        }
    }
</script>