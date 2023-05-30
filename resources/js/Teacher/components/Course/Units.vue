<template>
    <h2>Unidades</h2>

    <v-tabs
        v-model="tab"
        color="blue"
        align-tabs="center"
    >
        <v-tab :value="1">Unidad 1</v-tab>
        <v-tab :value="2">Unidad 2</v-tab>
        <v-tab :value="3">Unidad 3</v-tab>
    </v-tabs>
    <v-window v-model="tab">
        <v-window-item
            v-for="n in 3"
            :key="n"
            :value="n"
        >
            <v-container fluid>
                <v-row>
                    <v-col cols="12" class="mb-0 pb-0">
                        <h5>Examen</h5>
                    </v-col>
                    <template v-if="examMessage === '' ">
                        <v-col
                            class="mt-0 pt-0"
                            v-for="i in contentExam"
                            :key="i"
                            cols="12"
                            md="4"
                        >
                            <v-btn
                                color="red"
                                flat
                                :href="i.link"
                                target="_blank">
                                {{ i.name }}
                            </v-btn>
                        </v-col>
                    </template>
                    <template v-else>
                        <v-col
                            class="mt-0 pt-0"
                            cols="12"
                            md="4"
                        >
                            <p>No hay examen vinculado</p>
                        </v-col>
                    </template>

                    <v-col cols="12" class="mb-0 pb-0">
                        <h5>Materiales</h5>
                    </v-col>
                    <template v-if="contentMessage === '' ">

                        <v-col
                            class="mt-0 pt-0"
                            v-for="i in content"
                            :key="i"
                            cols="12"
                            md="4"
                        >
                            <div class="d-flex align-items-center gap-1">

                                <v-btn
                                    :color="i.material.icon === 'png' || i.material.icon === 'jpg' ? 'blue' : 'red'"
                                    flat
                                    :href="i.material.link"
                                    :prepend-icon="i.material.icon === 'png' || i.material.icon === 'jpg' ? 'mdi-image' : 'mdi-file-pdf-box'"
                                    target="_blank">
                                    {{ i.material.title }}
                                </v-btn>
                                <v-tooltip text="Eliminar" location="top">
                                    <template v-slot:activator="{ props }">
                                        <v-btn
                                            density="compact" icon="mdi-close" color="red" v-bind="props"
                                            @click="deleteFile(i.material.id)"></v-btn>
                                    </template>
                                </v-tooltip>
                            </div>
                        </v-col>
                    </template>
                    <template v-else>
                        <v-col
                            class="mt-0 pt-0"
                            cols="12"
                            md="4"
                        >
                            <p>No hay material publicado</p>
                        </v-col>
                    </template>

                </v-row>
            </v-container>
        </v-window-item>
    </v-window>
</template>

<script>
import axios from "axios";
import FormUnitMaterial from "../../components/Course/FormUnitMaterial.vue";
import FormActivity from "../../components/Course/FormActivity.vue";
import FormExam from "../../components/Course/FormExam.vue";

export default {
    name: "Units",
    components: {FormActivity, FormUnitMaterial, FormExam},
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
        this.getMaterial()
        this.getExam()
    },
    watch: {
        tab() {
            this.getMaterial()
            this.getExam()
        }
    },
    methods: {
        deleteFile(id) {
            console.log(id)
            this.$swal.fire({
                title: '¿Quieres eliminar el material?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'Cancelar',
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const response = await axios.delete(route('teacher.delete.material', {materialId: id}))
                    if (response.data.success) {
                        this.$swal.fire({
                            title: 'Material eliminado!',
                            icon: "success",
                            confirmButtonText: "Ok",
                            timer: 1500,
                        });
                        setTimeout(() => {
                            location.reload()
                        }, 1500)
                    } else {
                        this.$swal.fire({
                            title: 'Ocurrio un error!',
                            icon: "warning",
                            timer: 1500,
                        });
                    }
                }
            })


            // }
        },
        async getMaterial() {
            const response = await axios.get(route('teacher.unit.course.material', {
                courseId: this.courseId,
                unitId: this.tab
            }))
            this.content = response.data.data
            this.contentMessage = this.content.length === 0 ? 'No hay material' : ''
        },
        async getExam() {
            const response = await axios.get(route('teacher.unit.course.exam', {
                courseId: this.courseId,
                unitId: this.tab
            }))
            this.contentExam = response.data.data
            this.examMessage = this.contentExam.length === 0 ? 'No hay examen' : ''
        },
    },
}
</script>

<style scoped>

</style>
