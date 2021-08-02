import Client from "./clients/AxiosClient";
const resource = "tags";

export default {
    get() {
        return Client.get(`${resource}`);
    },
    update(id, payload, rutUser) {
      return Client.put(`${resource}/${id}`, payload, {headers: {'X-Rut-User': rutUser}});
    },
    getAsociations() {
      return Client.get('tag/prods');
    },
    delete(id, rutUser, id_product) {
      return Client.delete(`${resource}/${ id }`, {headers: {'X-Rut-User': rutUser, 'X-Id-Product': id_product}});
    }
};
