<template>
    <div>
        <div class="col-12 mb-4">
            <h3>Productos - Gestión de productos</h3>
        </div>
        <div class="d-flex mb-3 col-12">
            <b-modal
                id="modal-add-product-1"
                centered
                ref="createProductModal"
                title="Añadir producto"
            >
                <div class="form-group">
                    <div class="input-field col-sm-12">
                        <label for="id_product"
                            >Código de producto
                            <span
                                v-b-tooltip.hover
                                title="Campo obligatorio"
                                class="text-danger"
                                >(*)</span
                            ></label
                        >
                        <input
                            class="form-control"
                            type="text"
                            v-model="idProduct"
                            id="id_product"
                            required
                        />
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-field col-sm-12">
                        <label for="name"
                            >Nombre producto
                            <span
                                v-b-tooltip.hover
                                title="Campo obligatorio"
                                class="text-danger"
                                >(*)</span
                            ></label
                        >
                        <input
                            class="form-control"
                            type="text"
                            v-model="name"
                            id="name"
                            required
                        />
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-field col-sm-12">
                        <label for="description">Descripción</label>
                        <textarea
                            id="description"
                            v-model="description"
                            class="form-control"
                        ></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col-sm-6">
                        <label for="quantity"
                            >Cantidad
                            <span
                                v-b-tooltip.hover
                                title="Campo obligatorio"
                                class="text-danger"
                                >(*)</span
                            ></label
                        >
                        <input
                            class="form-control"
                            type="text"
                            v-model="quantity"
                            id="quantity"
                            required
                        />
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="unit_price"
                            >Precio Unitario
                            <span
                                v-b-tooltip.hover
                                title="Campo obligatorio"
                                class="text-danger"
                                >(*)</span
                            ></label
                        >
                        <input
                            class="form-control"
                            type="text"
                            v-model="unitPrice"
                            id="unit_price"
                            required="true"
                        />
                    </div>
                </div>
                <template #modal-footer="{ aceptar, cancel}">
                    <b-button
                        size="sm"
                        variant="success"
                        :disabled="disabled"
                        @click="createProduct()"
                    >
                        Aceptar
                    </b-button>
                    <b-button
                        size="sm"
                        variant="danger"
                        @click="clearProductsForm()"
                    >
                        Cancelar
                    </b-button>
                </template>
            </b-modal>
            <!-- MODAL EDIT PRODUCTS -->
            <b-modal
                v-model="show"
                centered
                ref="createProductModal"
                title="Editar producto"
                @hide="clearProductsForm()"
            >
                <div class="form-group">
                    <div class="input-field col-sm-12">
                        <label for="id_productEdit">Código de producto</label>
                        <input
                            class="form-control"
                            type="text"
                            v-model="idProduct"
                            id="id_productEdit"
                            readonly
                        />
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-field col-sm-12">
                        <label for="nameEdit">Nombre producto</label>
                        <input
                            class="form-control"
                            type="text"
                            v-model="name"
                            id="nameEdit"
                            required
                        />
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-field col-sm-12">
                        <label for="descriptionEdit">Descripción</label>
                        <textarea
                            id="descriptionEdit"
                            v-model="description"
                            class="form-control"
                        ></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col-sm-6">
                        <label for="quantityEdit">Cantidad</label>
                        <input
                            class="form-control"
                            type="text"
                            v-model="quantity"
                            id="quantityEdit"
                            required
                        />
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="unit_priceEdit">Precio Unitario</label>
                        <input
                            class="form-control"
                            type="text"
                            v-model="unitPrice"
                            id="unit_priceEdit"
                            required="true"
                        />
                    </div>
                </div>
                <template #modal-footer="{ aceptar, cancel}">
                    <b-button
                        size="sm"
                        :disabled="disabled"
                        variant="success"
                        @click="updateProduct()"
                    >
                        Aceptar
                    </b-button>
                    <b-button
                        size="sm"
                        variant="danger"
                        @click="clearProductsForm()"
                    >
                        Cancelar
                    </b-button>
                </template>
            </b-modal>
            <!-- END MODAL UPDATE PRODUCT -->
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
            <b-button
                v-b-modal.modal-add-product-1
                variant="primary"
                class="mb-3"
                >Añadir producto</b-button
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
            ref="products"
            @filtered="itemsFilter($event)"
        >
            <template v-slot:cell(actions)="row">
                <div class="d-flex justify-content-around">
                    <b-button
                        variant="outline-warning"
                        @click="
                            (show = !show), setSelectedProductData(row.item)
                        "
                    >
                        <b-icon
                            icon="pencil-square"
                            aria-hidden="true"
                        ></b-icon>
                    </b-button>
                    <b-button
                        variant="outline-danger"
                        @click="deleteProduct(row.item.id_product)"
                    >
                        <b-icon icon="trash-fill" aria-hidden="true"></b-icon>
                    </b-button>
                </div>
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
const ProductsRepository = Repository.get("products");
import { numberValidator } from "../../utils/NumberValidator"

