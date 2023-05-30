<template>
    <div class="d-flex flex-wrap gap-3">
        <v-card
            class="text-black"
            :width="500"
            variant="outlined"
            v-for="(item, i) in courses" :key="i"
        >
            <router-link :to="{name: 'course', params:{courseId: item.id}}" class="text-decoration-none">
                <v-img
                    :src="item.image"
                    height="200px"
                    cover
                    style="border-bottom: thin solid black"
                ></v-img>
                <v-card-title class="text-black">
                    {{ item.name }}
                </v-card-title>

                <v-card-subtitle class="text-black pb-2">
                    {{ item.type }}
                </v-card-subtitle>
            </router-link>
        </v-card>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "TeacherCourses",
    data() {
        return {
            courses: [],
        }
    },
    created() {
        axios
            .get(route("teacher.get.courses"))
            .then((response) => {
                this.courses = response.data.data;
            })
            .catch((err) => {
            });
    }
}
</script>

<style scoped>

</style>
