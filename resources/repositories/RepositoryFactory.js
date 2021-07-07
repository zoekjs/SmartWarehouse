import ProductsRepository from './ProductsRepository'
import AuditRepository from './AuditRepository'
import ProvidersRepository from './ProvidersRepository'

const repositories = {
    'products': ProductsRepository,
    'audit': AuditRepository,
    'providers': ProvidersRepository
}
export default {
    get: name => repositories[name]
}
