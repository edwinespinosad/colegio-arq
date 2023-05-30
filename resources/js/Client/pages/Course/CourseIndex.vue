<template>
    <v-row>
        <v-col cols="9">
            <h1>{{ courses.name }}</h1>
        </v-col>
        <v-col cols="3" class="d-flex justify-end gap-2 align-center">
            <v-btn flat :color="btnColor" :href="courses.link_meet" target="_blank">Reunion</v-btn>
        </v-col>
    </v-row>


    <hr>
    <div>
        <p>{{ courses.description }}</p>
        <p>Duración: {{ courses.duration }}</p>
        <p>Requerimientos: {{ courses.requirements }}</p>
    </div>
    <hr>
    <v-card>
        <v-tabs
            v-model="tab"
            bg-color="#4a4cf6"
            class="text-white"
        >
            <v-tab value="one">Avisos</v-tab>
            <v-tab value="two">Unidades (Materiales y Examenes)</v-tab>
            <v-tab value="three">Actividades</v-tab>
        </v-tabs>

        <v-card-text>
            <v-window v-model="tab">
                <v-window-item value="one">
                    <Notices :courseId="this.courseId"></Notices>
                </v-window-item>

                <v-window-item value="two">
                    <Units :courseId="this.localCourseId"></Units>
                </v-window-item>

                <v-window-item value="three">
                    <Activities :courseId="this.courseId"></Activities>
                </v-window-item>
            </v-window>
        </v-card-text>
    </v-card>

<!--    <h2>Alumnos</h2>-->
<!--    <hr>-->
<!--    <v-data-table-->
<!--        v-model:items-per-page="itemsPerPage"-->
<!--        items-per-page-text="Registros por pagina"-->
<!--        :headers="headers"-->
<!--        :items="students"-->
<!--        item-value="name"-->
<!--        class=""-->
<!--    ></v-data-table>-->

</template>

<script>
import axios from "axios";
import {VDataTable} from 'vuetify/labs/VDataTable'
import Units from "../../components/Course/Units.vue";
import Activities from "../../components/Course/Activities.vue";
import Notices from "../../components/Course/Notices.vue";

export default {
    name: "CourseIndex",
    props: ['courseId'],
    components: {Notices, Activities, VDataTable, Units},
    data() {
        return {
            localCourseId: null,
            courses: [],
            students: [],
            headers: [
                {title: '#', align: 'start', key: 'id'},
                {title: 'Nombre', align: 'start', key: 'name'},
                {title: 'Apellido Paterno', align: 'start', key: 'middle_name'},
                {title: 'Apellido Materno', align: 'start', key: 'last_name'},
                {title: 'Correo', align: 'start', key: 'email'},
            ],
            itemsPerPage: 20,
            btnColor: '',
            tab: 'one'
        }
    },
    watch: {
        courseId() {
            location.reload()
        }
    },
    created() {
        this.localCourseId = this.courseId;
        this.fetchCourseData();
    },
    methods: {
        async fetchCourseData() {
            this.URL_GET_COURSE = route("student.get.course", {courseId: this.localCourseId});
            const response = await axios.get(this.URL_GET_COURSE);
            this.courses = response.data.data;
            this.students = this.courses.students;
            this.btnColor = response.data.data.link_meet.includes('zoom') ? 'blue' : 'purple';
        },
    },

}
</script>

<style scoped>

</style>
