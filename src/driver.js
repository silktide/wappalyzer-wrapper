'use strict';

/**
 * This file allows the use of Wappalyzer without the inbuilt Zombie spider.
 *
 * It reads page data from a simple JSON file and outputs the found technologies as JSON.
 */

const Wappalyzer = require('../node_modules/wappalyzer/wappalyzer');
const fs = require('fs');
const path = require('path');

const wappalyzer = new Wappalyzer();

const args = process.argv.slice(2);

const inputFile = args[0] || '';

if ( !inputFile ) {
    process.stderr.write('No input file specified\n');

    process.exit(1);
}

const document = JSON.parse(fs.readFileSync(inputFile));
const json = JSON.parse(fs.readFileSync(path.resolve(__dirname, '../node_modules/wappalyzer/apps.json')));

wappalyzer.apps = json.apps;
wappalyzer.categories = json.categories;

wappalyzer.driver.log = (message, source, type) => {
};

wappalyzer.driver.displayApps = detected => {
    var apps = [];

    Object.keys(detected).forEach(appName => {
        const app = detected[appName];

        var categories = [];

        app.props.cats.forEach(id => {
            var category = {};

            category[id] = wappalyzer.categories[id].name;

            categories.push(category)
        });


        apps.push({
            name: app.name,
            confidence: app.confidenceTotal.toString(),
            version: app.version,
            icon: app.props.icon || 'default.svg',
            website: app.props.website,
            categories
        });
    });

    process.stdout.write(JSON.stringify(apps) + '\n');
    process.exit();
};


// Bastardise the headers since Wappalyzer changed it to support multiple headers with the same key
const headers = {};

for (let headerName in document.headers) {
    let headerValue = document.headers[headerName];
    headers[headerName] = [headerValue];
}


wappalyzer.analyze(
    document.hostname,
    document.url, {
        headers,
        html: document.html,
        env: document.env
    }
);