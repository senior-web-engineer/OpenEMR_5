$(function () {

    // call the tablesorter plugin
    $("table").tablesorter({
        theme: 'blue',

        // hidden filter input/selects will resize the columns, so try to minimize the change
        widthFixed: true,

        // initialize zebra striping and filter widgets
        widgets: ["zebra", "filter", "columns"],
        usNumberFormat: false,
        sortReset: true,
        sortRestart: true,
        // headers: { 5: { sorter: false, filter: false } },
        widgetOptions: {
            // css class applied to the table row containing the filters & the inputs within that row
            filter_cssFilter: 'tablesorter-filter',

            // If there are child rows in the table (rows with class name from "cssChildRow" option)
            // and this option is true and a match is found anywhere in the child row, then it will make that row
            // visible; default is false
            filter_childRows: false,

            // if true, filters are collapsed initially, but can be revealed by hovering over the grey bar immediately
            // below the header row. Additionally, tabbing through the document will open the filter row when an input gets focus
            filter_hideFilters: false,

            // Set this option to false to make the searches case sensitive
            filter_ignoreCase: true,

            // jQuery selector string of an element used to reset the filters
            filter_reset: '.reset',

            // Delay in milliseconds before the filter widget starts searching; This option prevents searching for
            // every character while typing and should make searching large tables faster.
            filter_searchDelay: 300,

            // Set this option to true to use the filter to find text from the start of the column
            // So typing in "a" will find "albert" but not "frank", both have a's; default is false
            filter_startsWith: false,

            // if false, filters are collapsed initially, but can be revealed by hovering over the grey bar immediately
            // below the header row. Additionally, tabbing through the document will open the filter row when an input gets focus
            filter_hideFilters: false,

            // Add select box to 4th column (zero-based index)
            // each option has an associated function that returns a boolean
            // function variables:
            // e = exact text from cell
            // n = normalized value returned by the column parser
            // f = search filter input value
            // i = column index
            filter_functions: {

                // Add select menu to this column
                // set the column value to true, and/or add "filter-select" class name to header
                // 0 : true,

                // Exact match only
                1: function (e, n, f, i) {
                    return e === f;
                },

                // Add these options to the select dropdown (regex example)
                2: {
                    "A - D": function (e, n, f, i) { return /^[A-D]/.test(e); },
                    "E - H": function (e, n, f, i) { return /^[E-H]/.test(e); },
                    "I - L": function (e, n, f, i) { return /^[I-L]/.test(e); },
                    "M - P": function (e, n, f, i) { return /^[M-P]/.test(e); },
                    "Q - T": function (e, n, f, i) { return /^[Q-T]/.test(e); },
                    "U - X": function (e, n, f, i) { return /^[U-X]/.test(e); },
                    "Y - Z": function (e, n, f, i) { return /^[Y-Z]/.test(e); }
                },

                // Add these options to the select dropdown (numerical comparison example)
                // Note that only the normalized (n) value will contain numerical data
                // If you use the exact text, you'll need to parse it (parseFloat or parseInt)
                4: {
                    "Male": function (e, n, f, i) { return /^[Male]/.test(e); },
                    "Female": function (e, n, f, i) { return /^[Female]/.test(e); }
                },

                5: {
                    "YES": function (e, n, f, i) { return /^[YES]/.test(e); },
                    "NO": function (e, n, f, i) { return /^[NO]/.test(e); }
                }
            }
        }
    }); // table sorter

    $(".dontsave").click(function () { location.href = '<?php echo "edi_270.php"; ?>'; });

});

function ActionDeterminator() {
    document.theform.action = 'display_results.php';
}

var stringDelete = "Do you want to remove this record?";
var stringBatch = "Please select X12 partner, required to create the 270 batch";

// for form refresh

function refreshme() {
    document.forms[0].submit();
}

//  To delete the row from the reports section
function deletetherow(id) {
    var suredelete = confirm(stringDelete);
    if (suredelete == true) {
        document.getElementById('PR' + id).style.display = "none";
        if (document.getElementById('removedrows').value == "") {
            document.getElementById('removedrows').value = "'" + id + "'";
        } else {
            document.getElementById('removedrows').value = document.getElementById('removedrows').value + ",'" + id + "'";
        }
    }
}

//  To validate the batch file generation - for the required field [clearing house/x12 partner]
function validate_batch() {
    if (document.getElementById('form_x12').value == '') {
        alert(stringBatch);
        return false;
    } else {
        document.getElementById('form_savefile').value = "true";
        document.theform.submit();
    }
}

// To Clear the hidden input field

function validate_policy() {
    document.getElementById('removedrows').value = "";
    document.getElementById('form_savefile').value = "";
    return true;
}

// To toggle the clearing house empty validation message
function toggleMessage(id, x12) {
    var spanstyle = new String();

    spanstyle = document.getElementById(id).style.visibility;
    selectoption = document.getElementById(x12).value;

    if (selectoption != '') {
        document.getElementById(id).style.visibility = "hidden";
    } else {
        document.getElementById(id).style.visibility = "visible";
        document.getElementById(id).style.display = "inline";
    }
    return true;
}
