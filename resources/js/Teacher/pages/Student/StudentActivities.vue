<template>
    <h2>Actividades: {{ name }}</h2>

    <h3>Promedio de Actividades: {{ average }} </h3>

    <Table
        :columns="columns"
        :url="url"
        :config="config"
        :updateFlag="updateFlag"
    >
        <template v-slot:link="{data}">
            <v-btn
                color="red"
                v-if="data.link !== null"
                flat
                class="lower-case"
                :href="data.link"
                target="_blank">
                {{ data.link.split('/')[3] }}
            </v-btn>
        </template>

        <template v-slot:delivered="{data}">
            <span
                :class="data.delivered ? 'text-success' : isPastLimitDate(data.limit_date) ? 'text-danger' : 'text-warning'">
            {{ data.delivered ? 'Entregada' : isPastLimitDate(data.limit_date) ? 'No entregada' : 'Aun no entregada' }}
            </span>
        </template>

        <template v-slot:qualification="{data}">
            {{ data.qualification === null ? 'Aun no calificada' : data.qualification }}
        </template>

        <template v-slot:action-slot="data">
            <FormQualification :data-update="data" @reload-grid="handleReloadGrid"></FormQualification>
        </template>
    </Table>

</template>

<script>
import axios from "axios";
import Table from "../../../Admin/commons/Table.vue";
import FormQualification from "../../components/Student/FormQualification.vue";

export default {
    name: "StudentActivities",
    props: ['courseId', 'studentId'],
    components: {Table, FormQualification},
    data() {
        return {
            activities: [],
            columns: [
                {
                    label: '#',
                    name: 'id'
                },
                {
                    label: "Actividad",
                    name: "title",
                },
                {
                    label: "Descripcion",
                    name: "description",
                },
                {
                    label: "Trabajo",
                    name: "link",
                    slot_name: 'link'
                },
                {
                    label: "Fecha Limite",
                    name: "limit_date",
                },
                {
                    label: "Entregada",
                    name: "delivered",
                    slot_name: 'delivered'
                },
                {
                    label: "Calificacion",
                    name: "qualification",
                    slot_name: 'qualification'
                },
            ],
            url: 'teacher.student.course.activities',
            config: {courseId: this.courseId, studentId: this.studentId},
            updateFlag: false,
            name: '',
            average: '',
        }
    },
    mounted() {
        this.getUser();
        this.getAverageUserActivities()
    },
    methods: {
        isPastLimitDate(limitDate) {
            const currentDate = new Date();
            const limitDateObj = new Date(limitDate);
            return currentDate > limitDateObj;
        },
        handleReloadGrid() {
            this.updateFlag = !this.updateFlag;
            this.getAverageUserActivities();
        },
        async getUser() {
            const response = await axios.get(route('teacher.get.student', {studentId: this.studentId}))
            this.name = response.data.data.name + ' ' + response.data.data.middle_name + ' ' +
                response.data.data.last_name
        },
        async getAverageUserActivities() {
            const response = await axios.get(route('teacher.average.student.activities', {
                courseId: this.courseId,
                studentId: this.studentId
            }))
            this.average = response.data.data
        },
    },
}
</script>

<style scoped>

</style>
