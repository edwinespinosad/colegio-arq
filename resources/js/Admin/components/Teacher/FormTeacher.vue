<template>
    <div>
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
                    Agregar profesor
                </button>
            </template>

            <v-card color="">
                <v-card-text class="p-4">
                    <v-row>
                        <v-col cols="11">
                            <h5 class="">
                                {{ this.update ? "Editar profesor" : "Agregar profesor" }}
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
                                    v-model="user.name"
                                    color="#4a4cf6"
                                    required
                                    dense
                                    dark
                                    variant='outlined'
                                    :rules="rules.nameRule"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <p>Apellido Paterno</p>
                                <v-text-field
                                    v-model="user.middle_name"
                                    required
                                    dense
                                    color="#4a4cf6"

                                    dark
                                    variant='outlined'
                                    :rules="rules.middle_nameRule"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <p>Apellido Materno</p>
                                <v-text-field
                                    v-model="user.last_name"
                                    required
                                    dense
                                    color="#4a4cf6"

                                    dark
                                    variant='outlined'
                                    :rules="rules.last_nameRule"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <p>Edad</p>
                                <v-text-field
                                    v-model="user.age"
                                    dense
                                    type="number"
                                    color="#4a4cf6"

                                    dark
                                    variant='outlined'
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <p>Telefono</p>
                                <v-text-field
                                    v-model="user.phone"
                                    dense
                                    type="number"
                                    color="#4a4cf6"
                                    :rules="rules.phoneRule"
                                    dark
                                    variant='outlined'
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <p>Correo electronico</p>
                                <v-text-field
                                    v-model="user.email"
                                    required
                                    dense
                                    dark
                                    variant='outlined'
                                    color="#4a4cf6"

                                    :rules="rules.emailRule"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <p>Contraseña</p>
                                <v-text-field
                                    v-model="user.password"
                                    required
                                    dense
                                    dark
                                    variant='outlined'
                                    color="#4a4cf6"

                                    type="password"
                                    :rules="rules.passwordRule"
                                ></v-text-field>
                            </v-col>

                        </v-row>
                    </v-form>
                    <div class="text-center">
                        <button class="btn text-dark bg-blue-primary text-white" @click="save()">
                            {{ this.update ? "Guardar profesor" : "Agregar profesor" }}
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
    name: "FormTeacher",
    props: {
        update: Boolean,
        dataUpdate: Object,
    },
    data() {
        return {
            dialog: false,
            valid: true,
            user: {
                id: "",
                name: "",
                last_name: "",
                middle_name: "",
                age: "",
                phone: "",
                email: '',
                password: "",
            },
            rules: {
                nameRule: [(v) => !!v || "El nombre es requerido"],
                last_nameRule: [(v) => !!v || "El apellido es requerido"],
                middle_nameRule: [(v) => !!v || "El apellido es requerido"],
                emailRule: [(v) => !!v || "El correo electronico es requerido"],
                passwordRule: [(v) => !!v || "La contraseña es requerida"],
                phoneRule: [(v) => {
                    if (!!v && v.length !== 10) {
                        return "El teléfono debe tener 10 dígitos";
                    }
                    return true;
                }],
            },
            loading: false,
        }
    },
    created() {
        this.URL_CREATE_USER = route('admin.teacher.create');
        this.URL_UPDATE_USER = route('admin.teacher.update', {userId: 'FAKE_ID'});
    },
    methods: {
        close() {
            this.dialog = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },
        getData(data) {
            this.user.id = data.id;
            this.user.name = data.name;
            this.user.last_name = data.last_name;
            this.user.middle_name = data.middle_name;
            this.user.age = data.age;
            this.user.phone = data.phone;
            this.user.email = data.email;
            this.user.password = data.password;
        },
        async save() {
            const {valid} = await this.$refs.form.validate();
            if (valid) {
                let url = !this.update ? this.URL_CREATE_USER : this.URL_UPDATE_USER.replace('FAKE_ID', this.dataUpdate.id);

                let formData = new FormData();
                formData.append('id', this.user.id);
                formData.append('name', this.user.name);
                formData.append('last_name', this.user.last_name);
                formData.append('middle_name', this.user.middle_name);
                formData.append('age', this.user.age);
                formData.append('phone', this.user.phone);
                formData.append('email', this.user.email);
                formData.append('password', this.user.password);

                axios
                    .post(url, formData)
                    .then((response) => {
                        if (response.data.success) {
                            this.$swal.fire({
                                title: !this.update ? "Profesor agregado!" : 'Profesor actualizado!',
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
