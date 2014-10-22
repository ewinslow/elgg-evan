cp bower_components/angular/angular-csp.css              views/default/js
cp bower_components/angular/angular.js                   views/default/js
cp bower_components/angular-animate/angular-animate.js   views/default/js
cp bower_components/angular-resource/angular-resource.js views/default/js
cp bower_components/angular-route/angular-route.js       views/default/js
cp bower_components/angular-sanitize/angular-sanitize.js views/default/js
cp bower_components/jquery/src/* -r                      views/default/js/jquery
cp bower_components/jquery/src/sizzle/dist/sizzle.js     views/default/js
cp bower_components/jquery-ui/ui/* -r                    views/default/js/jquery-ui
cp bower_components/momentjs/moment.js                   views/default/js
cp bower_components/normalize.css/normalize.css          views/default/js
cp bower_components/require-css/css.js                   views/default/js/require-css
cp bower_components/require-css/css-builder.js           views/default/js/require-css
cp bower_components/require-css/normalize.js             views/default/js/require-css
cp bower_components/requirejs/require.js                 views/default/js
cp bower_components/requirejs-text/text.js               views/default/js


rm views/default/js/jquery-ui/minified -rf
rm views/default/js/jquery/sizzle -rf