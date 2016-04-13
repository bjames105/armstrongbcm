module.exports = [

    {
        entry: {
			"groups": "./app/views/groups.js",
			"group": "./app/views/group.js",
			"admin-groups": "./app/views/admin/groups.js",
            "admin-categories": "./app/views/admin/categories.js",
            "settings": "./app/views/admin/settings.js",
			"link-groups": "./app/components/groups-link.vue",
            "util": './app/scripts/util.js'
        },
        output: {
            filename: "./app/bundle/[name].js"
        },
        externals: {
            "lodash": "_",
            "jquery": "jQuery",
            "uikit": "UIkit",
            "vue": "Vue",
            "site": "Site"
        },
        module: {
            loaders: [
                { test: /\.vue$/, loader: "vue" }
            ]
        }
    }

];
