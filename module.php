<?php
/**
 * 个性桌面模块定义
 *
 * @author mario
 * @url http://www.we7.cc
 */
defined('IN_IA') or exit('Access Denied');

class Mario_desktop2Module extends WeModule {

    public function settingsDisplay($settings) {
        global $_W, $_GPC;
//        load()->func('tpl');
        if(checksubmit()) {
   $setdata=array(
      'bgpic' => trim($_GPC['bgpic']),
      'banner' => serialize($_GPC['banner']),
      'sysname'=>$_GPC['sysname'],
      'sharetitle'=>$_GPC['sharetitle'],
      'sharedesc'=>$_GPC['sharedesc'],
      'shareimg'=>$_GPC['shareimg'],
      'mtemplate'=>$_GPC['mtemplate'],

   );

            if ($this->saveSettings($setdata)) {
//                message(trim($_GPC['bgpic']), 'refresh');
                message('保存成功', 'refresh');
            }
        }

        include $this->template('setting');
    }

}