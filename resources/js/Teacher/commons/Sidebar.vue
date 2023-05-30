<template>
    <nav class="navbar navbar-expand-lg bg-blue-primary text-white">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/assets/images/admin/icon.png" alt="logo" width="50">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link :to="{ name: 'home' }" class="router nav-link text-white">
                            Inicio
                        </router-link>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Mis cursos
                        </a>
                        <ul class="dropdown-menu">
                            <li v-for="item in this.courses" :key="item.id">
                                <router-link :to="{name: 'course', params:{courseId: item.id}}"
                                             class="router dropdown-item text-decoration-none">
                                    {{ item.name }}
                                </router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="d-flex">
                    <button class="btn btn-danger text-white" @click="logout">Cerrar sesion</button>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import axios from "axios";

export default {
    name: "Sidebar",
    props: {
        items: {
            required: true,
        },
        courses: {
            required: true,
        },
    },
    data() {
        return {};
    },
    created() {
        this.URL_LOGOUT = route('teacher.logout');
    },
    methods: {
        async logout(){
            localStorage.clear();
            sessionStorage.clear()
            await axios.get(this.URL_LOGOUT);
            window.location.href = "/teacher/login";
        }
    }
};
</script>

<style scoped>
</style>
