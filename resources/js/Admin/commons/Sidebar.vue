<template>
    <v-navigation-drawer
        v-model="drawer"
        permanent
    >
        <v-list-item
            class="d-flex justify-content-center align-items-center"
        >
            <v-img
                :width="100"
                src="/assets/images/admin/icon.png"
                contain
            ></v-img>
        </v-list-item>

        <v-divider></v-divider>

        <v-list density="compact" nav>
            <template
                v-for="(item, i) in items"
            >
                <v-list-item
                    :prepend-icon="item.icon" :title="item.text" :value="item.route" :to="{name: item.route}"
                    :class="{ 'br-left-30 br-right-30 bg-blue-primary text-white': activeItem === item.route }"
                    @click="activeItem = item.route"
                ></v-list-item>
            </template>
            <br>
            <v-list-item
                prepend-icon="mdi-logout" title="Cerrar sesion" value="logout"
                @click="logout()"
            ></v-list-item>

        </v-list>
    </v-navigation-drawer>
</template>
<!--<template>-->
<!--  <v-navigation-drawer class="bg-blue-primary">-->
<!--    <v-list flat>-->
<!--      <v-list-item-->
<!--        v-for="(item, i) in items"-->
<!--        :key="i"-->
<!--        class="my-3 me-12"-->
<!--        :to="{ name: item.route }"-->
<!--      >-->
<!--        <template v-slot:default="{ active }">-->
<!--          <v-row style="border-bottom-right-radius: 30px">-->
<!--            <span v-if="active" :class="(active ? 'bg-white' : '') + ' px-0'">-->
<!--              <div-->
<!--                class="bg-blue-primary py-2 d-block"-->
<!--                style="border-bottom-left-radius: 30px"-->
<!--              ></div>-->
<!--            </span>-->
<!--            <div :class="(active ? 'bg-white ' : ' ') + ' br-left-30px'">-->
<!--              <v-list-item class="pe-0 me-0">-->
<!--                <v-icon>-->
<!--                  {{ active ? item.iconActive : item.icon }}-->
<!--                </v-icon>-->
<!--                <span-->
<!--                  class="ms-4 fw-bold"-->
<!--                  :class="active ? 'color-blue' : 'text-white'"-->
<!--                >-->
<!--                  {{ item.text }}-->
<!--                </span>-->
<!--              </v-list-item>-->
<!--            </div>-->

<!--            <span v-if="active" :class="(active ? 'bg-white' : '') + ' px-0'">-->
<!--              <div-->
<!--                class="bg-blue-primary py-2 d-block"-->
<!--                style="border-top-left-radius: 30px"-->
<!--              ></div>-->
<!--            </span>-->
<!--          </v-row>-->
<!--        </template>-->
<!--      </v-list-item>-->
<!--    </v-list>-->
<!--  </v-navigation-drawer>-->
<!--</template>-->

<script>
import axios from "axios";
export default {
    name: "Sidebar",
    props: {
        items: {
            required: true,
        },
    },
    data() {
        return {
            selectedItem: 0,
            drawer: true,
            activeItem: ''
        };
    },
    created() {
        this.activeItem = this.$route.name;
        this.URL_LOGOUT = route('admin.logout');
    },
    methods:{
        async logout() {
            // this.active = true;
            localStorage.clear();
            sessionStorage.clear()
            await axios.get(this.URL_LOGOUT);
            window.location.href = "/admin/login";
        }
    }

};
</script>

<style scoped>
</style>
