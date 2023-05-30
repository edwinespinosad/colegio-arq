<template>
    <Sidebar :items="items" :courses="courses"></Sidebar>
    <div class="container">
        <router-view></router-view>
    </div>
</template>

<script>
import Sidebar from "../commons/Sidebar.vue";
import axios from "axios";

export default {
    name: "App",
    components: {Sidebar},
    data() {
        return {
            courses: [],
            items: [
                {
                    icon: "mdi-file-outline",
                    iconActive: "mdi-file-update",
                    text: "Inicio",
                    route: "home",
                },
            ]
        }
    },
    mounted() {
        this.getCourses()
    },
    methods: {
        async getCourses() {
            const response = await axios.get(route('student.get.courses'))
            this.courses = response.data.data;
        }
    }
}
</script>
<style>

</style>
