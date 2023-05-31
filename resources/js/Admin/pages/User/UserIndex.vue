<template>
    <h1>Usuarios</h1>
    <FormUser :update="false" @reload-grid="handleReloadGrid"></FormUser>

    <Table
        :columns="columns"
        :url="url"
        :updateFlag="updateFlag"
        :url-state="urlState"
        :toggle-switch="true"
    >
        <template v-slot:action-slot="data">
            <FormUser :update="true" :data-update="data" @reload-grid="handleReloadGrid"></FormUser>
        </template>
    </Table>
</template>

<script>
import Table from "../../commons/Table.vue";
import FormUser from "../../components/User/FormUser.vue";

export default {
    name: "UserIndex",
    components: {FormUser, Table},
    data() {
        return {
            updateFlag: false,
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
                    label: "Apellidos",
                    name: "full_last_name",
                },
                {
                    label: "Edad",
                    name: "age",
                },
                {
                    label: "Telefono",
                    name: "phone",
                },
                {
                    label: "Correo",
                    name: "email",
                },
            ],
            url: 'admin.user.index.content',
            urlState: 'admin.user.status'
        }
    },
    methods: {
        handleReloadGrid() {
            this.updateFlag = !this.updateFlag;
        }
    },
}
</script>

<style scoped>

</style>
