/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import './fonts/stylesheet.css';
import 'toastr/build/toastr.min.css';
import 'font-awesome/css/font-awesome.min.css';
import './bvi/dist/css/bvi.min.css';
import 'perfect-scrollbar/css/perfect-scrollbar.css';
import 'prismjs/themes/prism.css';
import 'jquery-contextmenu/dist/jquery.contextMenu.min.css';

import $ from 'jquery';
global.$ = global.jQuery = $;
import 'jquery-mask-plugin';
import 'jquery-ui';
import 'jquery-idletimer';
import 'select2';
import 'jquery-mousewheel';
import 'jquery-contextmenu';



import apiService from './service/api'
global.apiService = apiService

import pagination from './service/paginator'
global.pagination = pagination

import {sendSuccessToastr, sendInfoToastr, sendErrorToastr} from './service/toast'
global.sendSuccessToastr = sendSuccessToastr;
global.sendInfoToastr = sendInfoToastr;
global.sendErrorToastr = sendErrorToastr;