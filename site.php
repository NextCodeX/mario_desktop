<?php
/**
 * 个性桌面模块微站定义
 *
 * @author mario
 * @url http://www.we7.cc
 */
defined('IN_IA') or exit('Access Denied');

class Mario_desktopModuleSite extends WeModuleSite {

	public function doMobileIndex() {
		//这个操作被定义用来呈现 功能封面
        global $_W, $_GPC;
//        load()->func('tpl');
        $settings=$this->module['config'];
        $canshare     = 1;
        $sharetitle   = $settings['sharetitle'];
        $sharedesc    = $settings['sharedesc'];
        $shareimgurl  = tomedia($settings['shareimg']);
        $shareurl     = $_W['siteroot'].'app/'.$this->createMobileUrl('index');
//        $wlist[] = array(['name'=>'module1'],['name'=>'module2'],['name'=>'index']);
        if($settings['mtemplate']=='module1'||$settings['mtemplate']=='module2'){
            $classlist = pdo_fetchall("select * from " . tablename("mario_desktop_classify") . " where uniacid='{$_W['uniacid']}' and status=1 ", array());
            $list = pdo_fetchall("select * from " . tablename("mario_desktop_applist") . " where uniacid='{$_W['uniacid']}'  and status=1 ", array());
        }else{
            $list = pdo_fetchall("select * from " . tablename("mario_desktop_applist") . " where uniacid='{$_W['uniacid']}' and type=1 and status=1 ", array());
            $list2 = pdo_fetchall("select * from " . tablename("mario_desktop_applist") . " where uniacid='{$_W['uniacid']}' and type=2 and status=1", array());
        }


        include $this -> template ($settings['mtemplate']);
	}

    public function doWebSetapp() {
        global $_W, $_GPC;
        $do = 'setapp';
        $indexurl = $_W['siteroot'].'app/'.$this->createMobileUrl('index');
        if ('delete' == $_GPC['op'] && $_GPC['id']) {

            pdo_delete('mario_desktop_applist', array('id' => $_GPC['id']));

            message ('删除应用成功！', $this -> createWebUrl ($do ));

        }

        $list = pdo_fetchall("select * from " . tablename("mario_desktop_applist") . " where uniacid='{$_W['uniacid']}' ", array());
        include $this -> template ('setapp');
    }

    public function doWebClassify(){
        global $_W, $_GPC;
        $do = 'classify';
        $list = pdo_fetchall("select * from " . tablename("mario_desktop_classify") . " where uniacid='{$_W['uniacid']}' ", array());
        include $this ->template('classify');
    }
    public function doWebAddClass(){
        global $_W, $_GPC;
        $do = 'addclass';
        if(!empty($_GPC['id'])){
            $item = pdo_fetch("select * from " . tablename("mario_desktop_classify") . " where uniacid='{$_W['uniacid']}' and id='{$_GPC['id']}' ");
        }
        if (checksubmit ()) {
            $data = array(
                'uniacid' => $_W['uniacid'],
                'indexno' => $_GPC['indexno'],
                'title' => $_GPC['title'],
                'desc' => $_GPC['desc'],
                'img' => $_GPC['img'],
                'url' => $_GPC['url'],
                'status' => 1,
                'type' => $_GPC['type'],

            );
            if(empty($_GPC['id'])){
                $sss=pdo_insert('mario_desktop_classify', $data);
            }else{
                $sss=pdo_update('mario_desktop_classify', $data,array('id'=>$_GPC['id']));
            }

            message('更新菜单成功！'.$sss, $this->createWebUrl('setapp'));
        }
        include $this ->template('addclass');

    }
    public function doWebAddapp(){
        global $_W, $_GPC;
        $do = 'addapp';
        $classlist = pdo_fetchall("select * from " . tablename("mario_desktop_classify") . " where uniacid='{$_W['uniacid']}' ", array());
        if(empty($classlist)){
            message('请先添加分类', $this->createWebUrl('addclass'));
        }
        if(!empty($_GPC['id'])){
            $item = pdo_fetch("select * from " . tablename("mario_desktop_applist") . " where uniacid='{$_W['uniacid']}' and id='{$_GPC['id']}' ");
        }
        if (checksubmit ()) {

            $data = array(
                'uniacid' => $_W['uniacid'],
                'indexno' => $_GPC['indexno'],
                'title' => $_GPC['title'],
                'desc' => $_GPC['desc'],
                'classid' => $_GPC['classid'],
                'img' => $_GPC['img'],
                'url' => $_GPC['url'],
                'status' => 1,
                'type' => $_GPC['type'],

            );
            if(empty($_GPC['id'])){
                $sss=pdo_insert('mario_desktop_applist', $data);
            }else{
                $sss=pdo_update('mario_desktop_applist', $data,array('id'=>$_GPC['id']));
            }

            message('更新菜单成功！'.$sss, $this->createWebUrl('setapp'));
        }
        include $this -> template ('addapp');
    }

}