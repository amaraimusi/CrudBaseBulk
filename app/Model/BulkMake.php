<?php
App::uses('Model', 'Model');
App::uses('CrudBase', 'Model');

/**
 * 一括作成のモデルクラス
 *
 * 一括作成画面用のDB関連メソッドを定義しています。
 * 一括作成テーブルと関連付けられています。
 *
 * @date 2015-9-16	新規作成
 * @author k-uehara
 *
 */
class BulkMake extends AppModel {

    
	/// 一括作成テーブルを関連付け
	public $name='BulkMake';


	/// バリデーションはコントローラクラスで定義
	public $validate = null;
	
	// 雛型データのキャッシュ
	private $hinaDataCash;
	
	
	public function __construct() {
		parent::__construct();
		
		// CrudBaseロジッククラスの生成
		if(empty($this->CrudBase)) $this->CrudBase = new CrudBase();
	}
	
	
	/**
	 * 一括作成エンティティを取得
	 *
	 * 一括作成テーブルからidに紐づくエンティティを取得します。
	 *
	 * @param int $id 一括作成ID
	 * @return array 一括作成エンティティ
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
			$ent=$data['BulkMake'];
		}

		return $ent;
	}

	/**
	 * 一括作成画面の一覧に表示するデータを、一括作成テーブルから取得します。
	 * 
	 * @note
	 * 検索条件、ページ番号、表示件数、ソート情報からDB（一括作成テーブル）を検索し、
	 * 一覧に表示するデータを取得します。
	 * 
	 * @param array $kjs 検索条件情報
	 * @param int $page_no ページ番号
	 * @param int $row_limit 表示件数
	 * @param string sort ソートフィールド
	 * @param int sort_desc ソートタイプ 0:昇順 , 1:降順
	 * @return array 一括作成画面一覧のデータ
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
		
		$option['table']=$dbo->fullTableName($this->BulkMake);
		$option['alias']='BulkMake';
		
		$query = $dbo->buildStatement($option,$this->BulkMake);
		
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
			$cnds[]="BulkMake.id = {$kjs['kj_id']}";
		}
		
		if(!empty($kjs['kj_mission_id'])){
		    $cnds[]="BulkMake.mission_id = '{$kjs['kj_mission_id']}'";
		}
		if(!empty($kjs['kj_field_name'])){
		    $cnds[]="BulkMake.field_name = '{$kjs['kj_field_name']}'";
		}
		if(!empty($kjs['kj_type_a'])){
		    $cnds[]="BulkMake.type_a = '{$kjs['kj_type_a']}'";
		}
		if(!empty($kjs['kj_field_type'])){
		    $cnds[]="BulkMake.field_type = '{$kjs['kj_field_type']}'";
		}
		if(!empty($kjs['kj_orig_type'])){
		    $cnds[]="BulkMake.orig_type = '{$kjs['kj_orig_type']}'";
		}
		if(!empty($kjs['kj_type_long']) || $kjs['kj_type_long'] ==='0' || $kjs['kj_type_long'] ===0){
		    $cnds[]="BulkMake.type_long = {$kjs['kj_type_long']}";
		}
		if(!empty($kjs['kj_null_flg']) || $kjs['kj_null_flg'] ==='0' || $kjs['kj_null_flg'] ===0){
		    $cnds[]="BulkMake.null_flg = {$kjs['kj_null_flg']}";
		}
		if(!empty($kjs['kj_p_key_flg']) || $kjs['kj_p_key_flg'] ==='0' || $kjs['kj_p_key_flg'] ===0){
		    $cnds[]="BulkMake.p_key_flg = {$kjs['kj_p_key_flg']}";
		}
		if(!empty($kjs['kj_def_val'])){
		    $cnds[]="BulkMake.def_val LIKE '%{$kjs['kj_def_val']}%'";
		}
		if(!empty($kjs['kj_extra'])){
		    $cnds[]="BulkMake.extra LIKE '%{$kjs['kj_extra']}%'";
		}
		if(!empty($kjs['kj_comment'])){
		    $cnds[]="BulkMake.comment LIKE '%{$kjs['kj_comment']}%'";
		}
		
		if(!empty($kjs['kj_sort_no']) || $kjs['kj_sort_no'] ==='0' || $kjs['kj_sort_no'] ===0){
			$cnds[]="BulkMake.sort_no = {$kjs['kj_sort_no']}";
		}
		
		$kj_delete_flg = $kjs['kj_delete_flg'];
		if(!empty($kjs['kj_delete_flg']) || $kjs['kj_delete_flg'] ==='0' || $kjs['kj_delete_flg'] ===0){
			if($kjs['kj_delete_flg'] != -1){
			   $cnds[]="BulkMake.delete_flg = {$kjs['kj_delete_flg']}";
			}
		}

		if(!empty($kjs['kj_update_user'])){
			$cnds[]="BulkMake.update_user = '{$kjs['kj_update_user']}'";
		}

		if(!empty($kjs['kj_ip_addr'])){
			$cnds[]="BulkMake.ip_addr = '{$kjs['kj_ip_addr']}'";
		}
		
		if(!empty($kjs['kj_user_agent'])){
			$cnds[]="BulkMake.user_agent LIKE '%{$kjs['kj_user_agent']}%'";
		}

		if(!empty($kjs['kj_created'])){
			$kj_created=$kjs['kj_created'].' 00:00:00';
			$cnds[]="BulkMake.created >= '{$kj_created}'";
		}
		
		if(!empty($kjs['kj_modified'])){
			$kj_modified=$kjs['kj_modified'].' 00:00:00';
			$cnds[]="BulkMake.modified >= '{$kj_modified}'";
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
	 * 一括作成エンティティを一括作成テーブルに保存します。
	 *
	 * @param array $ent 一括作成エンティティ
	 * @param array $option オプション
	 * @return array 一括作成エンティティ（saveメソッドのレスポンス）
	 */
	public function saveEntity($ent,$option=array()){
		
		
		// 新規入力であるなら新しい順番をエンティティにセットする。
		if($option['form_type']=='new_inp' ){
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
						'conditions' => "id={$ent['BulkMake']['id']}"
				));

