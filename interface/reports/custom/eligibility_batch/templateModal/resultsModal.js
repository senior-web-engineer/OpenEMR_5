/*
Dependencies:
 set the following variables / pre-requisites:
 var WEBROOT = '<?php echo $GLOBALS['webroot'] ?>/interface/reports/custom/eligibility_batch';
*/
var template = null;

$(function () {


    $(".detailRow").click(function () {
        var recid = $(this).attr("id");
        ResultsPopper(recid);
    });

    Handlebars.registerHelper('fCurrency', function (value) { // Format Currency
        // return value.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        return '$' + parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    });

    Handlebars.registerHelper('fProper', function (value) { // Format Proper : bob_jones => Bob Jones
        if (typeof value === "string") {
            var aNoDash = value.split('_').join(' ').split(' ');
            var aProper = [];
            $.each(aNoDash, function (idx, word) {
                word = word.charAt(0).toUpperCase() + word.slice(1);
                aProper.push(word);
            });
            value = aProper.join(' ');
        }
        return value;
    });

    Handlebars.registerHelper('jsonBeauty', formatter);

    // preparing template
    $.get(WEBROOT + '/templateModal/resultsTemplate.hbs', function (data) {
        template = Handlebars.compile(data);
    }, 'html')

    // preparing popup
    $("#results_div").load(WEBROOT + '/templateModal/resultsModal.html', function () {
        // testing purposes
        $("#popIt").click(function () {
            $("#results_dialog").modal('show');
        });
    });

    $("#loading_div").load(WEBROOT + '/templateModal/loadingModal.html', function () {
        // testing purposes
        $("#popIt").click(function () {
            $("#results_dialog").modal('show');
        });
    });

});

function ResultsPopper(recid) {
    console.log("Selected record = " + recid);
    pleaseWait.show();
    loadData("resultjson", { recid: recid }, function (data) {
        if (data.length > 0 && typeof data === "object") {
            var jsonStr = data[0].results_json;
            var jsonData = JSON.parse(jsonStr);
            // console.log("response " + jsonStr);

            $("#resultsTemplatePlaceholder").html(template(jsonData));
            $("#results_dialog").modal('show');
        } else {
            alert("no results");
            console.log("no results");
        }
        pleaseWait.hide();
    })
}

function loadData(fn, data, callBack) {
    var results = [];
    $.ajax({
        type: "GET",
        url: WEBROOT + "/templateModal/resultsAPI.php?fn=" + fn,
        data: data,
        success: function (data) {
            if (!!data) {
                data = JSON.parse(data);
                if (!!data.generator) {
                    results = data.generator;
                }
            }
        },
        complete: function () {
            callBack(results);
        }
    });
}

var pleaseWait = {
    $pleaseWaitModal: null,

    show: function () {
        $("#loadMe").modal({
            backdrop: "static", //remove ability to close modal with click
            keyboard: false, //remove option to close with keyboard
            show: true //Display loader!
        });
    },

    hide: function () {
        $("#loadMe").modal("hide");
    }
};
