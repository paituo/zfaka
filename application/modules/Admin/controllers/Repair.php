<?php

/*
 * 功能：后台中心－数据修复
 * Author:97id
 * Date:20200314
 */

class RepairController extends AdminBasicController
{
    private $m_products_card;
    private $m_config;
	public function init()
    {
        parent::init();
        $this->m_config = $this->load('config');
        $this->m_products_card = $this->load('products_card');
    }

    public function indexAction()
    {
        if ($this->AdminUser==FALSE AND empty($this->AdminUser)) {
            $this->redirect('/'.ADMIN_DIR."/login");
            return FALSE;
        }

		$data = array();
		$this->getView()->assign($data);
    }
    
    public function repairajaxAction()
    {
        if ($this->AdminUser==FALSE AND empty($this->AdminUser)) {
            $data = array('code' => 1000, 'msg' => '请登录');
            Helper::response($data);
        }
        $method = $this->getPost('method',false);
        $csrf_token = $this->getPost('csrf_token', false);
        
        $data = array();
        
        if($method AND $csrf_token){
            if ($this->VerifyCsrfToken($csrf_token)) {
                $field = array('id','name','updatetime','tag');
                $items = $this->m_config->Field($field)->Order(array('id'=>'DESC'))->Select();
                if (empty($items)) {
                    $data = array('code' => 1004, 'msg' => '无数据，不需要修复');
                } else {
                    foreach($items AS $item){
                        $tag = getRawText($item['tag'],false);
                        $m = array('tag'=>htmlspecialchars($tag));
                        $this->m_config->UpdateByID($m,$item['id']);
                        unset($tag,$m);
                    }
                    $data = array('code' => 1, 'msg' => '修复完成');
                }
            } else {
                $data = array('code' => 1001, 'msg' => '页面超时，请刷新页面后重试!');
            }
        }else{
            $data = array('code' => 1000, 'msg' => '丢失参数');
        }
        Helper::response($data);
    }
    
    public function repaircardajaxAction()
    {
        if ($this->AdminUser==FALSE AND empty($this->AdminUser)) {
            $data = array('code' => 1000, 'msg' => '请登录');
            Helper::response($data);
        }
        $method = $this->getPost('method',false);
        $csrf_token = $this->getPost('csrf_token', false);
        
        $data = array();
        
        if($method AND $csrf_token){
            if ($this->VerifyCsrfToken($csrf_token)) {
                $field = array('id','card');
                $items = $this->m_products_card->Field($field)->Order(array('id'=>'DESC'))->Select();
                if (empty($items)) {
                    $data = array('code' => 1004, 'msg' => '无数据，不需要修复');
                } else {
                    foreach($items AS $item){
                        $card = getRawText($item['card'],false);
                        $m = array('card'=>$card);
                        $this->m_products_card->UpdateByID($m,$item['id']);
                        unset($card,$m);
                    }
                    $data = array('code' => 1, 'msg' => '修复完成');
                }
            } else {
                $data = array('code' => 1001, 'msg' => '页面超时，请刷新页面后重试!');
            }
        }else{
            $data = array('code' => 1000, 'msg' => '丢失参数');
        }
        Helper::response($data);
    }
}