import Client from './clients/AxiosClient'
const resource = 'audit'

export default {
    get (page, size) {
        return Client.get(`${ resource }`)
    }
}
