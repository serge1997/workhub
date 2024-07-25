import { Container } from "./Container.js";

export default {
    install(app) {
        const container = Container.app();
        app.config.globalProperties.App = container;
        app.config.globalProperties.Api = container.getInstance('ApiModule');;
        app.config.globalProperties.ApiV2 = container.getInstance('ApiModuleV2');
    }
}
