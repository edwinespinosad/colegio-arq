<template>
    <div class="text-center">
        <v-dialog v-model="dialog" width="500">
            <template v-slot:activator="{ props }">

                <button
                    v-bind="props"
                    @click="getData(dataUpdate)"
                    class="btn text-white bg-blue-primary"
                >
                    {{ dataUpdate.qualification !== null ? 'Modificar calificacion' : 'Calificar'}}
                </button>
            </template>

            <v-card>
                <v-card-text class="p-4">
                    <v-row>
                        <v-col cols="11">
                            <h5 class="">
                                Calificar
                            </h5>
                        </v-col>
                        <v-col cols="1" @click="dialog = false">
                            <v-icon @click="close()" dark>mdi-close</v-icon>
                        </v-col>
                    </v-row>
                    <v-form ref="form" lazy-validation v-model="valid">
                        <v-row>
                            <v-col cols="12">
                                <p>Calificacion</p>
                                <v-text-field
                                    v-model="qualification"
                                    required
                                    dense
                                    dark
                                    type="number"
                                    variant='outlined'
                                    :rules="rules.qualificationRule"
                                    color="#4a4cf6"
                                ></v-text-field>
                            </v-col>

                        </v-row>
                    </v-form>
                    <div class="text-center">
                        <button class="btn text-dark bg-blue-primary text-white" @click="save()">
                            Enviar calificacion
                        </button>
                    </div>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "FormQualification",
    props: {
        dataUpdate: Object,

    },
    data() {
        return {
            dialog: false,
            valid: true,
            qualification: '',
            studentId: '',
            courseId: '',
            rules: {
                qualificationRule: [
                    (v) => !!v || "La calificacion es requerida",
                    (v) => /^10$|^\d(\.\d)?$/.test(v) || "La calificación debe ser un número de 0 a 10"
                ],
            },
        }
    },
    created() {
        this.URL_UPDATE_EXAM = route('admin.course.update', {studentId: 'FAKE_ID', courseId: 'FAKE_ID'});
    },
    methods: {
        close() {
            this.dialog = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },
        getData(data) {
            this.qualification = data.qualification
            this.studentId = data.fk_id_student;
            this.courseId = data.fk_id_course_has_activity;
        },
        async save() {
            const {valid} = await this.$refs.form.validate();
            if (valid) {
                let url = route('teacher.activity.student.update', {studentId: this.studentId, courseId: this.courseId})

                let formData = new FormData();
                formData.append('qualification', this.qualification);

                axios
                    .post(url, formData)
                    .then((response) => {
                        if (response.data.success) {
                            this.$swal.fire({
                                title: 'Calificacion enviada',
                                icon: "success",
                                confirmButtonText: "Ok",
                                timer: 1500,
                            });
                            this.$emit('reload-grid')
                            this.dialog = false;
                            this.$refs.form.reset();
                        } else {
                            this.$swal.fire({
                                title: "Error!",
                                text: "Verifica los campos ingresados",
                                icon: "error",
                                timer: 2000,
                            });
                        }
                    });

            }
        },
    },
}
</script>

<style scoped>

</style>
