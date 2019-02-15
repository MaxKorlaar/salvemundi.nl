require('./bootstrap');
import 'datatables.net';
import jsZip from 'jszip';
import 'datatables.net-buttons';
import 'datatables.net-buttons/js/buttons.colVis.min';
import 'datatables.net-buttons/js/dataTables.buttons.min';
import 'datatables.net-buttons/js/buttons.flash.min';
import 'datatables.net-buttons/js/buttons.html5.min';

// This line was the one missing
window.JSZip = jsZip;

$(document).ready(function () {
    let t = $('#spreadsheet').DataTable({
        dom: 'Blfrtip',
        paging: false,
        buttons: [
            'copy', 'excel', 'pdf'
        ]
    });
    $('.buttons-excel, .buttons-copy').on('click', () => {
       alert(window.SalveMundi.copy_warning);
    });
});