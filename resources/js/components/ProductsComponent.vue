<template>
        <div>
            <div class="d-flex">
                <b-button v-b-modal.modal-add-product-1 class="justify-content-end">Añadir producto</b-button>

                <b-modal id="modal-add-product-1" centered title="Añadir producto">
                    <div class="form-group">
                        <div class="input-field col-sm-12">
                            <label for="id_product">Código de producto</label>
                            <input class="form-control" type="text" name="id_product" id="id_product">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-field col-sm-12">
                            <label for="name">Nombre producto</label>
                            <input class="form-control" type="text" name="name" id="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-field col-sm-12">
                            <label for="description">Descripción</label>
                            <textarea id="description" name="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col-sm-6">
                            <label for="quantity">Cantidad</label>
                            <input class="form-control" type="text" name="quantity" id="quantity">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="unit_price">Precio Unitario</label>
                            <input class="form-control" type="text" name="unit_price" id="unit_price">
                        </div>
                    </div>
                </b-modal>
            </div>


            <b-table
                hover
                dark
                :items="items"
                :fields="fields"
                ref="products"
            >
                <template v-slot:cell(actions)="row">
                    <div class="d-flex justify-content-around">
                        <b-button variant="outline-warning" @click="show = !show, setSelectedCaexData(row.index, row.item)">
                            <b-icon icon="pencil-square" aria-hidden="true"></b-icon>
                        </b-button>
                        <b-button variant="outline-danger">
                            <b-icon icon="trash-fill" aria-hidden="true" @click="deleteRestrictions(row.item.truck_code, row.index)"></b-icon>
                        </b-button>
                    </div>
                </template>
            </b-table>
        </div>
</template>

<script>
    import axios from 'axios'
    import { APIUrl } from '../APIConfig'

    export default {
        name: 'ProductsComponent',
        props: {
            rutUser: Number
        },
        data() {
            return {
                items: [],
                fields: [
                    { key: 'id_product', label: 'Código producto' },
                    { key: 'name', label: 'Nombre' },
                    { key: 'quantity', label: 'Cantidad' },
                    { key: 'unit_price', label: 'Precio unitario' },
                    { key: 'actions', label: '', tdClass: 'icons-column-width'}
                ],
                nombre: ''
            }
        },
        mounted() {
            axios.get(APIUrl('products'))
                .then(res => {
                    res.data.data.forEach((product) => {
                        const producto = { id_product: product.id_product, name: product.name, quantity: product.quantity, unit_price: product.unit_price }
                        this.items.push(producto)
                        console.log(this.items)
                    })
                })
                .catch(err => console.log(err))
            console.log('Component mounted :)', this.rutUser)
        },
    }
</script>
<style scoped>
.icons-column-width {
    width: 150px;
    max-width: 150px;
}
</style>
