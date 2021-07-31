import Client from './clients/AxiosClient'
const resource = "oc-payment";

export default {
    get() {
        return Client.get(`${resource}`);
    },
    update(id_purchase_order, rutUser) {
        return Client.put(`${resource}/${id_purchase_order}`, { headers: { 'X-Rut-User': rutUser}});
    }
};
