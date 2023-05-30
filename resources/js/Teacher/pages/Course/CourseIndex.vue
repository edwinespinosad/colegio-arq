<template>
    <v-row>
        <v-col cols="9">

            <h1>{{ courses.name }}</h1>
        </v-col>
        <v-col cols="3" class="d-flex justify-end gap-2 align-center">
            <v-btn flat :color="btnColor" :href="courses.link_meet" target="_blank">Reunion</v-btn>
            <FormNotice :course-id="this.localCourseId"></FormNotice>
        </v-col>
    </v-row>
    <hr>
    <div>
        <p>{{ courses.description }}</p>
        <p>Duración: {{ courses.duration }}</p>
        <p>Requerimientos: {{ courses.requirements }}</p>
    </div>

    <hr>

    <div class="d-flex gap-2">
        <FormUnitMaterial :courseId="this.courseId"></FormUnitMaterial>
        <FormActivity :courseId="this.courseId"></FormActivity>
        <FormExam :courseId="this.courseId"></FormExam>
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
            <v-tab value="three">Alumnos</v-tab>
        </v-tabs>

        <v-card-text>
            <v-window v-model="tab">
                <v-window-item value="one">

                </v-window-item>

                <v-window-item value="two">
                    <Units :courseId="this.localCourseId"></Units>
                </v-window-item>

                <v-window-item value="three">
                    <h2>Alumnos</h2>
                    <v-data-table
                        v-model:items-per-page="itemsPerPage"
                        items-per-page-text="Registros por pagina"
                        :headers="headers"
                        :items="students"
                        item-value="name"
                        class=""
                    >
                        <template v-slot:item.actions="{ item }">
                            <v-btn
                                class="me-2"
                                flat
                                color="blue-darken-4"
                                :to="{name: 'student', params:{courseId: this.courseId,studentId: item.props.title.id}}"
                            >
                                Actividades
                            </v-btn>
                        </template>

                    </v-data-table>
                </v-window-item>
            </v-window>
        </v-card-text>
    </v-card>

</template>

<script>
import axios from "axios";
import {VDataTable} from 'vuetify/labs/VDataTable'
import FormNotice from "../../components/Course/FormNotice.vue";
import Units from "../../components/Course/Units.vue";
import FormActivity from "../../components/Course/FormActivity.vue";
import FormUnitMaterial from "../../components/Course/FormUnitMaterial.vue";
import FormExam from "../../components/Course/FormExam.vue";

export default {
    name: "CourseIndex",
    props: ['courseId'],
    components: {Units, FormNotice, VDataTable, FormExam, FormActivity, FormUnitMaterial},
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
                {title: 'Actions', key: 'actions', sortable: false},
            ],
            itemsPerPage: 20,
            btnColor: '',
            tab: 'three',
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
            this.URL_GET_COURSE = route("teacher.get.course", {courseId: this.localCourseId});
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
