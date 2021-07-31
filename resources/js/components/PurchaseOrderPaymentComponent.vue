<template>
    <div>
        <div class="col-12 mb-4">
            <h3>Estado de pago - Ordenes de compra</h3>
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
            <b-link :href="'oc-pagadas'" class="btn btn-primary mb-5"
                >Ver OC pagadas</b-link
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
                <div class="d-flex justify-content-around">
                    <b-link
                        :href="`descargar/${row.item.id_purchase_order}`"
                        class="btn btn-primary"
                        >ver</b-link
                    >
                    <b-button
                        variant="success"
                        @click="updatePayment(row.item.id_purchase_order)"
                    >
                        Pagar
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
const PaymentRepository = Repository.get("payment");

export default {
    name: "PurchaseOrderPaymentComponent",
    props: {
        rutUser: Number
    },
    data() {
        return {
            items: [],
            fields: [
                {
                    key: "id_purchase_order",
                    label: "Orden número",
                    sortable: true
                },
                { key: "provider", label: "Proveedor", sortable: true },
                {
                    key: "total",
                    label: "Monto",
                    sortable: true,
                    formatter: (value, key, item) =>
                        value.toLocaleString("es-CL", {
                            style: "currency",
                            currency: "clp"
                        })
                },
                { key: "status", label: "Estado de pago", sortable: true },
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
        async dataForTable() {
            const paymentData = await PaymentRepository.get();
            await this.fillTable(paymentData.data.data);
            if (!paymentData.data.data.length) {
                this.items = [];
            }
        },
        fillTable(paymentData) {
            paymentData.forEach(paymentStatus => {
                const data = {
                    id_purchase_order: paymentStatus.id_purchase_order,
                    provider: paymentStatus.provider,
                    total: paymentStatus.total,
                    status: paymentStatus.status
                };
                this.items.push(data);
            });
            console.log(this.items);
        },
        itemsFilter(evt) {
            this.itemsFiltered = evt.length === 0;
        },
        updatePayment(id_purchase_order) {
            this.$swal({
                title: "Estás seguro que deseas pagar esta orden?",
                text: "Esta acción no se puede revertir!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, pagar !",
                cancelButtonText: "cancelar"
            }).then(result => {
                if (result.isConfirmed) {
                    PaymentRepository.update(id_purchase_order, this.rutUser)
                        .then(res => {
                            this.items.length = 0;
                            this.dataForTable();
                            this.$swal(
                                'Todo listo !"',
                                res.data.message,
                                "success"
                            );
                        })
                        .catch(err => console.log(err));
                }
            });
        }
    }
};
</script>
