<template>
<div>
    <el-row>
        <el-badge :value="countNotification" :max="1000" class="item">
            <i class="fa fa-bell" aria-hidden="true"></i>
        </el-badge>
        <el-table
                :row-class-name="tableRowClassName"
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
                    prop="lastModified"
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
                       v-show="states.error === false && scope.row.status !== 'process' && scope.row.path !== null"
                    ></i>
                    <i class="fa fa-exclamation-circle"
                       aria-hidden="true"
                       v-show="states.error"></i>
                    <i class="fa fa-refresh"
                       aria-hidden="true"
                       @click="updateReport(scope.row)"
                       v-show="states.error === false && scope.row.status !== 'process'"
                    ></i>
                    <i class="el-icon-loading" aria-hidden="true" v-show="scope.row.status === 'process'"></i>
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
    .el-table .is-complited-row {
        background: #f0f9eb;
    }
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
                countNotification:0,
            }
        },
        methods :{
            tableRowClassName({row, rowIndex}) {
                if (row.isCompleted !== undefined && row.isCompleted === true) {
                    return 'is-complited-row';
                }
                return '';
            },
            updateReport(report){
                this.states.process = true;
                this.$http.post('/reports/api/dashboard.reports.update', report)
                .then(response => {

                });
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
                })
                .catch(error => {
                    this.$notify({
                        message: error.message,
                        type: 'warning'
                    });
                });
            this.$http.get('/reports/api/dashboard.reports.notificationCount')
                .then(response => {
                    this.countNotification = response.data.data.count;
                });
        }
    }
</script>

