<template>
  <v-app>
    <div class="pink-line"></div>
    <div class="white-line"></div>

    <v-main class="d-flex justify-center align-center">
      <Main></Main>
    </v-main>
  </v-app>
</template>

<script>
import Main from "./components/Main.vue";
export default {
  name: "Login",
  components: { Main },
};
</script>

<style>
</style>