<section id="content">
    <div class="container">
        <div class="block-header">
            <h2><?php echo $page_title;?></h2>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>选择查询条件<small></small></h2>
                </div>
                <div class="card-body card-padding">
                    <div class="row">
                        <form id="search_form" method="get" action="">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <div class="fg-line">
                                        <input title="查询开始时间" type="text" name="date1" value="<?php echo $bt?>" class="form-control <?php echo isset($date_time_picker) ? 'date-time-picker' :'date-picker'?>" placeholder="查询开始时间">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                        <div class="form-group">
                            <div class="fg-line">
                            <select  id="servertype" class="form-control">
                                <option value="0">未选择</option>
                                <?php foreach($big_server_list as $k=>$v){ ?>
                                <option value="<?php echo $k;?>"><?php echo $v;?></option>
                                <?php } ?>
                            </select>
                            </div>
                        </div>
                    </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <select multiple='multiple' id="server_id_mul" data-name="server_id" class="form-control mul">
                                        <option value="0">选择区服</option>
                                        <?php foreach($server_list as $server_id=>$server_name):?>
                                            <option value="<?php echo $server_id?>"> <?php echo $server_name;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <div class="fg-line">
                            <select  name="processtype" class="form-control">
                                <option value="1">普通副本</option>
                                <option value="2">精英副本</option>
                            </select>
                            </div>
                        </div>
                    </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <div class="fg-line">
                                        <input  title="赛季" type="text" name="season" class="form-control" placeholder="赛季">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <div class="fg-line">
                                        <input  title="VIP等级" type="text" name="viplev_min" class="form-control" placeholder="VIP等级区间(最小等级)">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <div class="fg-line">
                                        <input  title="VIP等级(最大vip等级)" type="text" name="viplev_max" class="form-control" placeholder="VIP等级区间(最大等级)">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-2">
                                <button type="button" id="submit" class="btn btn-primary btn-sm m-t-10 waves-effect">查询</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="table-responsive">
                    <table id="data-table-basic" class="table table-striped">
                        <thead id="thead">
                            <tr>
                            <th>段位</th>
                            <th>段位人数</th>
                            <th>占比</th>
                            <th></th>
                            </tr>
                        </thead>
                        <tbody id="dataTable">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?=base_url()?>public/ma/js/layer.js"></script>
<script>
function showdetail(ranklev){
	layer.open({
		  type: 2,
		  title: ranklev+'段位vip详细',
		  maxmin: true,
		  shadeClose: true, //点击遮罩关闭层
		  area : ['800px' , '520px'],
		  content: '../frame/danDetail?ranklev='+ranklev
		  });
}
function userdetail(ranklev){
	layer.open({
		  type: 2,
		  title: ranklev+'段位玩家详细',
		  maxmin: true,
		  shadeClose: true, //点击遮罩关闭层
		  area : ['800px' , '520px'],
		  content: '../frame/danuserDetail?ranklev='+ranklev
		  });
}
    var dataOption = {
        autoload: false,
        request_url:'<?php echo site_url($_request_method);?>',
        callback: function (result) {
            if (result) {
                if (result.status!='ok') {
                    $("#dataTable").html('');
                    notify("客官,不好意思，没有查到数据!");
                    return false;
                }
                var table_html = '';
                for(var i=1;i<=result.maxdan;i++){
                	//if (!result['data'].hasOwnProperty(i)) continue;
                	table_html += '<tr><td>'+i+'</td><td>';
					if(!result['data'].hasOwnProperty(i)){
						table_html += '0';
						}else{
							table_html += result.data[i]['caccount'];
					}
					table_html +='</td><td>';
					if(!result['data'].hasOwnProperty(i)){
						table_html += '0';
						}else{
							table_html += result.data[i]['rare'];
					}
					table_html += '%</td>';
                	table_html += "<td><a href='javascript:showdetail("+i+")'>vip详细</a> <a href='javascript:userdetail("+i+")'>玩家详细</a></td></tr>";
                 }
                table_html += '<tr><td>总人数</td><td>'+result['allaccount']+'</td><td>100%</td><td></td>';
                $("#dataTable").html(table_html);
            }
        }
    };
</script>
<script src="<?=base_url()?>public/ma/js/common_req.js"></script>