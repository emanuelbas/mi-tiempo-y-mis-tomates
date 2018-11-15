/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.scss in this case)
// Sass CSS
require('../css/app.scss');
require('../css/navigation.scss');
require('../css/login.scss');
require('../css/registration.scss');
require('../css/task-creation.scss');
require('../css/my-tasks.scss');
require('../css/account-configuration.scss');
require('../css/pomodoro-configuration.scss');
require('../css/navigation-task.scss');
require('../css/plugins/parsley.css');

// Javascript
require('../js/plugins/parsley.min.js');
require('../js/plugins/parsley-es.js');
require('../js/registration.js');

// Images
const imagesContext = require.context('../img', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);


// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
var $ = require('jquery');
require('bootstrap');