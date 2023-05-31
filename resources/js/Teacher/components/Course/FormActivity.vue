<template>
    <div class="text-cente">
        <v-dialog v-model="dialog" width="500">
            <template v-slot:activator="{ props }">

                <v-btn
                    flat
                    v-bind="props"
                    class="text-white bg-primary"
                >
                    Agregar actividad
                </v-btn>
            </template>

            <v-card>
                <v-card-text class="p-4">
                    <v-row>
                        <v-col cols="11">
                            <h5 class="">
                                Agregar actividad
                            </h5>
                        </v-col>
                        <v-col cols="1" @click="dialog = false">
                            <v-icon @click="close()" dark>mdi-close</v-icon>
                        </v-col>
                    </v-row>
                    <v-form ref="form" lazy-validation v-model="valid">
                        <v-row>
                            <v-col cols="12">
                                <p>Titulo de Actividad</p>
                                <v-text-field
                                    v-model="activity.title"
                                    required
                                    dense
                                    dark
                                    variant='outlined'
                                    :rules="rules.titleRule"
                                    color="#4a4cf6"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <p>Descripcion</p>
                                <v-textarea
                                    v-model="activity.description"
                                    required
                                    dense
                                    dark
                                    auto-grow
                                    variant='outlined'
                                    color="#4a4cf6"
                                    :rules="rules.descriptionRule"
                                ></v-textarea>
                            </v-col>
                            <v-col cols="12">
                                <p>Archivo de ayuda (Opcional)</p>
                                <v-file-input
                                    v-model="file"
                                    required
                                    dense
                                    dark
                                    clearable
                                    variant='outlined'
                                    color="#4a4cf6"
                                ></v-file-input>
                            </v-col>
                            <v-col cols="12">
                                <p>Fecha limite</p>
                                <VueDatePicker v-model="activity.date_fin"
                                ></VueDatePicker>
                            </v-col>
                        </v-row>
                    </v-form>
                    <div class="text-center">
                        <button class="btn text-dark bg-blue-primary text-white" @click="save()">
                            Subir actividad
                        </button>
                    </div>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import axios from "axios";
import TimePicker from "../../commons/TimePicker.vue";

export default {
    name: "FormActivity",
    props: ['courseId'],
    components: {TimePicker},
    data() {
        return {
            dialog: false,
            valid: true,
            file: [],
            activity: {
                id: "",
                title: "",
                date_fin: '',
                description: '',
            },
            rules: {
                titleRule: [(v) => !!v || "El titulo es requerido"],
                date_finRule: [(v) => !!v || "La fecha limite es requerida"],
                // time_finRule: [(v) => !!v || "La hora limite es requerida"],
                descriptionRule: [(v) => !!v || "La descripcion es requerida"],
            },
        }
    },
    created() {
        this.URL_CREATE_MATERIAL = route('teacher.course.create.activity');
    },
    methods: {
        close() {
            this.dialog = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },
        async save() {
            const {valid} = await this.$refs.form.validate();
            if (valid) {
                let url = this.URL_CREATE_MATERIAL

                let formData = new FormData();
                formData.append('title', this.activity.title);
                formData.append('description', this.activity.description);
                formData.append('fk_id_course', this.courseId);
                formData.append('file', this.file[0]);

                // Obtener la fecha y hora ingresada por el usuario
                const fechaHora = new Date(this.activity.date_fin);

                const year = fechaHora.getFullYear();
                const month = fechaHora.getMonth() + 1; // Los meses en JavaScript son base 0
                const day = fechaHora.getDate();
                const hour = fechaHora.getHours();
                const minute = fechaHora.getMinutes();

                const formattedFechaHora = `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')} ${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;

                formData.append('limit_date', formattedFechaHora);
                console.log(new Date(this.activity.date_fin).toISOString())
                axios
                    .post(url, formData)
                    .then((response) => {
                        if (response.data.success) {
                            this.$swal.fire({
                                title: 'Actividad publicada!',
                                icon: "success",
                                confirmButtonText: "Ok",
                                timer: 1500,
                            });
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
    }
}
</script>

<style scoped>

</style>
