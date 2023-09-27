<?php
App::uses('AppController', 'Controller');

/**
 * 管理者トップ
 * ☆履歴
 * 2014/08/21 新規作成
 * @author k-uehara
 *
 */
class PagesController extends AppController {
	public $name = 'Pages';
	public $uses = false;
	public $components=null;//ログイン認証不要
	public $logout_flg=false;//ログアウトリンクを非表示

	public function beforeFilter() {
		
		if($_SERVER['SERVER_NAME']!='localhost'){
			echo 'This system localhost only!';
			die();
		}
		
		// 未ログイン中である場合、未認証モードの扱いでページ表示する。
		if(empty($this->Auth->user())){
			$this->Auth->allow(); // 未認証モードとしてページ表示を許可する。
		}
		
		parent::beforeFilter();
		
		$this->initCrudBase();// フィールド関連の定義をする。
		
	}
	
    public function index() {



//     	$date_option = array(
//     			'minYear' => 1930,
//     			'maxYear' => date('Y'),
//     			'separator' => array('年','月','日'),
//     			'value' => array('year' => date('Y'),'month' => date('m'),'day' => date('d')),
//     			'monthNames' => false
//     	);
//     	$this->set(array(
//     			'date_option'=> $date_option,
//     	));
    }


}