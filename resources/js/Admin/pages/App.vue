<template>
    <v-app>
        <Sidebar :items="items"></Sidebar>
        <v-main class="container">
            <router-view></router-view>
        </v-main>
    </v-app>
</template>

<script>
import Sidebar from "../commons/Sidebar.vue";

export default {
    name: "App",
    components: {Sidebar},
    data() {
        return {
            items: [
                {
                    icon: "mdi-account",
                    iconActive: "mdi-file-update",
                    text: "Usuarios",
                    route: "users",
                },
                {
                    icon: "mdi-account",
                    iconActive: "mdi-file-update",
                    text: "Profesores",
                    route: "teachers",
                },
                {

                    icon: "mdi-account-box",
                    iconActive: "mdi-file-update",
                    text: "Estudiantes",
                    route: "students",
                },
                {
                    icon: "mdi-book-open-page-variant",
                    iconActive: "mdi-file-update",
                    text: "Examenes",
                    route: "exams",
                },
                {
                    icon: "mdi-school",
                    iconActive: "mdi-file-update",
                    text: "Cursos",
                    route: "courses",
                },
            ],
        };
    },
};
</script>

<style scoped>
</style>
