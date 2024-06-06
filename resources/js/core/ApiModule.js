import axios from "axios";
export class ApiModule {
    constructor(){
        this.baseURL = `${location.origin}/api/`;
    }

    async post(url, data){
        return await axios.post(this.baseURL + url, data);
    }
}
