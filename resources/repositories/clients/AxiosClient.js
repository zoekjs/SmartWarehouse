import axios from 'axios'

const baseURL= 'http://localhost:8083/api/'

export default axios.create({
    baseURL
})
