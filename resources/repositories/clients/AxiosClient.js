import axios from 'axios'

const baseURL= 'https://smartwarehouse.brazilsouth.cloudapp.azure.com/api'

export default axios.create({
    baseURL
})
