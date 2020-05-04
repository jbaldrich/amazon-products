const presets = [
	[
		"@babel/env",
		{
			targets: {
				safari: "10"
			},
			useBuiltIns: "usage"
		}
	],
	["minify"]
];

const plugins = [["@babel/plugin-transform-arrow-functions"]];

module.exports = { presets, plugins };
