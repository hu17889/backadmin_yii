<form method="post" action="/main/user/list">
账户:<input type="text" name="name"/>
<input type="submit" name="query" value="查询"/>
<input type="submit" name="all" value="查询所有"/>
</form>
<table id="elem_table" cellpadding="0" cellspacing="0" border="0" class="stdtable">
    <thead class="center">
    <tr>
        <th width="3%" style='text-align:left'>id</th>
        <th width="10%" style='text-align:left'>账户</th>
        <th width="10%" style='text-align:left'>邮箱</th>
        <th width="10%" style='text-align:left'>角色</th>
        <th width="5%" style='text-align:left'>操作</th>
    </tr>
    </thead>
    <tbody id="contentlist" class="center">
    </tbody>
</table>

<div ></div>
<div id="pagination" class="pagination"></div>

<script src="/js/jquery.pagination.js"></script>
<link rel="stylesheet" type="text/css" href="/css/pagination.css"/>
<script>

(function($){
    //$('form.jqtransform').jqTransform();
    //$('#form').jqTransform({imgPath:'/images/'});

    $("#addnew").on('click',function(){
        window.location.href="/main/user/edit";
    });
    $countElems = <?php echo count($entitys);?>;
    $countPerPage = 50;
    tbody = new Array();
        <?php  foreach($entitys as $e) { ?>
            <?php if(!empty($e)) {?>
            content = " <tr id='tr_<?php echo htmlspecialchars($e['uid']);?>'>"
                + "<td class='td_id'><?php echo htmlspecialchars($e['uid']);?></td>"
                + "<td class='td'><?php echo htmlspecialchars($e['uname']);?></td>"
                + "<td class='td'><?php echo htmlspecialchars($e['email']);?></td>"
                + "<td class='td'><?php echo htmlspecialchars($e['rname']);?></td>"
                + "<td class='td'><button class='modify'>修改</button></td>"
                + "</tr>";
            tbody.push(content);
            <?php } ?>
        <?php } ?>

    // 分页
    loadContents = function(page) {
        max = (page+1)*$countPerPage;
        $content = '';
        for(i=page*$countPerPage;i<max;i++) {
            if(tbody[i]==undefined) continue;
            $content += tbody[i];
        }
        $("#contentlist").html($content);
        $(".modify").on('click',function(){
            $id = $(this).parents("tr").children(".td_id").text();
            window.location.href="/main/user/edit?id="+$id;
        });
    }
    $("#pagination").pagination($countElems, {
        items_per_page:$countPerPage,
        callback:loadContents
    });
})(jQuery);
</script>
