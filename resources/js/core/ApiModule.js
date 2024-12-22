import axios from "axios";
export class ApiModule {
    constructor(){
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`
        this.baseURL = `${location.origin}/api/v1/`;
    }

    async post(url, data){
        console.log("**** REQUEST POST " + url)
        return await axios.post(this.baseURL + url, data);
    }

    async put(url, params = null, data = null){
        console.log("**** REQUEST PUT " + url)
        return await axios.put(this.baseURL + url, data ?? data, {params: params})
    }
    async get(url, params = null){
        console.log("**** REQUEST GET " + url)
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`
        return await axios.get(this.baseURL + url, {params: params});
    }

    async delete(url, params = null){
        console.log("**** REQUEST DELETE " + url)
        return await axios.delete(this.baseURL + url, {params: params})
    }
}
