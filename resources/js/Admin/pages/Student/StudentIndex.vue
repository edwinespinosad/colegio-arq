<template>
    <h1>Estudiantes</h1>
    <FormStudent :update="false" @reload-grid="handleReloadGrid"></FormStudent>
    <Table
        :columns="columns"
        :url="url"
        :updateFlag="updateFlag"
        :url-state="urlState"
        :toggle-switch="true"
    >
        <template v-slot:courses="{data}" class="d-flex flex-column">
            <div class="d-flex flex-column align-items-center justify-content-center">
                <p v-for="(item,i) in data.courses" :key="i">
                    {{ item.name }}
                </p>
            </div>
        </template>

        <template v-slot:action-slot="data">
            <FormStudent :update="true" :data-update="data" @reload-grid="handleReloadGrid"></FormStudent>
        </template>
    </Table>
</template>

<script>
import Table from "../../commons/Table.vue";
import FormStudent from "../../components/Student/FormStudent.vue";

export default {
    name: "StudentIndex",
    components: {FormStudent, Table},
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
                    label: "Telefono",
                    name: "phone",
                },
                {
                    label: "Correo",
                    name: "email",
                },
                {
                    label: "Cursos",
                    name: "courses",
                    slot_name: 'courses'
                },
            ],
            url: 'admin.student.index.content',
            urlState: 'admin.student.status',
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
