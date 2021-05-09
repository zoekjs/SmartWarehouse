import Client from './clients/AxiosClient'
const resource = 'audit'

export default {
    get () {
        return Client.get(`${ resource }`)
    }
}
