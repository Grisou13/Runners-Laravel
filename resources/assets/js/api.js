import { SwaggerUIBundle, SwaggerUIStandalonePreset } from 'swagger-ui-dist'
const ui = SwaggerUIBundle({
    url: window.Laravel.basePath + "/api/spec.yaml",
    dom_id: '#swagger-ui',
    presets: [
        SwaggerUIBundle.presets.apis,
        SwaggerUIStandalonePreset
    ],
    plugins: [
        SwaggerUIBundle.plugins.DownloadUrl
    ],
    layout: "StandaloneLayout"
})
ui.api.clientAuthorizations.add("key", new SwaggerClient.ApiKeyAuthorization("x-access-token", "root", "header"));
