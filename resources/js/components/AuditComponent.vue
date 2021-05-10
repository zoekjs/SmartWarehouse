<template>
    <div>
        <div class="col-12 mb-4">
            <h3>Auditoría</h3>
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
        >
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
const AuditRepository = Repository.get('audit')

export default {
    name: "AuditComponent",
    props: {
        rutUser: Number
    },
    data () {
        return {
            items: [],
            fields: [
                { key: 'rut', sortable: true},
                { key: 'name', label: 'Nombre', sortable: true},
                { key: 'action', label: 'Acción'},
                { key: 'date', label: 'Fecha', sortable: true}
            ],
            perPage: 10,
            currentPage: 1,
            filter: null,
            filterOn: [],
            itemsFiltered: false
        }
    },
    async mounted () {
        await this.dataForTable()
    },
    computed: {
        rows() {
            return this.items.length
        }
    },
    methods: {
      async dataForTable () {
        const auditData = await AuditRepository.get();
        console.log(auditData.data.data)
        await this.fillTable(auditData.data.data)
      },
      fillTable(auditData) {
          auditData.forEach((registry) => {
              const data = { rut: registry.rut_user, name: `${ registry.name } ${ registry.last_name }`,
              action: registry.action, date: registry.created_at }
              this.items.push(data)
          })
          console.log(this.items)
      },
      itemsFilter (evt) {
          this.itemsFiltered = evt.length === 0
      }
    }
}
</script>
