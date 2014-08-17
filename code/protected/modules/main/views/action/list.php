
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption"><i class="fa fa-edit"></i>Routes</div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="#portlet-config" data-toggle="modal" class="config"></a>
            <a href="javascript:;" class="reload"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="table-toolbar">
            <div class="btn-group">
                <a href="/main/action/edit" id="add_new" class="btn green">
                Add New <i class="fa fa-plus"></i>
                </a>
            </div>
            <div class="btn-group pull-right">
                <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu pull-right">
                    <li><a href="#">Print</a></li>
                    <li><a href="#">Save as PDF</a></li>
                    <li><a href="#">Export to Excel</a></li>
                </ul>
            </div>
        </div>  
        <table class="table table-striped table-responsive table-hover" id="datatable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>路由名</th>
                    <th>路由信息</th>
                    <th>菜单类型</th>
                    <th>一级菜单</th>
                    <th>菜单排序值</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->



<!-- BEGIN PAGE LEVEL PLUGINS -->
<link rel="stylesheet" href="/assets/plugins/data-tables/DT_bootstrap.css" />
<script type="text/javascript" src="/assets/plugins/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="/assets/plugins/data-tables/DT_bootstrap.js"></script><!-- data table -->

<script src="assets/scripts/table-ajax.js"></script> 
<!-- END PAGE LEVEL PLUGINS -->

<script>
(function($){
    /*
    sDom
    The following options are allowed:
    'l' - Length changing
    'f' - Filtering input
    't' - The table!
    'i' - Information
    'p' - Pagination
    'r' - pRocessing
    The following syntax is expected:
    '<' and '>' - div elements
    '<"class" and '>' - div with a class
    '<"#id" and '>' - div with an ID
    */
    var oTable = $('#datatable').dataTable({
        "sDom" : "<'row'<'col-md-6 col-sm-12'l><'col-md-12 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", //default layout without horizontal scroll(remove this setting to enable horizontal scroll for the table)
        "aLengthMenu": [
            [10, 25, 50, 100, -1], // value for ajax
            [10, 25, 50, 100, "All"] // name show on page
        ], // 单页显示行数的下拉列表
        "bProcessing": true, // 打开处理中标签
        "bServerSide": true, // 打开ajax方式获取数据
        "sAjaxSource": "/main/action/listajax",
        // set the initial value
        "iDisplayLength": 10, // 单页行数的初始值
        "sPaginationType": "bootstrap",
        // oLangeuage 是各个地方的显示形式
        "oLanguage": {
            "sProcessing": '<i class="fa fa-coffee"></i>&nbsp;Please wait...',
            "sLengthMenu": "_MENU_ records",
            "oPaginate": {
                "sPrevious": "Prev",
                "sNext": "Next"
            },
            "sSearch": "Search All Columns:_INPUT_ "
        },
        // 单列处理
        "aoColumnDefs": [{
            'bSortable': false,
            'aTargets': [0]
        }],
        "aoColumns": [
          null,
          null,
          null,
          null,
          null,
          null,
          { "bSearchable": true}
        ] 
    });

    $('#datatable').delegate('a.delete','click', function (e) {
        e.preventDefault();

        if (confirm("Are you sure to delete this row ?") == false) {
            return;
        }

        var id = $(this).data("id");
        $.post(
            "/main/action/del", 
            {"id": id},
            function(data) {
                console.log(data);
            }, 
            "post"
        ); 
        
        var nRow = $(this).parents('tr')[0];
        console.log(nRow);
        oTable.fnDeleteRow(nRow);
    });


//});
})(jQuery);
</script>
