<template>

    <v-row>
        <v-col cols="10">
            <h2>{{ content.title }}</h2>
            <p>{{ content.description }}</p>
        </v-col>
        <v-col cols="2" align-self="center" class="text-end">
            <v-btn color="blue-darken-4" theme="dark" :disabled="content.delivered || isPastLimitDate" @click="save()">
                {{ buttonText }}
            </v-btn>
        </v-col>

        <v-col cols="12">
            <p>Fecha limite: {{ content.limit_date }}</p>
        </v-col>

        <v-col cols="12" v-if="content.help_material !== null">
            <p>Material de apoyo</p>
            <v-btn color="blue-darken-4" theme="dark" :ripple="false"
                   :href="content.help_material"
                   target="_blank">
                {{ content.help_material !== null ? content.help_material.split('/')[3] : ''}}
            </v-btn>
        </v-col>

        <v-col cols="12">
            <p>Mi trabajo</p>


            <v-form ref="form" lazy-validation v-model="valid"
                    v-if="!content.delivered && !limitDate(content.limit_date)">
                <v-file-input
                    v-model="file"
                    required
                    dense
                    dark
                    clearable
                    variant='outlined'
                    color="#4a4cf6"
                    :rules="rules.fileRule"
                ></v-file-input>
            </v-form>

            <v-btn v-else-if="content.delivered" color="blue-darken-4" theme="dark" :ripple="false" :href="content.link"
                   target="_blank"
                   download
                   @click="downloadFile(content.link)">
                {{ content.link }}
            </v-btn>

            <p v-else="isPastLimitDate" class="text-danger fst-italic">Actividad vencida y no entregada</p>


        </v-col>
    </v-row>

</template>

<script>
import axios from "axios";

export default {
    name: "ActivityIndex",
    props: ['courseActivityId'],
    data() {
        return {
            content: [],
            valid: false,
            file: [],
            rules: {
                fileRule: [(v) => !!v || "El archivo es requerido"],
            },
        }
    },
    created() {
        this.getActivity()
        this.URL_UPLOAD_ACTIVITY = route('student.course.upload.activity');
    },
    computed: {
        isPastLimitDate() {
            const limitDate = new Date(this.content.limit_date);
            const currentDate = new Date();
            return currentDate > limitDate;
        },
        buttonText() {
            if (this.content.delivered) {
                return 'Entregado';
            } else if (this.isPastLimitDate) {
                return 'Vencida';
            } else {
                return 'Entregar';
            }
        },
    },
    methods: {
        limitDate(date) {
            const limitDate = new Date(date);
            const currentDate = new Date();
            return currentDate > limitDate;
        },
        downloadFile(fileUrl) {
            window.open(fileUrl, '_blank');
        },
        async getActivity() {
            const response = await axios.get(route('student.course.activity', {
                courseActivityId: this.courseActivityId,
                studentId: localStorage.getItem('id')
            }))
            this.content = response.data.data[0]
        },
        async save() {
            const {valid} = await this.$refs.form.validate();
            if (valid) {
                let url = this.URL_UPLOAD_ACTIVITY

                let formData = new FormData();
                formData.append('file', this.file[0]);
                formData.append('fk_id_course_has_activity', this.courseActivityId);
                formData.append('fk_id_student', localStorage.getItem('id'));

                axios
                    .post(url, formData)
                    .then((response) => {
                        if (response.data.success) {
                            this.$swal.fire({
                                title: 'Actividad entregada!',
                                icon: "success",
                                confirmButtonText: "Ok",
                                timer: 1500,
                            });
                            this.$refs.form.reset();
                            setTimeout(() => {
                                location.reload()
                            }, 1500)
                        } else {
                            if (response.data.limit_date) {
                                this.$swal.fire({
                                    title: "Error!",
                                    text: response.data.message,
                                    icon: "error",
                                    timer: 2000,
                                });
                            } else {
                                this.$swal.fire({
                                    title: "Error!",
                                    text: "Verifica los campos ingresados",
                                    icon: "error",
                                    timer: 2000,
                                });
                            }
                        }
                    });
            }
        },
    },
}
</script>

<style scoped>

</style>