		$ent=$ent['BulkMake'];
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
	 * フィールドデータを一括作成用に変換する
	 * @param array $fieldData1 既存フィールドデータ
	 * @param array $fieldData2 複製先テーブルから取得したフィールドデータ
	 * @param int $mission_id 任務ID
	 * @param array $option
	 *  - type_a_over タイプA上書きフラグ
	 * @param array フィールドデータ
	 */
	public function convFieldDataForBulkMake($fieldData1,$fieldData2,$mission_id,$option){

		// 既存フィールドデータをフィールドをキーとした構造に変換する
		$fieldData1 = Hash::combine($fieldData1, '{n}.field_name','{n}');
		
		// タイプA上書きフラグを取得
		$type_a_over = 0;
		if(isset($option['type_a_over'])) $type_a_over = $option['type_a_over'];
		
		$sort_no = 0;

		$fieldData = array();
		foreach($fieldData2 as $columns){
			$ent2 = $columns['COLUMNS'];
			$field_name = $ent2['Field']; // フィールド名を取得する
			
			// 既存フィールドデータのエンティティを取得する
			$ent1 = null;
			if(!empty($fieldData1[$field_name])) $ent1 = $fieldData1[$field_name];
			
			// 既存フィールドデータのエンティティからIDや任務IDなどを取得する
			$id = null;
			$mission_id = $mission_id;
			$type_a = null;
			if(!empty($ent1)){
				$id = $ent1['id'];
				$mission_id = $ent1['mission_id'];
				$type_a = $ent1['type_a'];
			}
			

			
			// フィールド型関連のパラメータを取得する
			$orig_type = $ent2['Type'];
			$field_type = $this->stringLeft($orig_type,'(');
			$type_long = $this->getHasami($orig_type,'(',')');
			
			// NULLフラグの取得
			$null_flg = 0;
			if($ent2['Null'] == 'YES'){
				$null_flg = 0;
			}elseif($ent2['Null'] == 'NO'){
				$null_flg = 1;
			}
			
			// 主キーフラグ
			$p_key_flg = 0;
			if($ent2['Key'] == 'PRI') $p_key_flg = 1;
			
			// コメント
			$comment = $ent2['Comment'];
			if(empty($comment)) $comment = $field_name;
			
			// 順番
			$sort_no ++;
			
			$ent = array();
			$ent['id'] = $id;
			$ent['mission_id'] = $mission_id;
			$ent['field_name'] = $field_name;
			$ent['type_a'] = $type_a;
			$ent['field_type'] = $field_type;
			$ent['orig_type'] = $orig_type;
			$ent['type_long'] = $type_long;
			$ent['null_flg'] = $null_flg;
			$ent['p_key_flg'] = $p_key_flg;
			$ent['def_val'] = $ent2['Default'];
			$ent['extra'] = $ent2['Extra'];
			$ent['comment'] = $comment;
			$ent['sort_no'] = $sort_no;
			
			$fieldData[] = $ent;
		}
		
		
		// タイプA上書フラグがONであるなら、タイプAの予測判定処理を行う。
		if(!empty($option['type_a_over'])){

			// タイプAを予測する
			$fieldData = $this->predictionTypeA($fieldData);
		}

		return $fieldData;
		
	}
	
	/**
	 * タイプAを予測する
	 * @param array $fieldData フィールドデータ
	 * @return array 予測したタイプAをセットしたフィールドデータ
	 */
	public function predictionTypeA($fieldData){

		$typeAData = $this->getTypeAData(); // タイプAデータを取得する
		
		foreach($fieldData as &$fEnt){
			$fEnt['type_a'] = $this->getPredTypeA($fEnt,$typeAData); // 予測タイプAを取得する
		}
		unset($fEnt);

		return  $fieldData;
	}
	
	/**
	 * タイプAデータを取得する
	 * @return array タイプAデータ
	 */
	private function getTypeAData(){
		
		if(empty($this->TypeA)){
			App::uses('TypeA','Model');
			$this->TypeA=ClassRegistry::init('TypeA');
		}
		
		//WHERE情報
		$conditions=array(
				"delete_flg = 0",
		);
		
		//ORDER情報
		$order=array('sort_no DESC');
		
		//オプション
		$option=array(
				'conditions'=>$conditions,
				'order'=>$order,
		);
		
		//DBから取得
		$data=$this->TypeA->find('all',$option);
		
		//2次元配列に構造変換する。
		if(!empty($data)) $data=Hash::extract($data, '{n}.TypeA');
		
		// 条件系のフィールド値を分解して、条件配列を作成する。
		$cndFields = array(
				'cnd_eq_field_name',
				'cnd_in_field_name',
				'cnd_eq_field_type',
				'cnd_in_field_type',
				'cnd_eq_def_val',
				'cnd_in_def_val',
				'cnd_eq_extra',
				'cnd_in_extra',
				'cnd_eq_comment',
				'cnd_in_comment',
		);
		foreach($data as &$ent){
			foreach($cndFields as $cnd_field){
				
				$cndList = array();
				if(!empty($ent[$cnd_field])){
					$value = $ent[$cnd_field];
					$cndList = explode(",",$value);
				}
				$key = $cnd_field . '_cndList';
				$ent[$key] = $cndList;
			}
		}
		unset($ent);

		return $data;
	}
	
