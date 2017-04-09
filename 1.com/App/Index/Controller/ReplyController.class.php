<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/9
 * Time: 15:20
 */

namespace Index\Controller;


use Think\Controller;

class ReplyController extends Controller
{

    public function index_user(){
        $this->assign('money',I('get.money'));
        $this->display();
    }

    public function users(){
        $this->display();
    }
}