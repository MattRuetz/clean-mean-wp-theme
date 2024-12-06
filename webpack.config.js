const defaultConfig = require("@wordpress/scripts/config/webpack.config");
const path = require("path");

module.exports = {
    ...defaultConfig,
    entry: {
        "km-tabs": path.resolve(__dirname, "blocks/km-tabs/src/index.js"),
    },
    output: {
        path: path.resolve(__dirname, "blocks/km-tabs/build"),
        filename: "index.js",
    },
};
