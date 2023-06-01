<template>
    <v-navigation-drawer
        v-model="drawer"
        permanent
    >
        <v-list-item
            class="d-flex justify-content-center align-items-center"
        >
            <v-img
                :width="100"
                src="/assets/images/admin/icon.png"
                contain
            ></v-img>
        </v-list-item>

        <v-divider></v-divider>

        <v-list density="compact" nav>
            <template
                v-for="(item, i) in items"
            >
                <v-list-item
                    :prepend-icon="item.icon" :title="item.text" :value="item.route" :to="{name: item.route}"
                    :class="{ 'br-left-30 br-right-30 bg-blue-primary text-white': activeItem === item.route }"
                    @click="activeItem = item.route"
                ></v-list-item>
            </template>
            <br>
            <v-list-item
                prepend-icon="mdi-logout" title="Cerrar sesion" value="logout"
                @click="logout()"
            ></v-list-item>

        </v-list>
    </v-navigation-drawer>
</template>

<script>
import axios from "axios";
export default {
    name: "Sidebar",
    props: {
        items: {
            required: true,
        },
    },
    data() {
        return {
            selectedItem: 0,
            drawer: true,
            activeItem: ''
        };
    },
    created() {
        this.activeItem = this.$route.name;
        this.URL_LOGOUT = route('admin.logout');
    },
    methods:{
        async logout() {
            // this.active = true;
            localStorage.clear();
            sessionStorage.clear()
            await axios.get(this.URL_LOGOUT);
            window.location.href = "/admin/login";
        }
    }

};
</script>

<style scoped>
</style>
