<template>
    <h1>Cursos</h1>
    <FormCourse :update="false" @reload-grid="handleReloadGrid"></FormCourse>

    <Table
        :columns="columns"
        :url="url"
        :updateFlag="updateFlag"
        :url-state="urlState"
        :toggle-switch="true"
    >
        <template v-slot:image="{data}">
            <v-img
                lazy-src="https://picsum.photos/200"
                style="height:100px; width: 100px"
                :src="data.image"
            ></v-img>
        </template>
        <template v-slot:action-slot="data">
            <FormCourse :update="true" :data-update="data" @reload-grid="handleReloadGrid"></FormCourse>
        </template>
    </Table>

</template>

<script>
import FormCourse from "../../components/Course/FormCourse.vue";
import Table from "../../commons/Table.vue";

export default {
    name: "CourseIndex",
    components: {FormCourse, Table},
    data() {
        return {
            updateFlag: false,
            columns: [
                {
                    label: '#',
                    name: 'id'
                },
                {
                    label: 'Imagen',
                    name: 'image',
                    slot_name: 'image'
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
                    label: "Duration",
                    name: "duration",
                    slot_name: 'duration'
                },
                {
                    label: "Requisitos",
                    name: "requirements",
                },
                {
                    label: "Precio",
                    name: "price",
                },
                {
                    label: "Categoria",
                    name: "type",
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
            url: 'admin.course.index.content',
            urlState: 'admin.course.status'
        }
    },
    methods: {
        handleReloadGrid() {
            this.updateFlag = !this.updateFlag;
        }
    },
}
</script>

<style scoped>

</style>
