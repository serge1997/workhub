import axios from "axios";
export class ApiModule {
    constructor(){
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`
        this.baseURL = `${location.origin}/api/`;
    }

    async post(url, data){
        return await axios.post(this.baseURL + url, data);
    }
    async get(url){
        return await axios.get(this.baseURL + url);
    }
}
