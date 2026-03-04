const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = (env, argv) => {
  const isProduction = argv.mode === "production";

  return {
    entry: {
      main: "./src/index.js",
      style: "./src/style.js", // doit importer ton SCSS
    },

    output: {
      filename: "[name].bundle.js",
      path: path.resolve(__dirname, "assets/dist"),
      clean: true,
      assetModuleFilename: "media/[name][ext][query]",
    },

    module: {
      rules: [
        // CSS pur (ex: swiper.css)
        {
          test: /\.css$/i,
          use: [
            isProduction ? MiniCssExtractPlugin.loader : "style-loader",
            {
              loader: "css-loader",
              options: { sourceMap: !isProduction },
            },
            {
              loader: "postcss-loader",
              options: {
                sourceMap: !isProduction,
                postcssOptions: {
                  plugins: [require("@tailwindcss/postcss")],
                },
              },
            },
          ],
        },

        // SCSS
        {
          test: /\.s[ac]ss$/i,
          use: [
            isProduction ? MiniCssExtractPlugin.loader : "style-loader",
            {
              loader: "css-loader",
              options: { sourceMap: !isProduction },
            },
            {
              loader: "postcss-loader",
              options: {
                sourceMap: !isProduction,
                postcssOptions: {
                  plugins: [
                    require("@tailwindcss/postcss"),
                    require("autoprefixer"),
                  ],
                },
              },
            },
            {
              loader: "sass-loader",
              options: { sourceMap: !isProduction },
            },
          ],
        },

        // Images
        {
          test: /\.(png|jpe?g|gif|svg|webp|avif)$/i,
          type: "asset/resource",
        },

        // Fonts
        {
          test: /\.(woff2?|eot|ttf|otf)$/i,
          type: "asset/resource",
        },
      ],
    },

    plugins: [
      // En production => extrait un CSS réel
      ...(isProduction
        ? [
            new MiniCssExtractPlugin({
              filename: "[name].bundle.css",
            }),
          ]
        : []),
    ],

    devtool: isProduction ? false : "source-map",

    watchOptions: {
      ignored: /node_modules/,
    },
  };
};
