/**
 * @author				  Yves
 * @created by 			Khoa
 * @description 		feature request
 */

var jqxtheme = 'light';

$(function() {
	var source = {
        datatype: "json",
        datafields:
        [
          { name: 'id', type: 'number' },
          { name: 'title', type: 'string' },
          { name: 'feature', type: 'string' },
          { name: 'feature_comment', type: 'string' },
          { name: 'request_datetime', type: 'date' },
          { name: 'status', type: 'string' },
          { name: 'username', type: 'string' },
          { name: 'admin_comment', type: 'string' },
          { name: 'admin_comment_datetime', type: 'date' }
        ],
        url: 'api.php',
        cache: false,
        filter: function(filters, recordsArray)
        {
          // update the grid and send a request to the server.
          grid.jqxGrid('updatebounddata', 'filter');
        },
        sort: function()
        {
          // update the grid and send a request to the server.
          grid.jqxGrid('updatebounddata', 'sort');
        },
        root: 'Rows',
        beforeprocessing: function(data)
        {   
          source.totalrecords = data[0].TotalRows;          
        }              
    };

    var dataAdapter = new $.jqx.dataAdapter(source);

    const numberCellRenderer = function(row) {
      return '<div class="jqx-grid-cell-left-align number-cell">'+(++ row)+'</div>';
    }

    var gridColumns = '';
    if(isAdmin) {
      gridColumns = [
        { text: '#', width: 70, filterable: false, sortable: false, pinned: true, cellsrenderer: numberCellRenderer },
        { text: 'Title', datafield: 'title', width: 150, pinned: true },
        { text: 'Feature', datafield: 'feature', width: 200 },
        { text: 'Feature Comment', datafield: 'feature_comment', width: 350 },
        { text: 'Request Date', datafield: 'request_datetime', width: 150, filtertype: 'range', cellsformat: 'M/dd/yyyy hh:mm:ss' },
        { text: 'Status', datafield: 'status', width: 120, filtertype: 'list', filteritems: ['request', 'accepted', 'rejected'] },
        { text: 'User', datafield: 'username', width: 150 },
        { text: 'Admin Comment', datafield: 'admin_comment', width: 300, align: 'right', cellsalign: 'right' },
        { text: 'Admin Comment Date', datafield: 'admin_comment_datetime', width: 150, align: 'right', cellsalign: 'right', filtertype: 'range', cellsformat: 'M/dd/yyyy hh:mm:ss' },
        { text: 'Edit', columntype: 'button', width: 60, sortable: false, filterable: false, cellsrenderer: function() {return 'Edit';},
          buttonclick: function(row) {
            var rowdata = grid.jqxGrid('getrowdata', row);
            if(rowdata && rowdata.id) {
              $('#admin-update-feature-form')[0].reset();
              $('#window-admin-comment').jqxWindow('open');
              $('#id-for-admin-comment').val(rowdata.id);
              $('#request-feature-status').val(rowdata.status);
              $('#admin-comment').html(rowdata.admin_comment);
            }
        }},
        { text: 'Delete', columntype: 'button', width: 60, sortable: false, filterable: false, cellsrenderer: function() {return 'Delete';}, buttonclick: function(row) {
            var rowdata = grid.jqxGrid('getrowdata', row);
            if(rowdata && rowdata.id) {
              swal({
                title: "Are you sure continue?",
                text: "Feature request `"+rowdata.title+"` will be deleted!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                  jqxLoader.jqxLoader({text: 'Deleting ...'});
                  jqxLoader.jqxLoader('open');

                  $.ajax({
                    url: saveAdminUrl,
                    method: 'post',
                    data: {id: rowdata.id, type: 'delete'},
                    success: function(data) {                  
                      jqxLoader.jqxLoader('close');
                      if(data === 'ok') {
                        swal("Request Feature", "Feature request `"+rowdata.title+"` was correctly deleted.", "success");
                        grid.jqxGrid('updatebounddata');
                      }
                    }
                  }); 
                }
              });
            }
        }}
      ];
    }
    else {
      gridColumns = [
        { text: '#', width: 70, filterable: false, sortable: false, pinned: true, cellsrenderer: numberCellRenderer },
        { text: 'Title', datafield: 'title', width: 150, pinned: true },
        { text: 'Feature', datafield: 'feature', width: 200 },
        { text: 'Feature Comment', datafield: 'feature_comment', width: 350 },
        { text: 'Request Date', datafield: 'request_datetime', width: 150, filtertype: 'range', cellsformat: 'M/dd/yyyy hh:mm:ss' },
        { text: 'Status', datafield: 'status', width: 120, filtertype: 'list', filteritems: ['request', 'accepted', 'rejected'] },
        { text: 'Admin Comment', datafield: 'admin_comment', width: 300, align: 'right', cellsalign: 'right' },
        { text: 'Admin Comment Date', datafield: 'admin_comment_datetime', width: 150, align: 'right', cellsalign: 'right', filtertype: 'range', cellsformat: 'M/dd/yyyy hh:mm:ss' }        
      ];
    }
    // initialize jqxGrid
    var grid = $("#grid").jqxGrid(
    {
        width: '100%',
        height: (isAdmin ? '100%' : 'calc(100% - 45px)'),
        rowsheight: 50,
        source: dataAdapter,                
        altrows: true,
        sortable: true,
        filterable: true,
        showfilterrow: true,
        // columnsresize: true,
        // selectionmode: 'singlerow',
        virtualmode: true,
        rendergridrows: function(obj)
        {
            return obj.data;     
        },
        columns: gridColumns,
        theme: jqxtheme
    });
    grid.on('rowdoubleclick', function(evt) {
      if(evt.args && evt.args.row && evt.args.row.bounddata) {
        var template = $($('#template-detail-view').clone().html());
        var rowdata = evt.args.row.bounddata;
        template.find('#tmp-feature-comment').val(rowdata.feature_comment);
        template.find('#tmp-admin-comment').val(rowdata.admin_comment);

        swal({
          content: template[0],
          showCancelButton: true,
          className: 'detail-view-container'
        });
      }
    });


    $('#window').jqxWindow({
        theme: jqxtheme,
        isModal: true,
        maxHeight: 700, maxWidth: 1024, minHeight: 400, minWidth: 400, height: 500, width: 800,
        autoOpen: false
    }).on('open', function() {
      $('#request-feature-form')[0].reset();
    });
    var jqxLoader = $("#jqxLoader").jqxLoader({ isModal: true, width: 100, height: 60, imagePosition: 'top', theme: jqxtheme });

    $('#request-feature-form').submit(function(event) {
      event.preventDefault();
      var formSerializeArr = $(this).serializeArray();
      var formValue = {};
      formSerializeArr.forEach(function(input) {
        formValue[input.name] = input.value.trim();
      });

      jqxLoader.jqxLoader({text: 'Requesting ...'});
      jqxLoader.jqxLoader('open');

      $.ajax({
        url: saveUrl,
        method: 'post',
        data: formValue,
        success: function(data) {
          jqxLoader.jqxLoader('close');
          if(isNaN(data) === false) {
            $('#window').jqxWindow('close');
            swal("Request Feature", "Thanks for your requesting new feature.", "success");
            grid.jqxGrid('updatebounddata');
          }
          else {
            swal("Request Feature", "This Feature was already requested. \n\nPlease request another feature.", "error");
          }
        }
      });
    });

    // admin functions

    if(isAdmin === true) {
      $('#window-admin-comment').jqxWindow({
        theme: jqxtheme,
        isModal: true,
        height: 450, width: 800,
        autoOpen: false
      });      

      $('#admin-update-feature-form').submit(function(event) {
        event.preventDefault();
        var formSerializeArr = $(this).serializeArray();
        var formValue = {};
        formSerializeArr.forEach(function(input) {
          formValue[input.name] = input.value.trim();
        });

        jqxLoader.jqxLoader({text: 'Please wait ...'});
        jqxLoader.jqxLoader('open');

        $.ajax({
          url: saveAdminUrl,
          method: 'post',
          data: formValue,
          success: function(data) {
            jqxLoader.jqxLoader('close');
            grid.jqxGrid('updatebounddata');
            swal("Update Admin Comment", "Admin comment was successfully updated", "success");
            $('#window-admin-comment').jqxWindow('close');
          }
        });
      });
    }
});



function customValidity(domInput) {
  if(!domInput || !domInput.setCustomValidity) return;
  var msg = domInput.getAttribute('validate-msg');
  var regexp = new RegExp(domInput.getAttribute('pattern'));
  if(regexp.test(domInput.value) === true) {
    domInput.setCustomValidity('');
  }
  else {
    domInput.setCustomValidity(msg);
    $(domInput).closest('form').find('input[type="submit"]').click();
  }
}