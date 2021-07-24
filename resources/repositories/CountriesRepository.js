import Client from './clients/AxiosClient'
const resource = 'countries'

export default {
    get() {
        return Client.get(`${ resource }`)
    }
}
