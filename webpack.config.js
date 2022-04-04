const Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.js')
    .enableStimulusBridge('./assets/controllers.json')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabel((config) => { config.plugins.push('@babel/plugin-proposal-class-properties'); })
    .configureBabelPresetEnv((config) => { config.useBuiltIns = 'usage'; config.corejs = 3; })
    .addPlugin(new CopyWebpackPlugin({ patterns: [{ from: './assets/fonts', to: 'fonts' }] }))
    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();