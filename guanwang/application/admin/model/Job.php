<?php
namespace app\admin\model;

use think\Model;

class Job extends Model
{
    public function getBeginTimeTurnAttr($value, $data)
    {
        return date('Y-m-d', $data['begin_time']);
    }
}