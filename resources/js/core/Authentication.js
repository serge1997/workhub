export class Authentication{
    constructor(){}

    create(obj){
        localStorage.setItem('token', obj.token);
        localStorage.setItem('auth', JSON.stringify(obj.auth));
    }

    logout(){
        localStorage.removeItem('token');
        localStorage.removeItem('auth')
    }

    user(){
        return JSON.parse(localStorage.getItem('auth'));
    }
}
