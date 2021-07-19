import ProductsRepository from './ProductsRepository'
import AuditRepository from './AuditRepository'
import ProvidersRepository from './ProvidersRepository'
import CountriesRepository from "./CountriesRepository"

const repositories = {
    'products': ProductsRepository,
    'audit': AuditRepository,
    'providers': ProvidersRepository,
    'countries': CountriesRepository
}
export default {
    get: name => repositories[name]
}
