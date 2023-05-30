<template>
    <h2>Actividades</h2>


    <v-row v-if="sortedContent.length > 0">
        <v-col cols="12">
            <h3>Promedio de Actividades: {{ average }} </h3>
        </v-col>
        <v-col
            v-for="item in sortedContent" :key="item.id"
            cols="12"
        >
            <v-card
                :color="item.delivered ? 'green-darken-4' : isPastLimitDate(item.limit_date) ? 'red-darken-4' : '#385F73'"
                theme="dark"
                class="py-2 pb-4"
            >
                <router-link :to="{name: 'activity', params:{courseActivityId: item.fk_id_course_has_activity}}"
                             class="text-decoration-none text-white">
                    <v-card-title class="text-h5" v-text="item.title"></v-card-title>
                    <v-card-subtitle v-text="item.limit_date"></v-card-subtitle>

                    <div v-if="item.delivered" class="position-absolute top-40 end-0 pr-10 pb-5 d-flex gap-2">
                        <p v-if="item.qualification !== null">Calificacion: {{ item.qualification }}</p>
                        <v-icon>mdi-check</v-icon>
                    </div>
                    <div v-if="!item.delivered && isPastLimitDate(item.limit_date)"
                         class="position-absolute top-40 end-0 pr-10 pb-5 d-flex gap-2">
                        <p>Calificacion: {{ item.qualification !== null ? item.qualification : '0' }}</p>
                        <v-icon>
                            mdi-close
                        </v-icon>
                    </div>

                </router-link>
            </v-card>
        </v-col>
    </v-row>

    <v-row v-else>
        <v-col cols="12">
            <h5 class="text-center">Sin actividades!</h5>
        </v-col>
    </v-row>
</template>

<script>
import axios from "axios";

export default {
    name: "Activities",
    props: ['courseId'],
    data() {
        return {
            tab: null,
            content: [],
            contentExam: [],
            examMessage: '',
            contentMessage: '',
            average: '',
        }
    },
    mounted() {
        this.getActivities();
        this.getAverageUserActivities();
    },
    computed: {
        sortedContent() {
            return this.content.slice().sort((a, b) => {
                const currentDate = new Date();
                const limitDateA = new Date(a.limit_date);
                const limitDateB = new Date(b.limit_date);

                if (a.delivered && !b.delivered) {
                    return 1;
                } else if (!a.delivered && b.delivered) {
                    return -1;
                } else if ((currentDate > limitDateA) && !(currentDate > limitDateB)) {
                    return 1;
                } else if (!(currentDate > limitDateA) && (currentDate > limitDateB)) {
                    return -1;
                } else {
                    return 0;
                }
            });
        }
    },
    methods: {
        isPastLimitDate(limitDate) {
            const currentDate = new Date();
            const limitDateObj = new Date(limitDate);
            return currentDate > limitDateObj;
        },
        async getActivities() {
            const response = await axios.get(route('student.course.activities', {
                courseId: this.courseId,
                studentId: localStorage.getItem('id')
            }))
            this.content = response.data.data
            this.contentMessage = this.content.length === 0 ? 'No hay actividades' : ''
        },
        async getAverageUserActivities() {
            const response = await axios.get(route('student.average.activities', {
                courseId: this.courseId,
                studentId: localStorage.getItem('id')
            }))
            this.average = response.data.data
        },
    },
}
</script>

<style scoped>

</style>
