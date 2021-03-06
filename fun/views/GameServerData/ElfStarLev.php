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
                                        <input  title="查询结束时间" type="text" name="date2" value="<?php echo $et?>" class="form-control <?php echo isset($date_time_picker) ? 'date-time-picker' :'date-picker'?>" placeholder="查询结束时间">
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
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <select multiple='multiple' id="channel_id_mul" data-name="channel_id" class="mul">
                                        <option value="0">选择渠道</option>
                                        <?php foreach($channel_list as $channel_id=>$channel_name):?>
                                            <option value="<?php echo $channel_id?>"> <?php echo $channel_name;?></option>
                                        <?php endforeach;?>
                                    </select>
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
                                <th>VIP等级</th>
                                <th>玩家平均等级</th>
                                <th>第一高星精灵</th>
                                <th>第二高星精灵</th>
                                <th>第三高星精灵</th>
                                <th>第四高星精灵</th>
                                <th>第五高星精灵</th>
                                <th>第六高星精灵</th>
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
<!--<script>-->
<!--    $("#submit").attr('type', 'submit');-->
<!--</script>-->
<script>
    var dataOption = {
        autoload: true,
        request_url:'<?php echo site_url($_request_method);?>',
        callback: function (result) {
            if (result) {
                if (result.status!='ok') {
                    $("#dataTable").html('');
                    notify("客官,不好意思，没有查到数据!");
                    return false;
                }
                var table_html = '';
                for (var viplev in result['data']) {
                    if (!result['data'].hasOwnProperty(viplev)) continue;
                    table_html += '<tr>' +
                        '<td>'+viplev+'</td>'+
                        '<td>'+result['data'][viplev][9999]+'</td>'+
                        '<td>'+(result['data'][viplev].hasOwnProperty(1) ? result['data'][viplev][1] : 0)+'</td>'+
                        '<td>'+(result['data'][viplev].hasOwnProperty(2) ? result['data'][viplev][2] : 0)+'</td>'+
                        '<td>'+(result['data'][viplev].hasOwnProperty(3) ? result['data'][viplev][3] : 0)+'</td>'+
                        '<td>'+(result['data'][viplev].hasOwnProperty(4) ? result['data'][viplev][4] : 0)+'</td>'+
                        '<td>'+(result['data'][viplev].hasOwnProperty(5) ? result['data'][viplev][5] : 0)+'</td>'+
                        '<td>'+(result['data'][viplev].hasOwnProperty(6) ? result['data'][viplev][6] : 0)+'</td>'+
                        '</tr>';
                }
                $("#dataTable").html(table_html);
            }
        }
    };
</script>
<script src="<?=base_url()?>public/ma/js/common_req.js"></script>
