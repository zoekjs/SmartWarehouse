<template>
<div>
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
                        <b-button :disabled="!filter" @click="filter = ''">
                            Limpiar
                        </b-button>
                    </b-input-group-append>
                </b-input-group>
            </b-form-group>
        </b-col>
    </div>
    <b-button v-b-modal.modal-add-product-1 variant="primary" class="mb-3">Añadir proveedor</b-button>
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
                <b-button variant="outline-warning" @click="show = !show, setSelectedProductData(row.item)">
                    <b-icon icon="pencil-square" aria-hidden="true"></b-icon>
                </b-button>
                <b-button variant="outline-danger" @click="deleteProduct(row.item.id_product)">
                    <b-icon icon="trash-fill" aria-hidden="true"></b-icon>
                </b-button>
            </div>
        </template>
    </b-table>
    <div v-if="itemsFiltered" class="success">
        <b-alert show="show" variant="danger" class="text-center text-white text-bold mt-5 mb-5">
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
export default {
    name: 'ProvidersComponent',
    data () {
        return {
            items: [],
            fields: [
                { key: 'rut_provider', label: 'Rut proveedor' },
                { key: 'name', label: 'Nombre' },
                { key: 'telephone', label: 'Número de contacto' },
                { key: 'address', label: 'Dirección' },
                { key: 'email', label: 'Email' },
                { key: 'actions', label: '', tdClass: 'icons-column-width', thClass: 'icons-column-width '}
            ],
            perPage: 10,
            currentPage: 1,
            filter: null,
            filterOn: [],
            itemsFiltered: false,
            show: false,
        }
    },
    computed: {
        rows() {
            return this.items.length
        },
        disabled () {
            return !(this.idProduct && this.name && this.quantity && this.unitPrice)
        }
    }
}
</script>

<style scoped>

</style>
