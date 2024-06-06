import axios from "axios";
export class ApiModule {
    #baseURL = `${location.origin}/api/`;

    constructor(){}

    async post(url, data){
        return await axios.post(this.#baseURL + url, data);
    }
}
