<?php
App::uses('Model', 'Model');
App::uses('CrudBase', 'Model');

/**
 * 外部DBクラス
 * @date 2018-4-5 新規作成
 * @version 1.0
 *
 */
class OuterDb extends AppModel {

    public $useTable = false;


	/// バリデーションはコントローラクラスで定義
	public $validate = null;
	
	
	/**
	 * データベース名を指定して、DB変更する。
	 * @param string $dbName DB名
	 */
	public function changeDbName($dbName,$DbConfig='default') {
	    $this->setDataSource($DbConfig);
	    $db = ConnectionManager::getDataSource($this->useDbConfig);
	    $rs = $db->reconnect(array('database' => $dbName));
	    
	    
	    return $rs;
	}

}