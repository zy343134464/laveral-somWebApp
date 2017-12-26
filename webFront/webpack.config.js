var webpack = require('webpack')
module.exports = {
  	entry: './app.js',
  	output: {
    	filename: './dist/bundle.js'
  	},
	module: {
        loaders: [
            {
                test: /\.js[x]?$/,
                exclude: /node_modules/,
                loader:'babel-loader?presets[]=es2015&presets[]=react'
            },
            {
                test: /\.css$/,
                loader: 'style-loader!css-loader'
            },
            { test: /\.(png|woff|woff2|eot|ttf|svg)$/, loader: 'url-loader?limit=100000' }
        ]
	},
    plugins: [
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery"
        }),
    ]
}
