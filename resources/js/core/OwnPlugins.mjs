import { ApiModule } from "./ApiModule.js"
import { Container } from "./Container.js";
export default {
    install(app) {
        const container = Container.app();
        const apiInstance = container.getInstance('ApiModule');
        app.config.globalProperties.$Api = apiInstance;
        app.config.globalProperties.$App = container;
        //app.provide('api', app);
    }
}
