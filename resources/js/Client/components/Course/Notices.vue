<template>
    <h2>Avisos</h2>

    <v-row v-if="content.length > 0">
        <v-col
            v-for="item in content" :key="item.id"
            cols="4"
        >
            <v-card
                color="orange-darken-2"
                theme="dark"
                class="py-2 pb-4"
            >
                <v-card-title class="text-h5" v-text="item.title"></v-card-title>
                <v-card-subtitle>Publicado: {{ item.created_at }}</v-card-subtitle>
                <v-card-text v-text="item.description"></v-card-text>
            </v-card>
        </v-col>
    </v-row>

    <v-row v-else>
        <v-col cols="12">
            <h5 class="text-center">No hay avisos!</h5>
        </v-col>
    </v-row>
</template>

<script>
import axios from "axios";

export default {
    name: "Notices",
    props: ['courseId'],
    data() {
        return {
            tab: null,
            content: [],
            contentExam: [],
            examMessage: '',
            contentMessage: '',
        }
    },
    mounted() {
        this.getNotices()
    },
    methods: {
        async getNotices() {
            const response = await axios.get(route('student.course.notices', {
                courseId: this.courseId,
            }))
            this.content = response.data.data
            this.contentMessage = this.content.length === 0 ? 'No hay actividades' : ''
        },
    },
}
</script>

<style scoped>

</style>
