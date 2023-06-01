<template>
    <h1>Usuarios</h1>
    <FormTeacher :update="false" @reload-grid="handleReloadGrid"></FormTeacher>

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
            <TeacherHasCourse :teacherData="data" @reload-grid="handleReloadGrid"></TeacherHasCourse>
            <FormTeacher :update="true" :data-update="data" @reload-grid="handleReloadGrid"></FormTeacher>
        </template>
    </Table>
</template>

<script>
import Table from "../../commons/Table.vue";
import FormTeacher from "../../components/Teacher/FormTeacher.vue";
import TeacherHasCourse from "../../components/Teacher/TeacherHasCourse.vue";

export default {
    name: "TeacherIndex",
    components: {TeacherHasCourse, FormTeacher, Table},
    data() {
        return {
            updateFlag: false,
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
                    label: "Apellidos",
                    name: "full_last_name",
                },
                {
                    label: "Edad",
                    name: "age",
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
                    'label': 'Cursos',
                    name: "courses",
                    slot_name: 'courses'
                }
            ],
            url: 'admin.teacher.index.content',
            urlState: 'admin.teacher.status'
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
