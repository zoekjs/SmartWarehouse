import Client from "./clients/AxiosClient";
const resource = "products";
const deleted = "deleted-products";
const restore = "restore-product";

export default {
    get() {
        return Client.get(`${resource}`);
    },
    getById(id) {
        return Client.get(`${resource}/${id}`);
    },
    create(payload) {
        return Client.post(`${resource}`, payload);
    },
    update(payload, id) {
        return Client.put(`${resource}/${id}`, payload);
    },
    delete(id, rutUser) {
        return Client.delete(`${resource}/${id}`, {
            headers: { "X-Rut-User": rutUser }
        });
    },
    getDeleted() {
        return Client.get(`${deleted}`);
    },
    restore(id, rutUser) {
        return Client.get(`${restore}/${id}`, {
            headers: { "X-Rut-User": rutUser }
        });
    }
};
