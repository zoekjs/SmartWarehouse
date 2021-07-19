import Client from './clients/AxiosClient'
const resource = 'providers'

export default {
    get() {
        return Client.get(`${ resource }`)
    },
    getById(id) {
        return Client.get(`${ resource }/${ id }`)
    },
    create(payload) {
        return Client.post(`${ resource }`, payload)
    },
    update(payload, id) {
        return Client.put(`${ resource }`, payload)
    },
    delete(id) {
        return Client.delete(`${ resource }`, id)
    }
}

