import axios from "axios";
export class ApiModule {
    constructor(){
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`
        this.baseURL = `${location.origin}/api/v1/`;
    }

    async post(url, data){
        return await axios.post(this.baseURL + url, data);
    }

    async put(url, params = null, data = null){
        return await axios.put(this.baseURL + url, data ?? data, {params: params})
    }
    async get(url, params = null){
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`
        return await axios.get(this.baseURL + url, {params: params});
    }

    async delete(url, params = null){
        return await axios.delete(this.baseURL + url, {params: params})
    }
}