export default {
    name: "ProductsComponent",
    props: {
        rutUser: Number
    },
    data() {
        return {
            items: [],
            fields: [
                { key: "id_product", label: "Código producto" },
                { key: "name", label: "Nombre" },
                { key: "quantity", label: "Cantidad" },
                { key: "unit_price", label: "Precio unitario" },
                {
                    key: "actions",
                    label: "",
                    tdClass: "icons-column-width",
                    thClass: "icons-column-width "
                }
            ],
            idProduct: null,
            name: "",
            quantity: null,
            unitPrice: null,
            description: null,
            rut: this.rutUser,
            perPage: 10,
            currentPage: 1,
            filter: null,
            filterOn: [],
            itemsFiltered: false,
            show: false
        };
    },
    async mounted() {
        await this.dataForTable();
    },
    computed: {
        rows() {
            return this.items.length;
        },
        disabled() {
            return !(
                this.idProduct &&
                this.name &&
                numberValidator(this.quantity) &&
                numberValidator(this.unitPrice)
            );
        }
    },
    methods: {
        async dataForTable() {
            const products = await ProductsRepository.get();
            await this.fillTable(products);
            if (!products.data.length) {
                this.items = [];
            }
        },
        fillTable(products) {
            products.data.forEach(product => {
                const producto = {
                    id_product: product.id_product,
                    name: product.name,
                    quantity: product.quantity,
                    unit_price: product.unit_price
                };
                this.items.push(producto);
            });
            console.log(this.items);
        },
        itemsFilter(evt) {
            this.itemsFiltered = evt.length === 0;
        },
        clearProductsForm() {
            (this.idProduct = null),
                (this.name = ""),
                (this.quantity = null),
                (this.unitPrice = null),
                (this.description = null),
                this.$refs.createProductModal.hide();
        },
        createProduct() {
            const payload = {
                id_product: this.idProduct,
                name: this.name,
                quantity: this.quantity,
                unit_price: this.unitPrice,
                description: this.description,
                rut_user: this.rutUser
            };
            ProductsRepository.create(payload)
                .then(res => {
                    console.log(res);
                    this.items.length = 0;
                    this.dataForTable();
                    this.clearProductsForm();
                    this.$swal('Todo listo !"', res.data.message, "success");
                })
                .catch(err => {
                    if (err.message === "Request failed with status code 422") {
                        this.$swal(
                            "Algo malió sal :(",
                            "El producto ya está registrado en el sistema",
                            "error"
                        );
                    }
                });
        },
        setSelectedProductData(item) {
            console.log(item);
            this.idProduct = item.id_product;
            ProductsRepository.getById(item.id_product)
                .then(res => {
                    this.name = res.data.name;
                    this.quantity = res.data.quantity;
                    this.unitPrice = res.data.unit_price;
                    this.description = res.data.description;
                    this.show = true;
                })
                .catch(err => console.log(err));
        },
        updateProduct() {
            const payload = {
                id_product: this.idProduct,
                name: this.name,
                quantity: this.quantity,
                unit_price: this.unitPrice,
                description: this.description,
                rut_user: this.rutUser
            };
            ProductsRepository.update(payload, this.idProduct)
                .then(res => {
                    this.$swal("Todo Listo !", res.data.message, "success");
                    this.items.length = 0;
                    this.dataForTable();
                    this.clearProductsForm();
                    this.show = false;
                })
                .catch(err => console.log(err));
        },
        deleteProduct(id) {
            console.log(this.rutUser);
            this.$swal({
                title: "Estás seguro?",
                text: "Esta acción no se puede revertir!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, borrarlo!",
                cancelButtonText: "cancelar"
            }).then(result => {
                if (result.isConfirmed) {
                    ProductsRepository.delete(id, this.rutUser).then(res => {
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
        }
    }
};
</script>
