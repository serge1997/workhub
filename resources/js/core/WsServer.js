export class WsServer {
    #server = null;
    constructor(url){
        this.#server = new WebSocket(url);
    }

    listen(toast){
        this.#server.onopen = e => console.log("Websocket connected ");

        this.#server.onmessage = data => {
            let obj = JSON.parse(`${event.data}`);
                console.log(obj)
                if (obj.data){
                  toast(data.title);
                }
        }

        this.#server.onclose = e => {
            console.log("Websocket closed ");
            setTimeout(() => {
                this.handle(url);
            }, 10000)
        }

        this.#server.onerror = e => {
            console.log("Websocket close. try new connection in 20s");
            setTimeout(() => {
                this.wssocket(url);
            }, 20000)
        }
    }
}
