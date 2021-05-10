import ProductsRepository from './ProductsRepository'
import AuditRepository from "./AuditRepository";

const repositories = {
    'products': ProductsRepository,
    'audit': AuditRepository
}
export default {
    get: name => repositories[name]
}
