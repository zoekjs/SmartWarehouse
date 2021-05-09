import ProductsRepository from './ProductsRepository'

const repositories = {
    'products': ProductsRepository
}
export default {
    get: name => repositories[name]
}
