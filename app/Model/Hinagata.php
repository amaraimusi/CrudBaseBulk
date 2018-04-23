<?php
App::uses('Model', 'Model');
App::uses('CrudBase', 'Model');

/**
 * フィールド雛型のモデルクラス
 *
 * フィールド雛型画面用のDB関連メソッドを定義しています。
 * フィールド雛型テーブルと関連付けられています。
 *
 * @date 2015-9-16	新規作成
 * @author k-uehara
 *
 */
class Hinagata extends AppModel {


	/// フィールド雛型テーブルを関連付け
	public $name='Hinagata';


	/// バリデーションはコントローラクラスで定義
	public $validate = null;
	
	
	public function __construct() {
		parent::__construct();
		
		// CrudBaseロジッククラスの生成
		if(empty($this->CrudBase)) $this->CrudBase = new CrudBase();
	}
	
	/**
	 * フィールド雛型エンティティを取得
	 *
	 * フィールド雛型テーブルからidに紐づくエンティティを取得します。
	 *
	 * @param int $id フィールド雛型ID
	 * @return array フィールド雛型エンティティ
	 */
	public function findEntity($id){

		$conditions='id = '.$id;

		//DBからデータを取得
		$data = $this->find(
				'first',
				Array(
						'conditions' => $conditions,
				)
		);

		$ent=array();
		if(!empty($data)){
			$ent=$data['Hinagata'];
		}
		



		return $ent;
	}

	/**
	 * フィールド雛型画面の一覧に表示するデータを、フィールド雛型テーブルから取得します。
	 * 
	 * @note
	 * 検索条件、ページ番号、表示件数、ソート情報からDB（フィールド雛型テーブル）を検索し、
	 * 一覧に表示するデータを取得します。
	 * 
	 * @param array $kjs 検索条件情報
	 * @param int $page_no ページ番号
	 * @param int $row_limit 表示件数
	 * @param string sort ソートフィールド
	 * @param int sort_desc ソートタイプ 0:昇順 , 1:降順
	 * @return array フィールド雛型画面一覧のデータ
	 */
	public function findData($kjs,$page_no,$row_limit,$sort_field,$sort_desc){

		//条件を作成
		$conditions=$this->createKjConditions($kjs);
		
		// オフセットの組み立て
		$offset=null;
		if(!empty($row_limit)) $offset = $page_no * $row_limit;
		
		// ORDER文の組み立て
		$order = $sort_field;
		if(empty($order)) $order='sort_no';
		if(!empty($sort_desc)) $order .= ' DESC';
		
		$option=array(
            'conditions' => $conditions,
            'limit' =>$row_limit,
            'offset'=>$offset,
            'order' => $order,
        );
		
		//DBからデータを取得
		$data = $this->find('all',$option);

		//データ構造を変換（2次元配列化）
		$data2=array();
		foreach($data as $i=>$tbl){
			foreach($tbl as $ent){
				foreach($ent as $key => $v){
					$data2[$i][$key]=$v;
				}
			}
		}
		
		return $data2;
	}
	
	
	/**
	 * 一覧データを取得する
	 */
	public function findData2(&$crudBaseData){

		$kjs = $crudBaseData['kjs'];//検索条件情報
		$pages = $crudBaseData['pages'];//ページネーション情報

		$data = $this->findData($kjs,$pages['page_no'],$pages['row_limit'],$pages['sort_field'],$pages['sort_desc']);
		
		return $data;
	}

	
	
	/**
	 * SQLのダンプ
	 * @param  $option
	 */
	private function dumpSql($option){
		$dbo = $this->getDataSource();
		
		$option['table']=$dbo->fullTableName($this->Hinagata);
		$option['alias']='Hinagata';
		
		$query = $dbo->buildStatement($option,$this->Hinagata);
		
		Debugger::dump($query);
	}



