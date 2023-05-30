<template>
  <div class="d-flex justify-content-center align-items-center">
    <v-card class="rounded-xl" :min-width="900">
      <v-row>
        <v-col
          cols="6"
          class="d-flex justify-content-center align-items-center"
        >
          <v-img
            :width="400"
            src="/assets/images/admin/login.jpg"
            contain
          ></v-img>
        </v-col>
        <v-col
          cols="6"
          class="p-5 d-flex flex-column justify-content-center align-items-center"
        >
          <h1 class="pb-5 font-weight-bold text-center">¡Bienvenido!</h1>
          <p class="">Correo electrónico</p>
          <v-text-field
            v-model="form.email"
            required
            dense
            dark
            variant="outlined"
            class="w-100"
          ></v-text-field>
          <p class="">Contraseña</p>
          <v-text-field
            v-model="form.password"
            :type="showPassword ? 'text' : 'password'"
            dense
            dark
            variant="outlined"
            @click:append="showPassword = !showPassword"
            :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
            class="w-100"
          ></v-text-field>

          <v-btn
            style="background-color: #4a4cf6"
            dark
            class="text-white"
            @click="login"
          >
            Iniciar sesión
          </v-btn>
        </v-col>
      </v-row>
    </v-card>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      showPassword: false,
      form: {
        email: "",
        password: "",
      },
    };
  },
  methods: {
    login() {
      axios
        .post(route("admin.auth"), {
          email: this.form.email,
          password: this.form.password,
        })
        .then((response) => {
          if (response.data.success) {
            let id = response.data.user[0].id;
            let email = response.data.user[0].email;
            localStorage.setItem("id", id);
            localStorage.setItem("email", email);
            this.$swal
              .fire({
                position: "center",
                icon: "success",
                title: "Ok",
                text: "Datos correctos.",
                showConfirmButton: false,
                timer: 2000,
              })
              .then(() => {
                  window.location.href = "/admin/users";
              });
          } else {
            this.$swal.fire({
              position: "center",
              icon: "error",
              title: "Error",
              text: "Verifica los datos ingresados, el correo o contraseña son incorrectos.",
              showConfirmButton: false,
              timer: 2000,
            });
          }
        })
        .catch((err) => {});
    },
  },
};
</script>

<style>
</style>
