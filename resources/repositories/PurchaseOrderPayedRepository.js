import Client from './clients/AxiosClient'
const resource = "payedPOs";

export default {
    get() {
        return Client.get(`${resource}`);
    },
    update(id, rutUser) {
        return Client.put(`${resource}/${id}`, { headers: { 'X-Rut-User': rutUser}});
    }
};
