import { Container } from './../core/Container.js';
export class User {
    constructor(){
        this.name = '';
        this.username = '';
        this.email = '';
        this.password = '';
        this.position_id = null;
        this.manager_id = null;
        this.app = Container.app();
        this.Api = this.app.get('ApiModule');
        return new Proxy(this, {
            set: (target, prop, val) => {
                if (!Object.hasOwn(target, prop)){
                    throw new Error('Property doesnt exists in class. name of ' + prop);
                }
                target[prop] = val;
                return true;
            }
        })
    }

    create(url){
        const postData = {
            name: this.name,
            email: this.email,
            username: this.username,
            password: this.password,
            position_id: this.position_id = null,
            manager_id: this.manager_id = null
        }
        return new Promise((resolve, reject) => {
            this.Api.post(url, postData)
                .then(response => {
                    if (response.status === 200){
                        resolve(response.data)
                    }
                })
                .catch(error => reject(error.response.data.errors))
        })
    }
}
