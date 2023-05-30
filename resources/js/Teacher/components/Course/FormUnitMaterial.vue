<template>
    <div class="text-cente">
        <v-dialog v-model="dialog" width="500">
            <template v-slot:activator="{ props }">

                <v-btn
                    flat
                    v-bind="props"
                    class="text-white bg-warning"
                >
                    Agregar material
                </v-btn>
            </template>

            <v-card>
                <v-card-text class="p-4">
                    <v-row>
                        <v-col cols="11">
                            <h5 class="">
                                Agregar material
                            </h5>
                        </v-col>
                        <v-col cols="1" @click="dialog = false">
                            <v-icon @click="close()" dark>mdi-close</v-icon>
                        </v-col>
                    </v-row>
                    <v-form ref="form" lazy-validation v-model="valid" enctype="multipart/form-data">
                        <v-row>
                            <v-col cols="12">
                                <p>Titulo de Material</p>
                                <v-text-field
                                    v-model="material.title"
                                    required
                                    dense
                                    dark
                                    variant='outlined'
                                    :rules="rules.titleRule"
                                    color="#4a4cf6"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-select
                                    v-model="material.fk_id_unit"
                                    :items="units"
                                    item-title="name"
                                    item-value="id"
                                    single-line
                                    required
                                    dense
                                    dark
                                    variant='outlined'
                                    :rules="rules.unitRule"
                                    color="#4a4cf6"
                                ></v-select>
                            </v-col>
                            <v-col cols="12">
                                <p>Archivo</p>
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
                            </v-col>
                        </v-row>
                    </v-form>
                    <div class="text-center">
                        <button class="btn text-dark bg-blue-primary text-white" @click="save()">
                            Subir material
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
    name: "FormUnitMaterial",
    props: ['courseId'],
    data() {
        return {
            dialog: false,
            valid: true,
            file: [],
            material: {
                id: "",
                title: "",
                fk_id_unit: '',
                fk_id_course: '',
            },
            units: [
                {id: 1, name: 'Unidad 1'},
                {id: 2, name: 'Unidad 2'},
                {id: 3, name: 'Unidad 3'},
            ],
            rules: {
                titleRule: [(v) => !!v || "El titulo es requerido"],
                fileRule: [(v) => !!v || "El archivo es requerido"],
                unitRule: [(v) => !!v || "La unidad es requerida"],
            },
        }
    },
    created() {
        this.URL_CREATE_MATERIAL = route('teacher.unit.material.create');
    },
    mounted() {
        console.log(this.courseId)
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
                formData.append('title', this.material.title);
                formData.append('file', this.file[0]);
                formData.append('fk_id_course', this.courseId);
                formData.append('fk_id_unit', this.material.fk_id_unit);

                axios
                    .post(url, formData)
                    .then((response) => {
                        if (response.data.success) {
                            this.$swal.fire({
                                title: 'Material publicado!',
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
