require('./bootstrap');
import 'datatables.net';
// require('datatables.net-buttons');
import 'jszip';

import 'datatables.net-buttons';
import 'datatables.net-buttons/js/buttons.colVis.js';
import 'datatables.net-buttons/js/buttons.flash.js';
import 'datatables.net-buttons/js/buttons.html5.js';
import 'datatables.net-buttons/js/buttons.print.js';

$(document).ready(function () {
    let t = $('#spreadsheet').DataTable({
        dom: 'Blfrtip',
        paging: false,
        buttons: [
            'copy', 'excel', 'pdf'
        ]
    });
});