	/**
	 * 検索条件情報からWHERE情報を作成。
	 * @param array $kjs	検索条件情報
	 * @return string WHERE情報
	 */
	private function createKjConditions($kjs){

		$cnds=null;
		
		$this->CrudBase->sql_sanitize($kjs); // SQLサニタイズ
		
		// --- Start kjConditions
		
		if(!empty($kjs['kj_id'])){
			$cnds[]="Hinagata.id = {$kjs['kj_id']}";
		}
		
		if(!empty($kjs['kj_hina_code'])){
			$cnds[]="Hinagata.hina_code LIKE '%{$kjs['kj_hina_code']}%'";
		}
		
		if(!empty($kjs['kj_type_a'])){
			$cnds[]="Hinagata.type_a = {$kjs['kj_type_a']}";
		}

		if(!empty($kjs['kj_hinagata'])){
			$cnds[]="Hinagata.hinagata LIKE '%{$kjs['kj_hinagata']}%'";
		}
		
		if(!empty($kjs['kj_sort_no']) || $kjs['kj_sort_no'] ==='0' || $kjs['kj_sort_no'] ===0){
			$cnds[]="Hinagata.sort_no = {$kjs['kj_sort_no']}";
		}
		
		$kj_delete_flg = $kjs['kj_delete_flg'];
		if(!empty($kjs['kj_delete_flg']) || $kjs['kj_delete_flg'] ==='0' || $kjs['kj_delete_flg'] ===0){
			if($kjs['kj_delete_flg'] != -1){
			   $cnds[]="Hinagata.delete_flg = {$kjs['kj_delete_flg']}";
			}
		}

		if(!empty($kjs['kj_update_user'])){
			$cnds[]="Hinagata.update_user = '{$kjs['kj_update_user']}'";
		}

		if(!empty($kjs['kj_ip_addr'])){
			$cnds[]="Hinagata.ip_addr = '{$kjs['kj_ip_addr']}'";
		}
		
		if(!empty($kjs['kj_user_agent'])){
			$cnds[]="Hinagata.user_agent LIKE '%{$kjs['kj_user_agent']}%'";
		}

		if(!empty($kjs['kj_created'])){
			$kj_created=$kjs['kj_created'].' 00:00:00';
			$cnds[]="Hinagata.created >= '{$kj_created}'";
		}
		
		if(!empty($kjs['kj_modified'])){
			$kj_modified=$kjs['kj_modified'].' 00:00:00';
			$cnds[]="Hinagata.modified >= '{$kj_modified}'";
		}
		
		// --- End kjConditions
		
		$cnd=null;
		if(!empty($cnds)){
			$cnd=implode(' AND ',$cnds);
		}

		return $cnd;

	}

	/**
	 * エンティティをDB保存
	 *
	 * フィールド雛型エンティティをフィールド雛型テーブルに保存します。
	 *
	 * @param array $ent フィールド雛型エンティティ
	 * @param array $option オプション
	 * @return array フィールド雛型エンティティ（saveメソッドのレスポンス）
	 */
	public function saveEntity($ent,$option=array()){
		
		
		// 新規入力であるなら新しい順番をエンティティにセットする。
		if(empty($ent['id'])){
			if(empty($this->CrudBase)) $this->CrudBase = new CrudBase();
			if(empty($option['ni_tr_place'])){
				$ent['sort_no'] = $this->CrudBase->getLastSortNo($this); // 末尾順番を取得する
			}else{
				$ent['sort_no'] = $this->CrudBase->getFirstSortNo($this); // 先頭順番を取得する
			}
			
		}

		//DBに登録('atomic' => false　トランザクションなし）
		$ent = $this->save($ent, array('atomic' => false,'validate'=>false));

		//DBからエンティティを取得
		$ent = $this->find('first',
				array(
						'conditions' => "id={$ent['Hinagata']['id']}"
				));

		$ent=$ent['Hinagata'];
		if(empty($ent['delete_flg'])) $ent['delete_flg'] = 0;

		return $ent;
	}




	/**
	 * 全データ件数を取得
	 *
	 * limitによる制限をとりはらった、検索条件に紐づく件数を取得します。
	 *  全データ件数はページネーション生成のために使われています。
	 *
	 * @param array $kjs 検索条件情報
	 * @return int 全データ件数
	 */
	public function findDataCnt($kjs){

		//DBから取得するフィールド
		$fields=array('COUNT(id) AS cnt');
		$conditions=$this->createKjConditions($kjs);

		//DBからデータを取得
		$data = $this->find(
				'first',
				Array(
						'fields'=>$fields,
						'conditions' => $conditions,
				)
		);

		$cnt=$data[0]['cnt'];
		return $cnt;
	}
	
	
	/**
	 * タイプAリストとJSONを取得する
	 * @return array タイプAリスト
	 */
	public function getTypeAList(){
		
		if(empty($this->TypeA)){
			App::uses('TypeA','Model');
			$this->TypeA=ClassRegistry::init('TypeA');
		}
		
		return $this->TypeA->getTypeAList();
		
	}
	


}