<?php
App::uses('Model', 'Model');
App::uses('CrudBase', 'Model');

/**
 * タイプAのモデルクラス
 *
 * タイプA画面用のDB関連メソッドを定義しています。
 * タイプAテーブルと関連付けられています。
 *
 * @date 2015-9-16	新規作成
 * @author k-uehara
 *
 */
class TypeA extends AppModel {


	/// タイプAテーブルを関連付け
	public $name='TypeA';


	/// バリデーションはコントローラクラスで定義
	public $validate = null;
	
	/**
	 * タイプAエンティティを取得
	 *
	 * タイプAテーブルからidに紐づくエンティティを取得します。
	 *
	 * @param int $id タイプAID
	 * @return array タイプAエンティティ
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
			$ent=$data['TypeA'];
		}
		



		return $ent;
	}

	/**
	 * タイプA画面の一覧に表示するデータを、タイプAテーブルから取得します。
	 * 
	 * @note
	 * 検索条件、ページ番号、表示件数、ソート情報からDB（タイプAテーブル）を検索し、
	 * 一覧に表示するデータを取得します。
	 * 
	 * @param array $kjs 検索条件情報
	 * @param int $page_no ページ番号
	 * @param int $row_limit 表示件数
	 * @param string sort ソートフィールド
	 * @param int sort_desc ソートタイプ 0:昇順 , 1:降順
	 * @return array タイプA画面一覧のデータ
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
		
		$option['table']=$dbo->fullTableName($this->TypeA);
		$option['alias']='TypeA';
		
		$query = $dbo->buildStatement($option,$this->TypeA);
		
		Debugger::dump($query);
	}



	/**
	 * 検索条件情報からWHERE情報を作成。
	 * @param array $kjs	検索条件情報
	 * @return string WHERE情報
	 */
	private function createKjConditions($kjs){

		$cnds=null;
		
		// --- Start kjConditions
		
		if(!empty($kjs['kj_id'])){
			$cnds[]="TypeA.id = {$kjs['kj_id']}";
		}
		
		if(!empty($kjs['kj_type_a_name'])){
		    $cnds[]="TypeA.type_a_name LIKE '%{$kjs['kj_type_a_name']}%'";
		}
		if(!empty($kjs['kj_cnd_field_name'])){
		    $cnds[]="TypeA.cnd_field_name LIKE '%{$kjs['kj_cnd_field_name']}%'";
		}
		if(!empty($kjs['kj_cnd_field_type'])){
		    $cnds[]="TypeA.cnd_field_type LIKE '%{$kjs['kj_cnd_field_type']}%'";
		}

		if(!empty($kjs['kj_cnd_type_long1'])){
		    $cnds[]="TypeA.cnd_type_long1 >= {$kjs['kj_cnd_type_long1']}";
		}
		if(!empty($kjs['kj_cnd_type_long2'])){
		    $cnds[]="TypeA.cnd_type_long2 <= {$kjs['kj_cnd_type_long2']}";
		}
		
		$kj_cnd_null_flg = $kjs['kj_cnd_null_flg'];
		if(!empty($kjs['kj_cnd_null_flg']) || $kjs['kj_cnd_null_flg'] ==='0' || $kjs['kj_cnd_null_flg'] ===0){
		    if($kjs['kj_cnd_null_flg'] != -1){
		        $cnds[]="TypeA.cnd_null_flg = {$kjs['kj_cnd_null_flg']}";
		    }
		}
		
		$kj_cnd_p_key_flg = $kjs['kj_cnd_p_key_flg'];
		if(!empty($kjs['kj_cnd_p_key_flg']) || $kjs['kj_cnd_p_key_flg'] ==='0' || $kjs['kj_cnd_p_key_flg'] ===0){
		    if($kjs['kj_cnd_p_key_flg'] != -1){
		        $cnds[]="TypeA.cnd_p_key_flg = {$kjs['kj_cnd_p_key_flg']}";
		    }
		}
		
		if(!empty($kjs['kj_cnd_def_val'])){
		    $cnds[]="TypeA.cnd_def_val LIKE '%{$kjs['kj_cnd_def_val']}%'";
		}
		if(!empty($kjs['kj_cnd_extra'])){
		    $cnds[]="TypeA.cnd_extra LIKE '%{$kjs['kj_cnd_extra']}%'";
		}
		if(!empty($kjs['kj_cnd_comment'])){
		    $cnds[]="TypeA.cnd_comment LIKE '%{$kjs['kj_cnd_comment']}%'";
		}
		
		if(!empty($kjs['kj_sort_no']) || $kjs['kj_sort_no'] ==='0' || $kjs['kj_sort_no'] ===0){
			$cnds[]="TypeA.sort_no = {$kjs['kj_sort_no']}";
		}
		
		$kj_delete_flg = $kjs['kj_delete_flg'];
		if(!empty($kjs['kj_delete_flg']) || $kjs['kj_delete_flg'] ==='0' || $kjs['kj_delete_flg'] ===0){
			if($kjs['kj_delete_flg'] != -1){
			   $cnds[]="TypeA.delete_flg = {$kjs['kj_delete_flg']}";
			}
		}

		if(!empty($kjs['kj_update_user'])){
			$cnds[]="TypeA.update_user = '{$kjs['kj_update_user']}'";
		}

		if(!empty($kjs['kj_ip_addr'])){
			$cnds[]="TypeA.ip_addr = '{$kjs['kj_ip_addr']}'";
		}
		
		if(!empty($kjs['kj_user_agent'])){
			$cnds[]="TypeA.user_agent LIKE '%{$kjs['kj_user_agent']}%'";
		}

		if(!empty($kjs['kj_created'])){
			$kj_created=$kjs['kj_created'].' 00:00:00';
			$cnds[]="TypeA.created >= '{$kj_created}'";
		}
		
		if(!empty($kjs['kj_modified'])){
			$kj_modified=$kjs['kj_modified'].' 00:00:00';
			$cnds[]="TypeA.modified >= '{$kj_modified}'";
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
	 * タイプAエンティティをタイプAテーブルに保存します。
	 *
	 * @param array $ent タイプAエンティティ
	 * @return array タイプAエンティティ（saveメソッドのレスポンス）
	 */
	public function saveEntity($ent){

		//DBに登録('atomic' => false　トランザクションなし）
		$ent = $this->save($ent, array('atomic' => false,'validate'=>false));

		//DBからエンティティを取得
		$ent = $this->find('first',
				array(
						'conditions' => "id={$ent['TypeA']['id']}"
				));

		$ent=$ent['TypeA'];
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
	

}