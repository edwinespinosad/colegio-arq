<template>
    <div class="mr-2">
        <v-dialog v-model="dialog" width="500">
            <template v-slot:activator="{ props }">
                <v-btn
                    v-bind="props"
                    flat
                    color="green"
                    dark
                    class="capital-case"
                    @click="getData(teacherData)"
                >
                    Asignar curso
                </v-btn>
            </template>

            <v-card color="">
                <v-card-text class="p-4">
                    <v-row>
                        <v-col cols="11">
                            <h5 class="">
                                Asignar curso
                            </h5>
                        </v-col>
                        <v-col cols="1" @click="close()">
                            <v-icon dark>mdi-close</v-icon>
                        </v-col>
                    </v-row>
                    <v-form ref="form" lazy-validation v-model="valid">
                        <v-row>

                            <v-col cols="12">
                                <p>Curso</p>

                                <v-combobox
                                    clearable
                                    chips
                                    v-model="course.name"
                                    color="#4a4cf6"
                                    required
                                    dark
                                    :items="courses"
                                    variant="outlined"
                                ></v-combobox>
                            </v-col>

                        </v-row>
                    </v-form>
                    <div class="text-center">
                        <button class="btn text-dark bg-blue-primary text-white" @click="save()">
                            Asignar curso
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
    name: "TeacherHasCourse",
    props: ['teacherData'],
    data() {
        return {
            course: {
                name: null
            },
            dialog: false,
            valid: false,
            courses: [],
            teacherCourses: [],
            coursesComplete: [],
        }
    },
    created() {
        this.getAllCourses();
    },
    methods: {
        getData(data) {
        },
        close() {
            this.dialog = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },
        async getAllCourses() {
            this.teacherCourses = this.teacherData.courses.map(course => course.name)
            const response = await axios.get(route('admin.teacher.all.courses'))

            this.coursesComplete = response.data.data

            this.courses = response.data.data.map(course => course.name);

            this.courses = this.courses.filter(course => !this.teacherCourses.some(teacherCourse => teacherCourse === course));
        },
        async save() {
            const {valid} = await this.$refs.form.validate();
            if (valid) {
                let url = route('admin.teacher.assign.course');

                const searchedCourse = this.coursesComplete.find(course => course.name === this.course.name);

                console.log(searchedCourse.id)
                // if(searchedCourse === undefined){
                //
                // }else{

                let formData = new FormData();
                formData.append('fk_id_course', searchedCourse.id);
                formData.append('fk_id_teacher', this.teacherData.id);

                axios
                    .post(url, formData)
                    .then((response) => {
                        if (response.data.success) {
                            this.$swal.fire({
                                title: 'Curso asignado!',
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
