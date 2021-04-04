<template>
        <div>
            <div>
                <b-button v-b-modal.modal-add-product-1>Añadir producto</b-button>

                <b-modal id="modal-add-product-1" centered title="Añadir producto">
                    <p class="my-4">Vertically centered modal!</p>
                </b-modal>
            </div>


            <b-table
                striped
                hover
                dark
                :items="items"
                :fields="fields"
                ref="products"
            >
            </b-table>
        </div>
</template>

<script>
    import axios from 'axios'
    export default {
        created() {
          axios.get('http://localhost:8083/api/products')
          .then(res => {
              console.log(res.data.data)
              res.data.data.forEach((product) => {
                  const producto = { id_product: product.id_product, name: product.name, quantity: product.quantity, unit_price: product.unit_price }
                  this.items.push(producto)
              })
          })
            .catch(err => console.log(err))
        },
        data() {
            return {
                items: [],
                fields: [
                    { key: 'id_product', label: 'Código producto' },
                    { key: 'name', label: 'Nombre' },
                    { key: 'quantity', label: 'Cantidad' },
                    { key: 'unit_price', label: 'Precio unitario' },
                    { key: 'actions', label: ''}
                ],
                nombre: ''
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
