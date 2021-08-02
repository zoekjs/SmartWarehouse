<template>
    <div>
        <div class="col-12 mb-4">
            <h3>Tags - Asociaciones con productos</h3>
        </div>

        <b-modal
            id="modal-tags"
            centered
            title="Asociar tag"
            ref="asociateForm"
        >
            <div>
                <label for="input-with-list">Tag ID</label>
                <b-form-input
                    list="input-list"
                    id="input-with-list"
                    v-model="selectedTag"
                    :state="stateTag"
                ></b-form-input>
                <b-form-datalist
                    id="input-list"
                    :options="tags"
                ></b-form-datalist>
                <span v-if="!stateTag" class="text-danger"
                    >El ID del tag no es válido</span
                >
            </div>
            <div class="mb-4">
                <label for="product-with-list">Código producto</label>
                <b-form-input
                    list="input-list-p"
                    id="product-with-list"
                    v-model="selectedProduct"
                    :state="stateProduct"
                ></b-form-input>
                <b-form-datalist
                    id="input-list-p"
                    :options="products"
                ></b-form-datalist>
                <span v-if="!stateProduct" class="text-danger"
                    >El código del producto no es válido</span
                >
            </div>
            <template #modal-footer="{ aceptar, cancel}">
                <b-button
                    size="sm"
                    :disabled="disabled"
                    variant="success"
                    @click="productTagAsociation()"
                >
                    Asociar
                </b-button>
                <b-button
                    size="sm"
                    variant="danger"
                    @click="clearAsociateForm()"
                >
                    Cancelar
                </b-button>
            </template>
        </b-modal>

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
            <b-button class="mb-5" variant="primary" v-b-modal.modal-tags
                >Asociar tag</b-button
            >
        </div>

        <b-table
            hover
            dark
            :items="items"
            :per-page="perPage"
            :current-page="currentPage"
            :fields="fields"
            :filter="filter"
            @filtered="itemsFilter($event)"
            ><template
                v-slot:cell(actions)="row"
                class="d-flex justify-content-between"
            >
                <b-button
                    variant="danger"
                    @click="desasociate(row.item.id_tag, row.item.id_product)"
                >
                    Desasociar
                </b-button>
            </template>
        </b-table>
        <div v-if="itemsFiltered" class="success">
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
const TagsRepository = Repository.get("tags");
const ProductsRepository = Repository.get("products");

export default {
    name: "TagsComponent",
    props: {
        rutUser: Number
    },
    data() {
        return {
            items: [],
            fields: [
                {
                    key: "id_tag",
                    label: "Número de tag",
                    sortable: true
                },
                { key: "product_name", label: "Producto", sortable: true },
                { key: "id_product", thClass: "d-none", tdClass: "d-none" },
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
            itemsFiltered: false,
            tags: [],
            products: [],
            selectedTag: "",
            selectedProduct: ""
        };
    },
    async mounted() {
        await this.dataForTable();
        await this.getTags();
        await this.getProducts();
    },
    computed: {
        rows() {
            return this.items.length;
        },
        disabled() {
            return !(
                this.selectedTag &&
                this.selectedProduct &&
                this.products.some(
                    product => product.value === this.selectedProduct
                ) &&
                this.tags.some(tag => tag.value === this.selectedTag)
            );
        },
        stateTag() {
            return this.tags.some(tag => tag.value === this.selectedTag);
        },
        stateProduct() {
            return this.products.some(
                product => product.value === this.selectedProduct
            );
        }
    },
    methods: {
        async dataForTable() {
            const asociationData = await TagsRepository.getAsociations();
            if(!asociationData.data.data.length) {
                this.items = [];
            }
            console.log(asociationData.data.data);
            await this.fillTable(asociationData.data.data);
        },
        fillTable(asociationData) {
            asociationData.forEach(asociations => {
                const data = {
                    id_tag: asociations.id_tag,
                    product_name: asociations.product_name,
                    id_product: asociations.id_product
                };
                this.items.push(data);
            });
        },
        async getTags() {
            const tagsData = await TagsRepository.get();
            tagsData.data.data.forEach(tags => {
                const data = {
                    value: tags.id_tag,
                    text: ""
                };
                this.tags.push(data);
                console.log(this.tags);
            });
        },
        async getProducts() {
            const products = await ProductsRepository.get();
            products.data.data.forEach(product => {
                const data = {
                    text: product.name,
                    value: product.id_product
                };
                this.products.push(data);
            });
        },
        productTagAsociation() {
            const id = this.selectedTag;
            const payload = { id_product: this.selectedProduct };
            TagsRepository.update(id, payload, this.rutUser)
                .then(res => {
                    this.clearAsociateForm();
                    this.tags.length = 0;
                    this.getTags();
                    this.items.length = 0;
                    this.dataForTable();
                    this.$swal('Todo listo !"', res.data.message, "success");
                })
                .catch(err => {
                    this.$swal(
                        "No se pudo asociar el tag",
                        err.message,
                        "error"
                    );
                });
        },
        desasociate(id_tag, id_product) {
            this.$swal({
                title: "Estás seguro?",
                text: "Esta acción no se puede revertir!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, Desasociar!",
                cancelButtonText: "cancelar"
            }).then(result => {
                if (result.isConfirmed) {
                    TagsRepository.delete(id_tag, this.rutUser, id_product).then(res => {
                        this.items.length = 0;
                        this.dataForTable();
                        this.$swal(
                            'Todo listo !"',
                            res.data.message,
                            "success"
                        );
                    });
                }
            });
        },
        itemsFilter(evt) {
            this.itemsFiltered = evt.length === 0;
        },
        clearAsociateForm() {
            (this.selectedTag = ""),
                (this.selectedProduct = ""),
                this.$refs.asociateForm.hide();
        }
    }
};
</script>
