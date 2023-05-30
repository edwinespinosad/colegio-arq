<template>
    <div class="text-cente">
        <v-dialog v-model="dialog" width="500">
            <template v-slot:activator="{ props }">

                <v-btn
                    flat
                    v-bind="props"
                    class="text-white bg-warning"
                >
                    Crear aviso
                </v-btn>
            </template>

            <v-card>
                <v-card-text class="p-4">
                    <v-row>
                        <v-col cols="11">
                            <h5 class="">
                                Crear aviso
                            </h5>
                        </v-col>
                        <v-col cols="1" @click="dialog = false">
                            <v-icon @click="close()" dark>mdi-close</v-icon>
                        </v-col>
                    </v-row>
                    <v-form ref="form" lazy-validation v-model="valid">
                        <v-row>
                            <v-col cols="12">
                                <p>Titulo de Aviso</p>
                                <v-text-field
                                    v-model="notice.title"
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
                                    v-model="notice.description"
                                    required
                                    dense
                                    dark
                                    auto-grow
                                    variant='outlined'
                                    color="#4a4cf6"
                                    :rules="rules.descriptionRule"
                                ></v-textarea>
                            </v-col>
                        </v-row>
                    </v-form>
                    <div class="text-center">
                        <button class="btn text-dark bg-blue-primary text-white" @click="save()">
                            Crear aviso
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
    name: "FormNotice",
    props: ['courseId'],
    data() {
        return {
            dialog: false,
            valid: true,
            notice: {
                id: "",
                title: "",
                description: "",
                fk_id_course: '',
            },
            rules: {
                titleRule: [(v) => !!v || "El titulo es requerido"],
                descriptionRule: [(v) => !!v || "La descripcion es requerida"],
            },
        }
    },
    created() {
        this.URL_CREATE_NOTICE = route('teacher.notice.create');
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
                let url = this.URL_CREATE_NOTICE

                let formData = new FormData();
                formData.append('title', this.notice.title);
                formData.append('description', this.notice.description);
                formData.append('fk_id_course', this.courseId);

                axios
                    .post(url, formData)
                    .then((response) => {
                        if (response.data.success) {
                            this.$swal.fire({
                                title: 'Aviso enviado!',
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
