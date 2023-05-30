<template>
    <div>
        <table class="table table-borderless table-hover table-striped">
            <thead>
            <tr>
                <th v-for="column in indexedColumns" :key="column.colId">
                    <div class="d-flex flex-row align-center">
                        <!--              <span>-->
                        <p class="color-blue">{{ column.label }}</p>
                        <!--              </span>-->
                    </div>
                </th>
            </tr>
            </thead>
            <tbody>
            <template v-if="dataPag.length === 0">
                <tr>
                    <td :colspan="indexedColumns.length + 1" class="text-center">
                        <p>No hay registros.</p>
                    </td>
                </tr>
            </template>
            <template v-else>
                <tr v-for="(row, index) in dataPag" :key="index">
                    <td v-for="column in indexedColumns" :key="column.colId * 100" class="text-center align-middle">
                        <div class="d-flex align-items-center justify-content-start">
                            <slot
                                :name="getCellSlotName(column)"
                                :row="row"
                                :column="column"
                                v-bind:data="row"
                                :cell_value="getValueFromRow(row, column.name)"
                            >
                                {{ getValueFromRow(row, column.name) }}
                            </slot>
                        </div>
                    </td>
                    <td class="align-middle">
                        <div class="d-flex justify-content-evenly align-items-center">

                            <Toggle
                                v-if="toggleSwitch"
                                :active="row.active === true"
                                :url="urlState"
                                :id="row.id"
                            ></Toggle>
                            <slot name="action-slot" v-bind="row"></slot>
                        </div>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>

        <nav aria-label="..." v-if="dataPag.length !== 0">
            <ul class="pagination justify-content-center">
                <li class="page-item" :class="paginaActual === 1 ? 'disabled' : ''">
                    <a class="page-link" @click="getPreviousPage()">Previous</a>
                </li>
                <li v-for="pagina in totalPages()" :key="pagina" class="page-item">
                    <a
                        class="page-link"
                        :class="pagina === paginaActual ? 'active' : ''"
                        @click="getDataPagina(pagina)"
                    >{{ pagina }}</a
                    >
                </li>
                <li
                    class="page-item"
                    :class="paginaActual === totalPages() ? 'disabled' : ''"
                >
                    <a class="page-link" @click="getNextPage()">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
import mitt from "mitt";
import axios from "axios";
import Toggle from "./Toggle.vue";

export default {
    name: "Table",
    components: {Toggle},
    props: {
        columns: Array,
        url: String,
        toggleSwitch: Boolean,
        urlState: String,
        updateFlag: Boolean,
        config: Object,
    },
    data: () => ({
        data: [],
        dataPag: [],
        paginaActual: 1,
        indexedColumns: [],
        valToggle: true,
    }),
    created() {
        this.fetchData();
    },
    watch: {
        updateFlag() {
            this.fetchData();
            this.paginaActual = 1;
        }
    },
    methods: {
        handleReloadGrid() {
            this.fetchData();
            this.paginaActual = 1;
        },
        async fetchData() {
            await axios
                .get(route(this.url, this.config))
                .then((response) => {
                    this.data = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });

            this.dataPag = [...this.data];
            this.indexedColumns = [...this.columns];

            this.indexedColumns = this.indexedColumns.map((element, index) => {
                element.colId = index + 1;
                return element;
            });
            this.getDataPagina(this.paginaActual);
        },
        convertData(data) {
            this.dataReceived = data;
        },
        totalPages() {
            return Math.ceil(this.data.length / 10);
        },
        getDataPagina(noPagina) {
            this.dataPag = [];
            let ini = noPagina * 10 - 10;
            let fin = noPagina * 10;
            this.dataPag = this.data.slice(ini, fin);
        },
        getPreviousPage() {
            if (this.paginaActual > 1) this.paginaActual--;
            this.getDataPagina(this.paginaActual);
        },
        getNextPage() {
            if (this.paginaActual < this.totalPages()) this.paginaActual++;
            this.getDataPagina(this.paginaActual);
        },
        getValueFromRow(row, name) {
            let paths = name.split("."),
                current = row,
                i;

            for (i = 0; i < paths.length; ++i) {
                if (current[paths[i]] == undefined) {
                    return undefined;
                } else {
                    current = current[paths[i]];
                }
            }
            return current;
        },
        getCellSlotName(column) {
            if (column.slot_name !== null && column.slot_name !== undefined) {
                return column.slot_name;
            }
            return column.name.replace(/\./g, "_");
        },
    },
};
</script>

<style>
</style>
