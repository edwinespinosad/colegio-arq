<template>
    <div class="text-center">
        <v-dialog v-model="dialog" width="500">
            <template v-slot:activator="{ props }">
                <v-icon
                    v-if="update"
                    @click="getData(dataUpdate)"
                    color="blue"
                    v-bind="props"
                >
                    mdi-pencil
                </v-icon>
                <button
                    v-else
                    v-bind="props"
                    class="btn position-absolute top-2 end-0 text-white bg-blue-primary"
                >
                    Agregar examen
                </button>
            </template>

            <v-card>
                <v-card-text class="p-4">
                    <v-row>
                        <v-col cols="11">
                            <h5 class="">
                                {{ this.update ? "Editar examen" : "Agregar examen" }}
                            </h5>
                        </v-col>
                        <v-col cols="1" @click="dialog = false">
                            <v-icon @click="close()" dark>mdi-close</v-icon>
                        </v-col>
                    </v-row>
                    <v-form ref="form" lazy-validation v-model="valid">
                        <v-row>
                            <v-col cols="6">
                                <p>Nombre</p>
                                <v-text-field
                                    v-model="exam.name"
                                    required
                                    dense
                                    dark
                                    variant='outlined'
                                    color="#4a4cf6"
                                    :rules="rules.nameRule"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <p>Descripcion</p>
                                <v-text-field
                                    v-model="exam.description"
                                    required
                                    dense
                                    dark
                                    variant='outlined'
                                    color="#4a4cf6"
                                    :rules="rules.descriptionRule"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <p>Link</p>
                                <v-text-field
                                    v-model="exam.link"
                                    required
                                    dense
                                    dark
                                    variant='outlined'
                                    :rules="rules.linkRule"
                                    color="#4a4cf6"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <p>Fecha Inicial</p>
                                <v-text-field
                                    v-model="exam.date_ini"
                                    required
                                    dense
                                    dark
                                    type="date"
                                    variant='outlined'
                                    color="#4a4cf6"
                                    :rules="rules.date_iniRule"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <p>Fecha Final</p>
                                <v-text-field
                                    v-model="exam.date_fin"
                                    required
                                    dense
                                    dark
                                    type="date"
                                    variant='outlined'
                                    color="#4a4cf6"
                                    :rules="rules.date_finRule"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-form>
                    <div class="text-center">
                        <button class="btn text-dark bg-blue-primary text-white" @click="save()">
                            {{ this.update ? "Guardar examen" : "Agregar examen" }}
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
    name: "FormExam",
    props: {
        update: Boolean,
        dataUpdate: Object,
    },
    data() {
        return {
            dialog: false,
            valid: true,
            exam: {
                id: "",
                name: "",
                duration: "",
                price: "",
                benefits: "",
            },
            rules: {
                nameRule: [(v) => !!v || "El nombre es requerido"],
                descriptionRule: [(v) => !!v || "La descripcion es requerida"],
                linkRule: [(v) => !!v || "El link es requerido"],
                date_iniRule: [(v) => !!v || "La fecha es requerida"],
                date_finRule: [(v) => !!v || "La fecha es requerida"],
            },
        }
    },
    created() {
        this.URL_CREATE_EXAM = route('admin.exam.create');
        this.URL_UPDATE_EXAM = route('admin.exam.update', {examId: 'FAKE_ID'});
    },
    methods: {
        close() {
            this.dialog = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },
        getData(data) {
            this.exam.id = data.id;
            this.exam.name = data.name;
            this.exam.description = data.description;
            this.exam.link = data.link;
            this.exam.date_ini = data.date_ini.split('T')[0];
            this.exam.date_fin = data.date_fin.split('T')[0];
        },
        async save() {
            const {valid} = await this.$refs.form.validate();
            if (valid) {
                let url = !this.update ? this.URL_CREATE_EXAM : this.URL_UPDATE_EXAM.replace('FAKE_ID', this.dataUpdate.id);

                let formData = new FormData();
                formData.append('id', this.exam.id);
                formData.append('name', this.exam.name);
                formData.append('description', this.exam.description);
                formData.append('link', this.exam.link);
                formData.append('date_ini', this.exam.date_ini);
                formData.append('date_fin', this.exam.date_fin);

                axios
                    .post(url, formData)
                    .then((response) => {
                        if (response.data.success) {
                            this.$swal.fire({
                                title: !this.update ? "Examen agregado!" : 'Examen actualizado!',
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
