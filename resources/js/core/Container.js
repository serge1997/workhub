import { ApiModule } from "./ApiModule.js";
export class Container{
    constructor(){
        this.bindings = [];
    };

    bind(key, callback) {
        this.bindings[key] = callback;
    }

    resolve() {
        this.bind('ApiModule', function() {
            return new ApiModule();
        })

        return this.bindings;
    }

    get(key) {
        const resolvingClass = this.resolve();
        const keys = Object.keys(resolvingClass);
        if (!keys.includes(key)){
            throw new ReferenceError("Class not binding or not exists");
        }

        return resolvingClass[key]();
    }

    static app(){
        return new this;
    }
}