	/**
	 * タイプAを予測取得する
	 * @param array $fEnt フィールドエンティティ
	 * @param array $typeAData タイプAデータ
	 * @
	 */
	private function getPredTypeA($fEnt,&$typeAData){

		foreach($typeAData as $taEnt){

			$flg = 0;
			
			// フィールド名条件【完全一致】による判定
			if($this->judgTypeACnd($fEnt,'field_name',$taEnt,'cnd_eq_field_name')){
				$flg = 1;
			}else{
				continue;
			}
			// フィールド名条件【部分一致】による判定
			if($this->judgTypeACnd($fEnt,'field_name',$taEnt,'cnd_in_field_name')){
				$flg = 1;
			}else{
				continue;
			}
			// フィールド型条件【完全一致】による判定
			if($this->judgTypeACnd($fEnt,'field_type',$taEnt,'cnd_eq_field_type')){
				$flg = 1;
			}else{
				continue;
			}
			// フィールド型条件【部分一致】による判定
			if($this->judgTypeACnd($fEnt,'field_type',$taEnt,'cnd_in_field_type')){
				$flg = 1;
			}else{
				continue;
			}
			// デフォルト値条件【完全一致】による判定
			if($this->judgTypeACnd($fEnt,'def_val',$taEnt,'cnd_eq_def_val')){
				$flg = 1;
			}else{
				continue;
			}
			// デフォルト値条件【部分一致】による判定
			if($this->judgTypeACnd($fEnt,'def_val',$taEnt,'cnd_in_def_val')){
				$flg = 1;
			}else{
				continue;
			}
			// 補足条件【完全一致】による判定
			if($this->judgTypeACnd($fEnt,'extra',$taEnt,'cnd_eq_extra')){
				$flg = 1;
			}else{
				continue;
			}
			// 補足条件【部分一致】による判定
			if($this->judgTypeACnd($fEnt,'extra',$taEnt,'cnd_in_extra')){
				$flg = 1;
			}else{
				continue;
			}
			// コメント条件【完全一致】による判定
			if($this->judgTypeACnd($fEnt,'comment',$taEnt,'cnd_eq_comment')){
				$flg = 1;
			}else{
				continue;
			}
			// コメント条件【部分一致】による判定
			if($this->judgTypeACnd($fEnt,'comment',$taEnt,'cnd_in_comment')){
				$flg = 1;
			}else{
				continue;
			}
			
			// 型長さ条件1
			if(!empty($taEnt['cnd_type_long1'])){
				if($fEnt['type_long'] >= $taEnt['cnd_type_long1']){
					continue;
				}else{
					$flg = 1;
				}
			}
			
			// 型長さ条件2
			if(!empty($taEnt['cnd_type_long2'])){
				if($fEnt['type_long'] <= $taEnt['cnd_type_long2']){
					continue;
				}else{
					$flg = 1;
				}
			}
			
			// NULLフラグ条件
			if(!empty($taEnt['cnd_null_flg']) || $taEnt['cnd_null_flg'] === 0 || $taEnt['cnd_null_flg'] === '0'){
				if($fEnt['null_flg'] = $taEnt['cnd_null_flg']){
					continue;
				}else{
					$flg = 1;
				}
			}
			
			// 主キーフラグ条件
			if(!empty($taEnt['cnd_p_key_flg']) || $taEnt['cnd_p_key_flg'] === 0 || $taEnt['cnd_p_key_flg'] === '0'){
				if($fEnt['p_key_flg'] = $taEnt['cnd_p_key_flg']){
					continue;
				}else{
					$flg = 1;
				}
			}

			if($flg) return $taEnt['id'];
			
		}
		
		return 1;
	}
	
	/**
	 * タイプA単条件判定
	 * @param array $fEnt フィールドエンティティ
	 * @param string $f_field フィールドエンティティのフィールド
	 * @param array $taEnt タイプAエンティティ
	 * @param string $ta_field タイプAエンティティのフィールド
	 * @return int 判定  0:不一致 , 1:一致
	 */
	private function judgTypeACnd($fEnt,$f_field,$taEnt,$ta_field){
		
		if(empty($taEnt[$ta_field])) return 1;
		
		// タイプAエンティティのフィールドのフィールド文字列に'cnd_eq_'が含まれているなら比較方法を完全一致(1)にする
		$diff_type = 0; // 比較方法に0(部分一致）をセットする
		if(strpos($ta_field, 'cnd_eq_') !== false) $diff_type = 1; // 完全一致をセット

		// 条件配列を取得する
		$cnd_list_key = $ta_field . '_cndList';
		$cndList = $taEnt[$cnd_list_key];
		
		// 条件配列をループし、一つでも条件に一致するなら「一致」と判定する
		foreach($cndList as $cnd){
			if($diff_type == 1){
				if($fEnt[$f_field] == $cnd){
					return 1; // 一致判定
				}
			}else{
				if(mb_strpos($fEnt[$f_field],$cnd) !== false){
					return 1;
				}
			}
		}

		return 0; // 不一致
		
	}
	
