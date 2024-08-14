import { Container } from "./Container.js";
import { Authentication } from "./Authentication.js";

export default {
    install(app) {
        const container = Container.app();
        app.config.globalProperties.App = container;
        app.config.globalProperties.Auth = new Authentication();
        app.config.globalProperties.Api = container.getInstance('ApiModule');
        app.config.globalProperties.Apiv2 = container.getInstance('ApiModuleV2');
    }
}
