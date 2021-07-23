<template>
    <div>

        <div class="d-flex mb-3 col-12">
            <b-modal id="modal-add-provider" centered ref="createProviderModal" title="Añadir proveedor">
                <input type="text" hidden name="rut_user" value="rutUser">
                <div class="row">
                    <div class="form-group col-sm-6 ml-3">
                        <div class="input-field">
                            <label>Rut proveedor (sin puntos) <span v-b-tooltip.hover title="Campo obligatorio"
                                                                    class="text-danger">(*)</span></label>
                            <input class="form-control" type="text" v-model="rutProvider" maxlength="8">
                            <span v-if="!rutValidatorCheck" class="text-danger">El rut ingresado no es válido</span>
                        </div>
                    </div>
                    <div class="form-group col-sm-2">
                        <div class="input-field ">
                            <label>Dv <span v-b-tooltip.hover title="Campo obligatorio"
                                            class="text-danger">(*)</span></label>
                            <input class="form-control" type="text" v-model="dv" maxlength="1">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-field col-sm-12">
                        <label>País <span v-b-tooltip.hover title="Campo obligatorio" class="text-danger">(*)</span>
                        </label>
                        <b-form-select v-model="selectedCountry" :options="countries"></b-form-select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-field col-sm-12">
                        <label>Nombre proveedor <span v-b-tooltip.hover title="Campo obligatorio"
                                                      class="text-danger">(*)</span></label>
                        <input class="form-control" type="text" v-model="name" maxlength="30">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-field col-sm-12">
                        <label>Teléfono</label>
                        <input class="form-control" type="text" v-model="telephone" maxlength="10">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-field col-sm-12">
                        <label>Dirección <span v-b-tooltip.hover title="Campo obligatorio"
                                               class="text-danger">(*)</span></label>
                        <input class="form-control" type="text" v-model="address" maxlength="30">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group col-sm-12">
                        <label>Correo de contacto <span v-b-tooltip.hover title="Campo obligatorio" class="text-danger">(*)</span></label>
                        <input class="form-control" type="text" v-model="email" maxlength="25">
                        <span v-if="!emailValidatorCheck" class="text-danger">El email ingresado no es válido</span>
                    </div>
                </div>
                <template #modal-footer="{ aceptar, cancel}">
                    <b-button size="sm" variant="success" :disabled="disabledButton" @click="createProvider()">
                        Aceptar
                    </b-button>
                    <b-button size="sm" variant="danger" @click="clearProvidersForm()">
                        Cancelar
                    </b-button>
                </template>
            </b-modal>
            <!-- MODAL EDIT PROVIDER -->
            <b-modal v-model="show" id="modal-edit-provider" centered ref="editProviderModal"
                     title="Modificar proveedor">
                <input type="text" hidden name="rut_user" value="rutUser">
                <div class="row">
                    <div class="form-group col-sm-6 ml-3">
                        <div class="input-field">
                            <label>Rut proveedor (sin puntos) <span v-b-tooltip.hover title="Campo obligatorio"
                                                                    class="text-danger">(*)</span></label>
                            <input class="form-control" type="text" v-model="editRutProvider" maxlength="8" readonly>
                        </div>
                    </div>
                    <div class="form-group col-sm-2">
                        <div class="input-field ">
                            <label>Dv <span v-b-tooltip.hover title="Campo obligatorio"
                                            class="text-danger">(*)</span></label>
                            <input class="form-control" type="text" v-model="dv" maxlength="1" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-field col-sm-12">
                        <label>País <span v-b-tooltip.hover title="Campo obligatorio" class="text-danger">(*)</span>
                        </label>
                        <b-form-select v-model="selectedCountry" :options="countries"></b-form-select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-field col-sm-12">
                        <label>Nombre proveedor <span v-b-tooltip.hover title="Campo obligatorio"
                                                      class="text-danger">(*)</span></label>
                        <input class="form-control" type="text" v-model="name" maxlength="30">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-field col-sm-12">
                        <label>Teléfono</label>
                        <input class="form-control" type="text" v-model="telephone" maxlength="10">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-field col-sm-12">
                        <label>Dirección <span v-b-tooltip.hover title="Campo obligatorio"
                                               class="text-danger">(*)</span></label>
                        <input class="form-control" type="text" v-model="address" maxlength="30">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group col-sm-12">
                        <label>Correo de contacto <span v-b-tooltip.hover title="Campo obligatorio" class="text-danger">(*)</span></label>
                        <input class="form-control" type="text" v-model="email" maxlength="25">
                        <span v-if="!emailValidatorCheck" class="text-danger">El email ingresado no es válido</span>
                    </div>
                </div>
                <template #modal-footer="{ aceptar, cancel}">
                    <b-button size="sm" variant="success" :disabled="disabledButton" @click="updateProvider()">
                        Aceptar
                    </b-button>
                    <b-button size="sm" variant="danger" @click="clearProvidersForm()">
                        Cancelar
                    </b-button>
                </template>
            </b-modal>
            <!-- END MODAL UPDATE PROVIDER -->
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
                                <b-button :disabled="!filter" @click="filter = ''">
                                    Limpiar
                                </b-button>
                            </b-input-group-append>
                        </b-input-group>
                    </b-form-group>
                </b-col>
            </div>
            <b-button v-b-modal.modal-add-provider variant="primary" class="mb-3">Añadir proveedor</b-button>
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
                    <b-button variant="outline-warning" @click="show = !show, setSelectedProviderData(row.item)">
                        <b-icon icon="pencil-square" aria-hidden="true"></b-icon>
                    </b-button>
                    <b-button variant="outline-danger" @click="deleteProvider(row.item.rut_provider)">
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
import Repository from '../../repositories/RepositoryFactory'
import {validarRut} from '../../utils/ValidarRut'
import {emailValidator} from "../../utils/EmailValidator";