	/**
	 * 文字列を左側から印文字を検索し、左側の文字を切り出す。
	 * @param string $s 対象文字列
	 * @param string $mark 印文字
	 * @return string 印文字から左側の文字列
	 */
	private function stringLeft($s,$mark){
		
		if ($s==null || $s==""){
			return $s;
		}
		$a=strpos($s,$mark);
		if($a==null && $a!==0){
			return $s;
		}
		$s2=substr($s,0,$a);
		return $s2;
	}
	
	/**
	 * 2つの印文字に挟まれた文字を取得する
	 * @param string $targetStr 対象文字列
	 * @param string $mark1 印文字1
	 * @param string $mark2 印文字2
	 * @return string 印文字1と印文字2に挟まれた文字列
	 */
	private function getHasami($targetStr,$mark1,$mark2){
		
		$a1 = mb_strpos($targetStr,$mark1) + mb_strlen($mark1);
		$a2 = mb_strpos($targetStr,$mark2,$a1);
		
		$hasami = mb_substr($targetStr,$a1,$a2-$a1);
		
		return $hasami;
	}
	
	
	
	
	/**
	 * フィールドデータを一括作成テーブルへ保存する
	 * @param array $fieldData フィールドデータ
	 */
	public function saveFieldData($fieldData){
		
		if(empty($fieldData)) return;
		
		// 任務IDに紐づくレコードを一旦削除する。
		$mission_id = $fieldData[0]['mission_id'];// 任務IDを取得する
		$sql = "DELETE FROM bulk_makes WHERE mission_id={$mission_id}";
		$this->query($sql);
		
		// フィールドデータを一括作成テーブルへ保存する
		$rs = $this->saveAll($fieldData);
		
		return $rs;
		
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
	
	
	/**
	 * 雛ファイルIDから雛ファイルリストを取得する
	 * @param int $hina_file_id 雛ファイルID
	 * @return array 雛ファイルリスト
	 */
	public function getGHinaFiles($hina_file_id){
		if(empty($this->HinaFileList)){
			App::uses('HinaFileList','Model');
			$this->HinaFileList=ClassRegistry::init('HinaFileList');
		}
		
		//SELECT情報
		$fields=array('hina_fp');
		
		//WHERE情報
		$conditions=array(
				"hina_file_id = {$hina_file_id}",
				"delete_flg = 0",
		);
		
		//ORDER情報
		$order=array('sort_no');
		
		//オプション
		$option=array(
				'fields'=>$fields,
				'conditions'=>$conditions,
				'order'=>$order,
		);
		
		//DBから取得
		$data=$this->HinaFileList->find('all',$option);
		
		//2次元配列に構造変換する。
		if(!empty($data)){
			$data=Hash::extract($data, '{n}.HinaFileList.hina_fp');
		}
		
		return $data;
	}
	
	
	
	/**
	 * ファイルパスを雛ファイルリストとコードからファイルパスリストを取得する
	 * @param array $hinaFiles 雛ファイルリスト
	 * @param string $scr_code_c コード（キャメル記法）
	 * @param string $path パス
	 * @param string $ident 識別子   from:複製元 , to:複製先
	 * @return array ファイルパスリスト
	 */
	public function makeFilePath($hinaFiles,$scr_code_c,$path){
		
		$scr_code_s = $this->CrudBase->snakize($scr_code_c);// スネーク記法コードを作成
		$path = $this->separateAlign($path,null,0,1); //　パスのセパレータをそろえる
		$fps = array(); // ファイルパスリスト
		
		foreach($hinaFiles as $h_f){
			
			$fp = $h_f; // ファイルパスの雛型を取得
			$fp = str_replace('Xxx', $scr_code_c, $fp);// 雛ファイル名の「Xxx」部分をキャメル記法コードへ置換する
			$fp = str_replace('xxx', $scr_code_s, $fp);/// 雛ファイル名の「xxx」部分をスネーク記法コードへ置換する
			$fp = $path . $fp;
			$fp = $this->separateAlign($fp); //　パスのセパレータをそろえる
			$fps[] = $fp;
		}
		
		return $fps;
	}

	
	/**
	 * パスやURLのセパレータをそろえる
	 * @param string $path パス文字列    パスやURLなどの文字列
	 * @param string $separator セパレータ文字     未設定である場合は、自動
	 * @param int $head_sep 先頭セパレータフラグ    0(デフォ):そのまま , -1:先頭セパレータを除去 , 1:先頭セパレータを付加
	 * @param int $end_sep 末尾セパレータフラグ    0(デフォ):そのまま , -1:末尾セパレータを除去 , 1:末尾セパレータを付加
	 * @return string セパレータをそろえた文字列
	 */
	private function separateAlign($path,$separator=null,$head_sep=0,$end_sep=0){
		
		if(empty($path)) return $path;
		
		// セパレータが未設定である場合、パス文字列から自動判定する。
		if(empty($separator)){
			$a = strpos($path,'/');
			$b = strpos($path,"\\");
			if($a !==false && $b === false){
				$separator = '/';
			}elseif($a === false && $b !== false){
				$separator = "\\";
			}elseif($a === false &&  $a === false){
				$separator = DIRECTORY_SEPARATOR;
			}else{
				if($a < $b){
					$separator = '/';
				}else{
					$separator = "\\";
				}
			}
		}
		
		// セパレータをそろえる
		if($separator == '/'){
			$path = str_replace("\\", $separator, $path);
		}else{
			$path = str_replace('/', $separator, $path);
		}
		
		// 先頭セパレータフラグが1である場合、パス文字列の先頭にセパレータがなければ付加する
		if($head_sep == 1){
			$head_str = substr($path,0,1);// 先頭の一文字を取得
			if($head_str != $separator){
				$path = $separator . $path;
			}
		}
		
		// 先頭セパレータフラグが-1である場合、パス文字列の先頭にセパレータであれば除去する
		if($head_sep == -1){
			$head_str = substr($path,0,1);// 先頭の一文字を取得
			if($head_str == $separator){
				$path = substr($path,1); // 先頭の一文字を削る
			}
		}
		
		// 末尾セパレータフラグが1である場合、パス文字列の末尾にセパレータがなければ付加する
		if($end_sep == 1){
			$end_str = substr($path,-1); // 末尾の一文字を取得
			if($end_str != $separator){
				$path = $path . $separator;
			}
		}
		
		// 末尾セパレータフラグが-1である場合、パス文字列の末尾にセパレータであれば除去する
		if($end_sep == -1){
			$end_str = substr($path,-1); // 末尾の一文字を取得
			if($end_str == $separator){
				$path = substr($path,0,strlen($path) - 1);// 末尾の一文字を削る
			}
		}
		
		return $path;
		
	}
	
	
	
	/**
	 * ファイルパスリストからソースコードテキストを読み取る。
	 * @param array $fps ファイルパスリスト
	 * @return array ソースコードテキストリスト
	 */
	public function readScrText($fps){
		
		$scrTexts = array();
		foreach($fps as $fp){
			$scr_text = $this->loadSource($fp); // ソースファイルからソースコードテキストを取得する
			$scr_text = $this->alignLineFeedCodes($scr_text); // 改行コードを統一する
			$scrTexts[] = $scr_text;
		}
		
		return $scrTexts;
	}
	
	/**
	 * 改行コードを統一する
	 * @param string $str 改行コードを含む文字列
	 * @param string $code 統一する改行コード
	 * @return string 改行コードを統一した文字列
	 */
	private function alignLineFeedCodes($str,$code="\n"){
		return preg_replace("/\r\n|\r|\n/", $code, $str);
	}
	
	/**
	 * ソースファイルからソースコードテキストを取得する
	 * @param string $fn ソースファイル名
	 * @param string ソースコードテキスト
	 */
	private function loadSource($fn) {
		
		// 引数のiniファイル名が空、もしくは存在しなければ、なら、nullを返して終了
		if (! $fn) {
			return null;
		}
		
		$str = null;
		$fn=mb_convert_encoding($fn,'SJIS','UTF-8');
		if (!is_file($fn)){
			return null;
		}
		
		if ($fp = fopen ( $fn, "r" )) {
			$data = array ();
			while ( false !== ($line = fgets ( $fp )) ) {
				$str .= mb_convert_encoding ( $line, 'utf-8', 'utf-8,sjis,euc_jp,jis' );
			}
		}
		fclose ( $fp );
		
		return $str;
	}
	
	
	
	
	
	/**
	 * ソースコードのコード（キャメルとスネーク）と和名を置換する。
	 * @param array $scrTexts ソースコードテキストリスト
	 * @param array $mission 任務エンティティ
	 * @return array ソースコードテキストリスト
	 */
	public function replaceCodes(&$scrTexts,$mission){
		
		$from_scr_code_c = $mission['from_scr_code']; //　キャメル記法・複製元画面コード
		$from_scr_code_s = $this->CrudBase->snakize($from_scr_code_c); // スネーク記法・複製元画面コード
		$from_wamei = $mission['from_wamei']; // 複製元和名
		$to_scr_code_c = $mission['to_scr_code']; //　キャメル記法・複製先画面コード
		$to_scr_code_s = $this->CrudBase->snakize($to_scr_code_c); // スネーク記法・複製先画面コード
		$to_wamei = $mission['to_wamei']; // 複製先和名
		
		foreach($scrTexts as &$scr_text){
			$scr_text = str_replace($from_scr_code_c, $to_scr_code_c, $scr_text);
			$scr_text = str_replace($from_scr_code_s, $to_scr_code_s, $scr_text);
			$scr_text = str_replace($from_wamei, $to_wamei, $scr_text);
		}
		unset($scr_text);

		return $scrTexts;
	}
	
	
	/**
	 * ソースコードテキストリストを出力
	 * @param array $scrTexts ソースコードテキストリスト
	 * @param array $toFps 複製先パスリスト
	 */
	public function outputScrTexts(&$scrTexts,$toFps){
		
		foreach($scrTexts as $i=>&$scr_text){
			$fp = $toFps[$i];
			
			// ディレクトリが存在しなければ作成する
			$pinfo = pathinfo($fp);
			$dirname = $pinfo['dirname'];
			$this->makeDirEx($dirname);
			
			// テキストファイルに書き出す
			$this->writeSource($fp,$scr_text);

		}
		unset($scr_text);
	}
	
	
	/**
	 * テキストファイルに書き出す
	 *
	 * @param string $txtFn テキストファイル名
	 * @param string $str 文字列
	 */
	private function writeSource($txtFn, $str) {
		
		// ファイルを追記モードで開く
		$fp = fopen ( $txtFn, 'ab' );
		
		// ファイルを排他ロックする
		flock ( $fp, LOCK_EX );
		
		// ファイルの中身を空にする
		ftruncate ( $fp, 0 );
		
		// データをファイルに書き込む
		fwrite ( $fp, $str );
		
		// ファイルを閉じる
		fclose ( $fp );
	}
	
	
	/**
	 * ディレクトリを作成する
	 *
	 * @note
	 * ディレクトリが既に存在しているならディレクトリを作成しない。
	 * パスに新しく作成せねばならないディレクトリ情報が複数含まれている場合でも、順次ディレクトリを作成する。
	 * 日本語ディレクトリ名にも対応。
	 * パスセパレータは「/」と「¥」に対応。
	 * ディレクトリのパーミッションの変更をを行う。(既にディレクトリが存在する場合も）
	 *
	 * @version 1.2
	 * @date 2016-8-24 | 2014-4-13
	 *
	 * @param string $dir_path ディレクトリパス
	 */
	private function makeDirEx($dir_path,$permission = 0705){
		
		if(empty($dir_path)){return;}
		
		// 日本語名を含むパスに対応する
		$dir_path=mb_convert_encoding($dir_path,'SJIS','UTF-8');
		
		// ディレクトリが既に存在する場合、書込み可能にする。
		if (is_dir($dir_path)){
			chmod($dir_path,$permission);// 書込み可能なディレクトリとする
			return;
		}
		
		// パスセパレータを取得する
		$sep = DIRECTORY_SEPARATOR;
		if(strpos($dir_path,"/")!==false){
			$sep = "/";
		}
		
		//パスを各ディレクトリに分解し、ディレクトリ配列をして取得する。
		$ary=explode($sep, $dir_path);
		
		//ディレクトリ配列の件数分以下の処理を繰り返す。
		$dd = '';
		foreach ($ary as $i => $val){
			
			if($i==0){
				$dd=$val;
			}else{
				$dd.=$sep.$val;
			}
			
			//作成したディレクトリが存在しない場合、ディレクトリを作成
			if (!is_dir($dd)){
				mkdir($dd,$permission);//ディレクトリを作成
				chmod($dd,$permission);// 書込み可能なディレクトリとする
			}
		}
	}
	
	
	/**
	 * フィールドソースコードに置換する
	 * 
	 * @note
	 * ソースコードテキスト中の可変フィールドソースコード部分を雛型から作成したフィールドソースコードに置換する。
	 * 
	 * @param array $scrTexts ソースコードテキストリスト
	 * @param array $fieldData フィールドデータ
	 * @param array $typeAData タイプAデータ
	 * @param array $mission 任務データ
	 * @return array 置換後のフィールドデータ
	 */
	public function replaceFieldScr(&$scrTexts,&$fieldData,&$typeAData,$mission){
		
		// 置換データ
		$model_c = $mission['to_scr_code']; // モデル名（スネーク記法)
		$model_s = $this->CrudBase->camelize($model_c); // モデル名（キャメル記法））
		$replaceData = array(
				'model_c' => $model_c,
				'model_s' => $model_s,
		);
		
		
		foreach($scrTexts as $i => $src_text){

			$offset = 0;
			for($x_i=0;$x_i<512;$x_i++){
				
				// ソースコードからCBBXSタグを含む行情報を取得する
				$info = $this->getRowContainSearchStr('CBBXS',$src_text,$offset);
				if (empty($info['row_str'])) break;
				$row_str = $info['row_str']; // 行文字列
				$offset_s1 = $info['offset1']; // SBBXSを含む行の開始位置
				$hina_code = $this->getHinaCodeFromRowStr($row_str); // 行文字列から雛型コードを抜き出す
				$hinaData = $this->getHinaDataByHinaCode($hina_code); // 雛型コードに紐づく雛型データをDBまたはキャッシュから取得する

				// 雛型データとフィールドデータからフィールドソースコードを作成する。
				$field_scr = $this->makeFieldScr($hinaData,$fieldData,$typeAData,$replaceData);
				
				$offset_s2 = $info['offset2']; // CBBXSタグを含む行の末尾位置
				$offset_s2 += 1; // 位置調整
				$infoE = $this->getRowContainSearchStr('CBBXE',$src_text,$offset_s2); // SBBXEの行情報を取得
				$offset_e1 = $infoE['offset1']; // CBBXEタグを含む行の開始位置
	
				// オフセットs2からオフセットe1までの位置をフィールドソースコードに置き換える
				$length = $offset_e1 - $offset_s2 ;
				$src_text = $this->mb_substr_replace($src_text, $field_scr, $offset_s2, $length);
				
				// オフセットs1からSBBXEの行情報を再検索し、オフセット2をオフセットにセットする。
				$infoE = $this->getRowContainSearchStr('CBBXE',$src_text,$offset_s1);
				$offset = $infoE['offset2'];
				
				$scrTexts[$i] = $src_text;
			}
		}
		
		return $scrTexts;
	}
	
	
	/**
	 * 雛型データとフィールドデータからフィールドソースコードを作成する。
	 * @param array $hinaData 雛型データ
	 * @param array $fieldData フィールドデータ
	 * @param array $typeAData タイプAデータ
	 * @param array $replaceData 置換データ
	 * @return string フィールドソースコード
	 */
	private function makeFieldScr(&$hinaData,&$fieldData,&$typeAData,&$replaceData){

		$hinaTypeAList = array_keys($hinaData);// 雛型データのキーを雛型タイプAリストとして取得する
		
		if(empty($hinaTypeAList)) return "";

		$field_scr = ''; // フィールドソースコード
		
		if(empty($hinaData)) return $field_scr;
		
		foreach($fieldData as $ent){
			$type_a_tmp = $ent['type_a']; // 候補タイプA
			
			// ツリー構造のタイプAデータから、候補タイプAを始点に上位をさかのぼって、適切なタイプAを取得する。
			$type_a = $this->backSearchTypeA($type_a_tmp,$hinaTypeAList,$typeAData);
			if($type_a == 0) continue;
			
			$hinagata = $hinaData[$type_a];
			$field_s = $ent['field_name'];
			$field_c = $this->CrudBase->camelize($field_s); // キャメル記法に変換
			$field_lcc = $this->CrudBase->lowerCamelize($field_s); // ローワーキャメル記法に変換
			
			$hinagata = str_replace('%model_s', $replaceData['model_s'], $hinagata); // モデル名（スネーク記法）
			$hinagata = str_replace('%model_c', $replaceData['model_c'], $hinagata); // モデル名（キャメル記法）
			$hinagata = str_replace('%field_s', $field_s, $hinagata); // フィールド名（スネーク記法）
			$hinagata = str_replace('%field_c', $field_c, $hinagata); // フィールド名（キャメル記法）
			$hinagata = str_replace('%field_lcc', $field_lcc, $hinagata); // フィールド名（ローワーキャメル記法）
			$hinagata = str_replace('%field_type', $ent['field_type'], $hinagata); // 型
			$hinagata = str_replace('%type_long', $ent['type_long'], $hinagata); // 型長　
			$hinagata = str_replace('%comment', $ent['comment'], $hinagata); // コメント
			$hinagata = str_replace('%null_flg', $ent['null_flg'], $hinagata); // NULLフラグ
			$hinagata = str_replace('%p_key_flg', $ent['p_key_flg'], $hinagata); // 主キーフラグ
			$hinagata = str_replace('%def_val', $ent['def_val'], $hinagata); // デフォルト値
			
			if(!empty($hinagata)){
				$field_scr .= $hinagata . "\n";
			}

		}

		return $field_scr;
		
	}
	
	
	/**
	 * ツリー構造のタイプAデータから、候補タイプAを始点に上位をさかのぼって、適切なタイプAを取得する。
	 * 
	 * @param int $type_a_tmp 候補タイプA
	 * @param array $hinaTypeAList 雛タイプAリスト
	 * @param array $typeAData タイプAデータ
	 * 
	 */
	private function backSearchTypeA($type_a_tmp,&$hinaTypeAList,&$typeAData){
		
		for($i=0;$i<100;$i++){

			// 雛タイプAリストから候補タイプAリストを検索する。
			$key = array_search($type_a_tmp,$hinaTypeAList);
			
			// 雛タイプA配列に候補タイプAが存在するなら、その値であるタイプAを返す。
			if($key!==false){
				return $hinaTypeAList[$key];
			}
			
			// 存在しない場合
			else{
				
				if(empty($typeAData[$type_a_tmp])) return 0;
				
				// タイプAデータXから候補タイプAに紐づく親IDを候補タイプAとしてセットする
				$type_a_tmp = $typeAData[$type_a_tmp]['par_id'];
				
				// 候補タイプAが0である場合、0を返して処理抜け
				if($type_a_tmp == 0) return 0;

			}
		}
		return 0;
	}
	
	
	/**
	 * @param mixed $string The input string.
	 * @param mixed $replacement The replacement string.
	 * @param mixed $start If start is positive, the replacing will begin at the start'th offset into string.  If start is negative, the replacing will begin at the start'th character from the end of string.
	 * @param mixed $length If given and is positive, it represents the length of the portion of string which is to be replaced. If it is negative, it represents the number of characters from the end of string at which to stop replacing. If it is not given, then it will default to strlen( string ); i.e. end the replacing at the end of string. Of course, if length is zero then this function will have the effect of inserting replacement into string at the given start offset.
	 * @return string The result string is returned. If string is an array then array is returned.
	 */
	private function mb_substr_replace($string, $replacement, $start, $length=NULL) {
		if (is_array($string)) {
			$num = count($string);
			// $replacement
			$replacement = is_array($replacement) ? array_slice($replacement, 0, $num) : array_pad(array($replacement), $num, $replacement);
			// $start
			if (is_array($start)) {
				$start = array_slice($start, 0, $num);
				foreach ($start as $key => $value)
					$start[$key] = is_int($value) ? $value : 0;
			}
			else {
				$start = array_pad(array($start), $num, $start);
			}
			// $length
			if (!isset($length)) {
				$length = array_fill(0, $num, 0);
			}
			elseif (is_array($length)) {
				$length = array_slice($length, 0, $num);
				foreach ($length as $key => $value)
					$length[$key] = isset($value) ? (is_int($value) ? $value : $num) : 0;
			}
			else {
				$length = array_pad(array($length), $num, $length);
			}
			// Recursive call
			return array_map(__FUNCTION__, $string, $replacement, $start, $length);
		}
		preg_match_all('/./us', (string)$string, $smatches);
		preg_match_all('/./us', (string)$replacement, $rmatches);
		if ($length === NULL) $length = mb_strlen($string);
		array_splice($smatches[0], $start, $length, $rmatches[0]);
		return join($smatches[0]);
	}
	
	
	
	/**
	 * 検索する文字を含む行を取得する
	 *
	 * @note
	 * 検索する文字を含む改行コードにはさまれた文字列を取得する
	 *
	 * @param string $search 検索文字
	 * @param string $subject 対象文字列
	 * @param int $offset 検索開始位置
	 * @param string $nl_code 改行コード
	 * @return string 検索文字を含む行
	 */
	function getRowContainSearchStr($search,$subject,$offset=0,$nl_code="\n"){
		$len = mb_strlen($subject);
		$a1 = mb_strpos($subject,$search,$offset);
		if($a1 === false){
			return array(
					'offset1' => null,
					'offset2' => null,
					'row_str' => null,
			);
		}
		$offset2 = mb_strpos($subject,$nl_code,$a1);
		if($offset2 === false) $offset2 = $len;
		$a2 = $offset2 - $len -1;
		$offset1 = mb_strripos($subject,$nl_code,$a2);
		if($offset1 === false) $offset1 = 0;
		$row_str = mb_substr($subject,$offset1,$offset2 - $offset1);
		
		return array(
				'offset1' => $offset1,
				'offset2' => $offset2,
				'row_str' => $row_str,
		);
	}
	
	
	
	/**
	 * 行文字列から雛型コードを抜き出す
	 * @param string $row_str 行文字列
	 * @return int 雛型コード
	 */
	public function getHinaCodeFromRowStr($row_str){
		$pattern = '/CBBXS\-\d{2,6}/';
		preg_match ($pattern, $row_str, $matches);
		if(!empty($matches)){
			$tag = $matches[0];
			$hina_code = str_replace('CBBXS-', '', $tag);
			return $hina_code;
		}else{
			return null;
		}
	}
	

	/**
	 * ; 雛型コードに紐づく雛型データをDBまたはキャッシュから取得する
	 * @param string $hina_code 雛コード
	 * @return array 雛型データ
	 */
	private function getHinaDataByHinaCode($hina_code){
		
		// キャッシュに雛型データが存在するなら、それを返す。
		if(isset($this->hinaDataCash[$hina_code])) return $this->hinaDataCash[$hina_code];
		
		if(empty($this->Hinagata)){
			App::uses('Hinagata','Model');
			$this->Hinagata=ClassRegistry::init('Hinagata');
		}
		
		//SELECT情報
		$fields=array(
				'type_a',
				'hinagata',
		);
		
		//WHERE情報
		$conditions=array(
				"hina_code = '{$hina_code}'",
				"delete_flg = 0",
		);
		
		//ORDER情報
		$order=array('sort_no');
		
		//オプション
		$option=array(
				'fields'=>$fields,
				'conditions'=>$conditions,
				'order'=>$order,
		);
		
		//DBから取得
		$data=$this->Hinagata->find('all',$option);
		
		//2次元配列に構造変換する。
		if(!empty($data)){
			$data = Hash::combine($data, '{n}.Hinagata.type_a','{n}.Hinagata.hinagata');
			$this->sql_sanitize_decode($data); // SQLサニタイズデコード
		}
		
		$this->hinaDataCash[$hina_code] = $data;

		return $data;
	}
	
	
	/**
	 * SQLサニタイズデコード
	 *
	 * @note
	 * SQLインジェクションでサニタイズしたデータを元に戻す。
	 * 高速化のため、引数は参照（ポインタ）にしている。
	 *
	 * @param any サニタイズデコード対象のデータ | 値および配列を指定
	 * @return void
	 */
	protected function sql_sanitize_decode(&$data){
		
		if(is_array($data)){
			foreach($data as &$val){
				$this->sql_sanitize_decode($val);
			}
			unset($val);
		}elseif(gettype($data)=='string'){
			$data = stripslashes($data);
		}else{
			// 何もしない
		}
	}
	
	/**
	 * タイプAデータをDBから取得する
	 * @return array タイプAデータ
	 */
	public function getTypeADataForExeBulk(){
		if(empty($this->TypeA)){
			App::uses('TypeA','Model');
			$this->TypeA=ClassRegistry::init('TypeA');
		}
		
		//SELECT情報
		$fields=array(
				'id',
				'type_a_name',
				'par_id	',
		);
		
		//WHERE情報
		$conditions=array("delete_flg = 0");
		
		//オプション
		$option=array(
				'fields'=>$fields,
				'conditions'=>$conditions,
		);
		
		//DBから取得
		$data=$this->TypeA->find('all',$option);
		
		//2次元配列に構造変換する。
		if(!empty($data)){
			$data=Hash::combine($data, '{n}.TypeA.id','{n}.TypeA');
		}
		
		return $data;
	}
	
	
}


















