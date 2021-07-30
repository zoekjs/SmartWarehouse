import ProductsRepository from './ProductsRepository'
import AuditRepository from './AuditRepository'
import ProvidersRepository from './ProvidersRepository'
import CountriesRepository from "./CountriesRepository"
import PurchaseOrderPaymentRepository from './PurchaseOrderPaymentRepository'
import PurchaseOrderPayedRepository from './PurchaseOrderPayedRepository'

const repositories = {
    'products': ProductsRepository,
    'audit': AuditRepository,
    'providers': ProvidersRepository,
    'countries': CountriesRepository,
    'payment': PurchaseOrderPaymentRepository,
    'payed': PurchaseOrderPayedRepository
}
export default {
    get: name => repositories[name]
}
