import { ApiModule } from "./ApiModule";

export class ApiModuleV2 extends ApiModule{
    constructor(){
        super().baseURL = `${location.origin}/api/v2/`;
    }
}
