import { ApiModule } from "./ApiModule.js";
import { ApiModuleV2 } from "./ApiModuleV2.js";

import { User } from "../main/user.js";
export class Container{
    constructor(){
        this.bindings = {};
        this.resolve();
    };

    bind(key, callback) {
        this.bindings[key] = callback;
    }

    resolve() {
        this.bind('ApiModule', () => {
            return new ApiModule();
        })
        this.bind('User', () => {
            return new User();
        })
        this.bind('ApiModuleV2', () => {
            return new ApiModuleV2();
        })
    }

    getInstance(key) {
        if (!Object.hasOwn(this.bindings, key)){
            throw new ReferenceError("Class not binding or not exists");
        }
        return this.bindings[key]();
    }

    static app(){
        return new this();
    }
}
