<template>
    <h1>Examenes</h1>
    <FormExam :update="false" @reload-grid="handleReloadGrid"></FormExam>
    <Table
        :columns="columns"
        :url="url"
        :update-flag="updateFlag"
    >
        <template v-slot:link="{data}">
            <a :href="data.link" target="_blank">
                {{ data.link }}
                <v-icon color="blue">
                    mdi-open-in-new
                </v-icon>
            </a>
        </template>

        <template v-slot:action-slot="data">
            <FormExam :update="true" :data-update="data" @reload-grid="handleReloadGrid"></FormExam>
        </template>
    </Table>
</template>

<script>
import FormExam from "../../components/Exam/FormExam.vue";
import Table from "../../commons/Table.vue";

export default {
    name: "ExamIndex",
    components: {FormExam, Table},
    data() {
        return {
            columns: [
                {
                    label: '#',
                    name: 'id'
                },
                {
                    label: "Nombre",
                    name: "name",
                },
                {
                    label: "Descripcion",
                    name: "description",
                },
                {
                    label: "Link",
                    name: "link",
                    slot_name: 'link'
                },
                {
                    label: "Fecha Inicial",
                    name: "format_date_ini",
                },
                {
                    label: "Fecha Final",
                    name: "format_date_fin",
                },
            ],
            url: 'admin.exam.index.content',
            updateFlag: false,
        }
    },
    methods: {
        handleReloadGrid() {
            this.updateFlag = !this.updateFlag;
        }
    },
};
</script>

<style scoped>
</style>
