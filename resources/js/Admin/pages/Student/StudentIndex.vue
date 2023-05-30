<template>
    <h1>Estudiantes</h1>
    <Table
        :columns="columns"
        :url="url"
    >
        <template v-slot:courses="{data}" class="d-flex flex-column">
            <div  class="d-flex flex-column align-items-center justify-content-center">
                <p v-for="(item,i) in data.courses" :key="i">
                    {{ item.name }}
                </p>
            </div>
        </template>

<!--        <template v-slot:action-slot="data">-->
<!--        </template>-->
    </Table>
</template>

<script>
import Table from "../../commons/Table.vue";

export default {
    name: "StudentIndex",
    components: {Table},
    data() {
        return {
            columns: [
                {
                    label: '#',
                    name: 'id'
                },
                {
                    label: "Nombre",
                    name: "name",
                },
                {
                    label: "Telefono",
                    name: "phone",
                },
                {
                    label: "Correo",
                    name: "email",
                },
                {
                    label: "Cursos",
                    name: "courses",
                    slot_name: 'courses'
                },
            ],
            url: 'admin.student.index.content'
        }
    }
};
</script>

<style scoped>
</style>