const CountriesRepository = Repository.get('countries')
const ProvidersRepository = Repository.get('providers')
export default {
    name: 'ProvidersComponent',
    props: {
        rutUser: Number
    },
    data() {
        return {
            items: [],
            countries: [{value: null, text: 'Seleccione una opción', disabled: true}],
            fields: [
                {key: 'rut_provider', label: 'Rut proveedor'},
                {key: 'name', label: 'Nombre'},
                {key: 'telephone', label: 'Número de contacto'},
                {key: 'address', label: 'Dirección'},
                {key: 'email', label: 'Email'},
                {key: 'actions', label: '', tdClass: 'icons-column-width', thClass: 'icons-column-width '}
            ],
            perPage: 10,
            currentPage: 1,
            filter: null,
            filterOn: [],
            disabled: true,
            selectedCountry: null,
            itemsFiltered: false,
            show: false,
            rutProvider: null,
            editRutProvider: null,
            dv: null,
            name: null,
            telephone: null,
            address: null,
            email: null,
        }
    },
    async mounted() {
        await this.countriesData()
        await this.dataForTable()
    },
    computed: {
        rows() {
            return this.items.length
        },
        rutValidatorCheck() {
            if (this.rutProvider !== null && this.dv !== null) {
                return validarRut(this.rutProvider, this.dv)
            }
            return true
        },
        emailValidatorCheck() {
            if (this.email !== null) {
                return emailValidator(this.email)
            }
            return true
        },
        disabledButton() {
            return !(this.rutProvider && this.dv && this.name && this.email && this.address && this.rutValidatorCheck
                && this.emailValidatorCheck)
        },
    },
    methods: {
        async countriesData() {
            const countries = await CountriesRepository.get()
            this.fillCountriesArray(countries)
        },
        fillCountriesArray(countries) {
            countries.data.data.forEach(country => {
                this.countries.push({ value: country.id_country, text: country.name })
            })
        },
        async dataForTable() {
            const providers = await ProvidersRepository.get()
            this.fillTable(providers)
        },
        fillTable(providers) {
            providers.data.data.forEach(provider => this.items.push(provider))
        },
        createProvider() {
            const payload = {
                rut_provider: this.rutProvider, dv: this.dv, name: this.name, telephone: this.telephone,
                address: this.address, email: this.email, id_pais: this.selectedCountry, rut_user: this.rutUser
            }
            ProvidersRepository.create(payload)
                .then(res => {
                    this.items.length = 0
                    this.dataForTable()
                    this.clearProvidersForm()
                    this.$swal('Todo listo !"', res.data.message, 'success')
                })
                .catch(err => {
                    console.log(err)
                    if (err.message === 'Request failed with status code 422') {
                        this.$swal('Algo malió sal :(', 'El proveedor ya está registrado en el sistema', 'error')
                    }
                })
        },
        itemsFilter(evt) {
            this.itemsFiltered = evt.length === 0
        },
        setSelectedProviderData(item) {
            this.editRutProvider = item.rut_provider
            this.dv = this.editRutProvider.substring(this.editRutProvider.length, 8)
            this.rutProvider = this.editRutProvider.substring(0, this.editRutProvider.length - 1)
            ProvidersRepository.getById(item.rut_provider)
                .then((res) => {
                    this.name = res.data[0].name
                    this.telephone = res.data[0].telephone
                    this.address = res.data[0].address
                    this.email = res.data[0].email
                    this.selectedCountry = res.data[0].id_country
                    this.show = true
                })
                .catch(err => console.log(err))
        },
        updateProvider() {
            const payload = {
                rut_provider: this.editRutProvider, name: this.name, telephone: this.telephone,
                address: this.address, email: this.email, id_country: this.selectedCountry, rut_user: this.rutUser
            }
            ProvidersRepository.update(payload, this.editRutProvider)
                .then((res) => {
                    this.$swal('Todo Listo !', res.data.message, 'success')
                    this.items.length = 0
                    this.dataForTable()
                    this.clearProvidersForm()
                    this.show = false
                })
                .catch(err => console.log(err))
        },
        deleteProvider(rutProvider) {
            this.$swal({
                title: 'Estás seguro?',
                text: "Esta acción no se puede revertir!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, borrarlo!',
                cancelButtonText: 'cancelar'
            }).then((result) => {
                if(result.isConfirmed) {
                    ProvidersRepository.delete(rutProvider, this.rutUser)
                        .then((res) => {
                            this.items.length = 0
                            this.dataForTable()
                            this.$swal('Todo listo !"', res.data.message, 'success')
                        })
                }
            })
        },
        clearProvidersForm() {
            this.rutProvider = null
            this.dv = null
            this.selectedCountry = null
            this.name = null
            this.telephone = null
            this.address = null
            this.email = null
            this.$refs.createProviderModal.hide()
            this.show = false
        },
    }
}
</script>

<style scoped>

</style>
