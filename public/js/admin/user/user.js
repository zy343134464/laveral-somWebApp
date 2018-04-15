$(function () {
    var table = $('#example1').DataTable({
        'paging'      : false,
        'lengthChange': true,
        'searching'   : false,
        'ordering'    : false,
        'info'        : false,
        'autoWidth'   : true
    })
    //显示隐藏列
    $('.toggle-vis').on('change', function (e) {
        e.preventDefault();
        console.log($(this).attr('data-column'));
        var column = table.column($(this).attr('data-column'));
        column.visible(!column.visible());
    });

    })

