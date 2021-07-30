import Client from './clients/AxiosClient'
const resource = "payedPOs";

export default {
    get() {
        return Client.get(`${resource}`);
    },
    update(id, payload) {
        return Client.put(`${resource}/${id}`, payload);
    }
};
