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
                    Agregar curso
                </button>
            </template>

            <v-card>
                <v-card-text class="p-4">
                    <v-row>
                        <v-col cols="11">
                            <h5 class="">
                                {{ this.update ? "Editar curso" : "Agregar curso" }}
                            </h5>
                        </v-col>
                        <v-col cols="1" @click="dialog = false">
                            <v-icon @click="close()" dark>mdi-close</v-icon>
                        </v-col>
                    </v-row>
                    <v-form ref="form" lazy-validation v-model="valid">
                        <v-row>
                            <v-col
                                cols="12"
                                class="d-flex flex-column justify-content-center align-items-center"
                            >
                                <input
                                    required
                                    v-show="false"
                                    ref="photo"
                                    type="file"
                                    accept="image/*"
                                    @change="onFileChanged"
                                />
                                <div
                                    class="drop text-center"
                                    style="margin-bottom: 4px; cursor: pointer; display: flex"
                                >
                                    <div
                                        class="mb-2 row d-flex justify-content-center align-items-center"
                                        style="height: 110px; width: 110px"
                                    >
                                        <v-img
                                            :src="view_image"
                                            v-if="image !== null"
                                            @click="selectImage"
                                            max-width="109"
                                            max-height="109"
                                            width="109"
                                            height="109"
                                            style="
                                                cursor: pointer;
                                                margin-top: -2px;
                                                margin-right: -1px;
                                              "
                                        ></v-img>
                                        <v-icon v-else @click="selectImage"
                                        >mdi-file-image
                                        </v-icon>
                                    </div>
                                </div>
                                <p v-if="validImage" class="text-danger">
                                    La imagen es necesaria
                                </p>
                            </v-col>

                            <v-col cols="6">
                                <p>Nombre</p>
                                <v-text-field
                                    v-model="course.name"
                                    required
                                    dense
                                    dark
                                    variant='outlined'
                                    :rules="rules.nameRule"
                                    color="#4a4cf6"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <p>Duracion</p>
                                <v-text-field
                                    v-model="course.duration"
                                    required
                                    dense
                                    dark
                                    variant='outlined'
                                    :rules="rules.durationRule"
                                    color="#4a4cf6"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <p>Descripcion</p>
                                <v-text-field
                                    v-model="course.description"
                                    required
                                    dense
                                    dark
                                    variant='outlined'
                                    color="#4a4cf6"
                                    :rules="rules.descriptionRule"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <p>Requerimientos</p>
                                <v-text-field
                                    v-model="course.requirements"
                                    required
                                    dense
                                    dark
                                    variant='outlined'
                                    color="#4a4cf6"
                                    :rules="rules.requirementsRule"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <p>Precio</p>
                                <v-text-field
                                    v-model="course.price"
                                    required
                                    dense
                                    type="number"
                                    dark
                                    variant='outlined'
                                    :rules="rules.priceRule"
                                    color="#4a4cf6"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <p>Categoria</p>
                                <v-text-field
                                    v-model="course.type"
                                    required
                                    dense
                                    dark
                                    variant='outlined'
                                    color="#4a4cf6"
                                    :rules="rules.typeRule"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <p>Fecha Inicial</p>
                                <v-text-field
                                    v-model="course.date_ini"
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
                                    v-model="course.date_fin"
                                    required
                                    dense
                                    dark
                                    variant='outlined'
                                    color="#4a4cf6"
                                    :rules="rules.date_finRule"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-form>
                    <div class="text-center">
                        <button class="btn text-dark bg-blue-primary text-white" @click="save()">
                            {{ this.update ? "Guardar curso" : "Agregar curso" }}
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
    name: "FormCourse",
    props: {
        update: Boolean,
        dataUpdate: Object,
    },
    data() {
        return {
            dialog: false,
            valid: true,
            course: {
                id: "",
                name: "",
                duration: "",
                description: "",
                price: "",
                requirements: "",
                type: '',
                date_ini: "",
                date_fin: "",
            },
            rules: {
                nameRule: [(v) => !!v || "El nombre es requerido"],
                descriptionRule: [(v) => !!v || "La descripcion es requerida"],
                durationRule: [(v) => !!v || "La duracion es requerida"],
                typeRule: [(v) => !!v || "La categoria es requerida"],
                requirementsRule: [(v) => !!v || "Los requerimientosson requeridos"],
                priceRule: [(v) => !!v || "El precio es requerido"],
                date_iniRule: [(v) => !!v || "La fecha es requerida"],
                date_finRule: [(v) => !!v || "La fecha es requerida"],
            },
            image: null,
            view_image: "",
            validImage: false,
            loading: false,
            change_image: false,
        }
    },
    created() {
        this.URL_CREATE_EXAM = route('admin.course.create');
        this.URL_UPDATE_EXAM = route('admin.course.update', {courseId: 'FAKE_ID'});
    },
    watch: {
        image(file) {
            if (typeof file !== 'string') this.view_image = URL.createObjectURL(file);
            else this.view_image = file;
        },
    },
    methods: {
        close() {
            this.dialog = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },
        onFileChanged(e) {
            this.image = e.target.files[0];
            this.validImage = false;
        },
        selectImage() {
            this.$refs.photo.click();
        },
        getData(data) {
            this.course.id = data.id;
            this.course.name = data.name;
            this.course.description = data.description;
            this.course.duration = data.duration;
            this.course.requirements = data.requirements;
            this.course.price = data.price;
            this.course.type = data.type;
            this.course.date_ini = data.date_ini;
            this.course.date_fin = data.date_fin;
            this.image = data.image
        },
        async save() {
            const {valid} = await this.$refs.form.validate();
            if (valid && this.image !== null) {
                let url = !this.update ? this.URL_CREATE_EXAM : this.URL_UPDATE_EXAM.replace('FAKE_ID', this.dataUpdate.id);

                let formData = new FormData();
                formData.append('id', this.course.id);
                formData.append('name', this.course.name);
                formData.append('duration', this.course.duration);
                formData.append('description', this.course.description);
                formData.append('requirements', this.course.requirements);
                formData.append('price', this.course.price);
                formData.append('type', this.course.type);
                formData.append('date_ini', this.course.date_ini);
                formData.append('date_fin', this.course.date_fin);
                formData.append('image', this.image);

                axios
                    .post(url, formData)
                    .then((response) => {
                        if (response.data.success) {
                            this.$swal.fire({
                                title: !this.update ? "Curso agregado!" : 'Curso actualizado!',
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

            } else if (this.image === null) {
                this.validImage = true;
            }
        },
    },
}
</script>

<style scoped>

</style>
