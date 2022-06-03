"use strict";
// Class definition

var KTDatatableHtmlTableDemo = function() {
    // Private functions

    // demo initializer
    var demo = function() {

		// var datatable = $('#kt_datatable').KTDatatable({
		// 	data: {
		// 		saveState: {cookie: false},
		// 	},
		// 	search: {
		// 		input: $('#kt_datatable_search_query'),
		// 		key: 'generalSearch'
		// 	},
		// 	columns: [
		// 		{
		// 			field: 'DepositPaid',
		// 			type: 'number',
		// 		},
		// 		{
		// 			field: 'OrderDate',
		// 			type: 'date',
		// 			format: 'YYYY-MM-DD',
		// 		}, {
		// 			field: 'Status',
		// 			title: 'Статус',
		// 			autoHide: false,
		// 			// callback function support for column rendering
		// 			template: function(row) {
		// 				var status = {
		// 					1: {
		// 						'title': 'Онлайн',
		// 						'class': ' label-light-success'
        //                     },
		// 					2: {
        //                         'title': 'Оффлайн',
        //                         'class': ' label-light-primary'
        //                     },
		// 					3: {
        //                         'title': 'Заблокирован',
        //                         'class': ' label-light-danger'
        //                     },
		//
		// 				};
		// 				return '<span class="label font-weight-bold label-lg' + status[row.Status].class + ' label-inline">' + status[row.Status].title + '</span>';
		// 			},
		// 		}, {
		// 			field: 'Type',
		// 			title: 'Type',
		// 			autoHide: false,
		// 			// callback function support for column rendering
		// 			template: function(row) {
		// 				var status = {
		// 					1: {
        //                         'title': 'Online',
        //                         'state': 'danger'
        //                     },
		// 					2: {
        //                         'title': 'Retail',
        //                         'state': 'primary'
        //                     },
		// 					3: {
        //                         'title': 'Direct',
        //                         'state': 'success'
        //                     },
		// 				};
		// 				return '<span class="label label-' + status[row.Type].state + ' label-dot mr-2"></span><span class="font-weight-bold text-' +status[row.Type].state + '">' +	status[row.Type].title + '</span>';
		// 			},
		// 		},
		// 	],
		// });



        // $('#kt_datatable_search_status').on('change', function() {
        //     datatable.search($(this).val().toLowerCase(), 'Status');
        // });
		//
        // $('#kt_datatable_search_type').on('change', function() {
        //     datatable.search($(this).val().toLowerCase(), 'Type');
        // });
		//
        // $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
		var datatable = $('#kt_datatable').KTDatatable({
            data: {
                		saveState: {cookie: false},
                	},
        });
    };

    return {
        // Public functions
        init: function() {
            // init dmeo
            demo();
        },
    };
}();

jQuery(document).ready(function() {
	KTDatatableHtmlTableDemo.init();
});