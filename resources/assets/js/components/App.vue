<script type="text/ecmascript-6">
    export default {
        name: 'App'
    };
</script>

<template>
    <table-reports></table-reports>
</template>

<script>
    import TableReports from '../pages/Table-Reports.vue';
    export default {
        components: {
            'table-reports': TableReports
        }
    }
</script>