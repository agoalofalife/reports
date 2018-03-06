<template>
<div>
    <el-row>
        <!--<el-radio-group v-model="states.emptyNotification" style="margin-bottom: 20px;">-->
            <!--<el-radio-button :label="false">expand</el-radio-button>-->
            <!--<el-radio-button :label="true">collapse</el-radio-button>-->
        <!--</el-radio-group>-->
        <!--<el-menu default-active="2" class="el-menu-vertical-demo" @open="handleOpen" @close="handleClose" :collapse="states.emptyNotification">-->
            <!--<el-menu-item index="2">-->
                <!--<i class="el-icon-menu"></i>-->
                <!--<span slot="title">Navigator Two</span>-->
            <!--</el-menu-item>-->
            <!--<el-menu-item index="3" disabled>-->
                <!--<i class="el-icon-document"></i>-->
                <!--<span slot="title">Navigator Three</span>-->
            <!--</el-menu-item>-->
            <!--<el-menu-item index="4">-->
                <!--<i class="el-icon-setting"></i>-->
                <!--<span slot="title">Navigator Four</span>-->
            <!--</el-menu-item>-->
        <!--</el-menu>-->
        <el-badge :value="1" :max="1000" class="item">
            <i class="fa fa-bell" aria-hidden="true"></i>
        </el-badge>
        <el-table
                v-loading="!states.isReadyReports"
                :data="reports"
                style="width: 100%"
                max-height="700"
        >
            <el-table-column
                    fixed
                    prop="name"
                    :label="columnsName.name"
                    width="150">
            </el-table-column>
            <el-table-column
                    prop="description"
                    :label="columnsName.description"
                    width="250">
            </el-table-column>
            <el-table-column
                    prop="date"
                    :label="columnsName.dateLastUpdate"
                    width="250">
            </el-table-column>
            <el-table-column
                    fixed="right"
                    :label="columnsName.operations"
                    width="120">
                <template slot-scope="scope">
                    <i class="fa fa-arrow-circle-down"
                       aria-hidden="true"
                       v-show="states.error === false && states.process === false"
                    ></i>
                    <i class="fa fa-exclamation-circle"
                       aria-hidden="true"
                       v-show="states.error"></i>
                    <i class="fa fa-refresh"
                       aria-hidden="true"
                       @click="handleClickDownload"
                       v-show="states.error === false && states.process === false"
                    ></i>
                    <i class="el-icon-loading" aria-hidden="true" v-show="states.process"></i>
                    <!--<i class="fa fa-file-excel-o" aria-hidden="true"></i>-->
                    <!--<el-button type="text" size="small"><i class="el-icon-download"></i></el-button>-->
                    <!--<el-button type="text" size="small">Download</el-button>-->
                </template>
            </el-table-column>
        </el-table>
    </el-row>
</div>
</template>
<style>

</style>
<script>
    export default {
        data(){
            return {
                states:{
                  process:false,
                  error:false,
                  emptyNotification:false,
                  isReadyReports:false,
                },
                columnsName:{
                    name:'',
                    description:'',
                    dateLastUpdate:'',
                    operations:'Operations'
                },
                reports:[],
                tableData: [{
                    name: 'Report Seller',
                    description: 'Report for sale seller',
                    date: '2018-01-23 11:43:13',
                }]
            }
        },
        methods :{
            handleClickDownload(){
                this.states.process = true;
            },
            handleOpen(key, keyPath) {
                console.log(key, keyPath);
            },
            handleClose(key, keyPath) {
                console.log(key, keyPath);
            }
        },
        created(){
            this.$http.get('/reports/api/dashboard.table.column')
                .then(response => {
                    this.columnsName =  response.data;
                });
            this.$http.get('/reports/api/dashboard.reports')
                .then(response => {
                    this.reports =  response.data.data;
                    this.states.isReadyReports = true;
                });
        }
    }
</script>

