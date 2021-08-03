<template>
    <div>
        <div class="col-12 mb-4">
            <h3>Proveedores - Restaurar eliminados</h3>
        </div>
        <div class="d-flex justify-content-between ml-0 mr-0 pl-0 pr-0">
            <div class="col-lg-4 pl-0 pr-0">
                <b-col lg="12" class="pl-0 pr-0">
                    <b-form-group>
                        <b-input-group size="sm">
                            <b-form-input
                                id="filter-input"
                                v-model="filter"
                                type="search"
                                placeholder="Escriba para buscar"
                            />

                            <b-input-group-append>
                                <b-button
                                    :disabled="!filter"
                                    @click="filter = ''"
                                >
                                    Limpiar
                                </b-button>
                            </b-input-group-append>
                        </b-input-group>
                    </b-form-group>
                </b-col>
            </div>
        </div>

        <b-table
            hover
            dark
            :items="items"
            :per-page="perPage"
            :current-page="currentPage"
            :fields="fields"
            :filter="filter"
            ref="products"
            @filtered="itemsFilter($event)"
        >
            <template v-slot:cell(actions)="row">
                <div class="d-flex justify-content-around">
                    <b-button
                        variant="success"
                        @click="restoreProvider(row.item.rut_provider)"
                    >
                        Restaurar
                    </b-button>
                </div>
            </template>
        </b-table>
        <div v-if="itemsFiltered" class="danger">
            <b-alert
                show="show"
                variant="danger"
                class="text-center text-white text-bold mt-5 mb-5"
            >
                No hay registros que coincidan con su búsqueda
            </b-alert>
        </div>
        <b-pagination
            v-model="currentPage"
            :total-rows="rows"
            :per-page="perPage"
            aria-controls="my-table"
        ></b-pagination>
    </div>
</template>

<script>
import Repository from "../../repositories/RepositoryFactory";

const ProvidersRepository = Repository.get("providers");

export default {
    name: "RestoreProvidersComponent",
    props: {
        rutUser: Number
    },
    data() {
        return {
            items: [],
            countries: [
                { value: null, text: "Seleccione una opción", disabled: true }
            ],
            fields: [
                { key: "rut_provider", label: "Rut proveedor" },
                { key: "name", label: "Nombre" },
                { key: "deleted_at", label: "Fecha de eliminación" },
                {
                    key: "actions",
                    label: "",
                    tdClass: "icons-column-width",
                    thClass: "icons-column-width "
                }
            ],
            perPage: 10,
            currentPage: 1,
            filter: null,
            filterOn: [],
            disabled: true,
            itemsFiltered: false
        };
    },
    async mounted() {
        await this.dataForTable();
    },
    computed: {
        rows() {
            return this.items.length;
        }
    },
    methods: {
        async dataForTable() {https://trello.com/c/sGqG7nJOpository.getDeleted();
            this.fillTable(providers);
            if (!providers.data.length) {
                this.items = [];
            }
        },
        fillTable(providers) {
            providers.data.forEach(provider => this.items.push(provider));
        },
        itemsFilter(evt) {
            this.itemsFiltered = evt.length === 0;
        },
        restoreProvider(rut_provider) {
            console.log(this.rutUser);
            this.$swal({
                title: "Estás seguro?",
                text:
                    "El proveedor restaurado será visible en la sección de proveedores!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, restaurar!",
                cancelButtonText: "cancelar"
            }).then(result => {
                if (result.isConfirmed) {
                    ProvidersRepository.restore(rut_provider, this.rutUser)
                        .then(res => {
                            this.items.length = 0;
                            this.dataForTable();
                            this.$swal(
                                'Todo listo !"',
                                res.data.message,
                                "success"
                            );
                        })
                        .catch(err => {
                            this.$swal(
                                "No se pudo restaurar el proveedor",
                                err.message,
                                "error"
                            );
                        });
                }
            });
        }
    }
};
</script>

<style scoped></style>
