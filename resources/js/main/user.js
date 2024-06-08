export class User {
    constructor(){
        this.name = '';
        this.username = '';
        this.email = '';
        this.password = '';
        this.position_id = '';
        this.manager_id = '';
        this.user_type = ''
        this.department_id = ''
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
}
