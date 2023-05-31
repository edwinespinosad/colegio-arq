<template>
    <v-switch v-model="isActive" inset @click="state()" color="blue-primary"></v-switch>
</template>

<script>
// import {bus} from "../../main.js";
import axios from "axios";

export default {
    props: {
        url: String,
        active: Boolean,
        id: Number,
    },
    data() {
        return {
            isActive: false,
        };
    },
    created() {
        this.isActive = this.active;
    },
    methods: {
        state() {
            this.$swal
                .fire({
                    icon: "warning",
                    title: "¿Deseas cambiar el estado?",
                    showCancelButton: true,
                    confirmButtonText: "Si",
                    cancelButtonText: `No`,
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .get(route(this.url, {id: this.id}))
                            .then((response) => {
                                if (response.data.success) {
                                    this.$swal.fire({
                                        title: "Estado cambiado!",
                                        icon: "success",
                                        confirmButtonText: "Ok",
                                        timer: 1500,
                                    });
                                    // bus.$emit("reload-grid");
                                } else {
                                    this.$swal.fire({
                                        title: "Error!",
                                        text: "Ocurrió un error inesperado",
                                        icon: "error",
                                        timer: 2000,
                                    });
                                }
                            });
                    } else {
                        this.isActive = !this.isActive;
                    }
                });
        },
    },
};
</script>

<style>
</style>
