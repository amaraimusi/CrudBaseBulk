<?php
App::uses('CrudBaseController', 'Controller');
App::uses('PagenationForCake', 'Vendor/Wacg');

/**
 * フィールド雛型
 * 
 * フィールド雛型画面ではフィールド雛型一覧を検索閲覧、および編集ができます。
 * 
 * 
 * @date 2015-9-16	新規作成 
 * @author k-uehara
 *
 */
class HinagataController extends CrudBaseController {

	/// 名称コード
	public $name = 'Hinagata';
	
	/// 使用しているモデル
	public $uses = array('Hinagata','CrudBase');
	
	/// オリジナルヘルパーの登録
	public $helpers = array('CrudBase');

	/// デフォルトの並び替え対象フィールド
	public $defSortFeild='Hinagata.sort_no';
	
	/// デフォルトソートタイプ	  0:昇順 1:降順
	public $defSortType=0;
	
	/// 検索条件情報の定義
	public $kensakuJoken=array();

	/// 検索条件のバリデーション
	public $kjs_validate = array();

	///フィールドデータ
	public $field_data=array();

	/// 編集エンティティ定義
	public $entity_info=array();

	/// 編集用バリデーション
	public $edit_validate = array();
	
	// 当画面バージョン (バージョンを変更すると画面に新バージョン通知とクリアボタンが表示されます。）
	public $this_page_version = '1.9.1'; 



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

	/**
	 * indexページのアクション
	 *
	 * indexページではフィールド雛型一覧を検索閲覧できます。
	 * 一覧のidから詳細画面に遷移できます。
	 * ページネーション、列名ソート、列表示切替、CSVダウンロード機能を備えます。
	 */
	public function index() {
		
        // CrudBase共通処理（前）
		$crudBaseData = $this->indexBefore('Hinagata');//indexアクションの共通先処理(CrudBaseController)
		
		//一覧データを取得
		$data = $this->Hinagata->findData2($crudBaseData);

		// CrudBase共通処理（後）
		$crudBaseData = $this->indexAfter($crudBaseData);//indexアクションの共通後処理
		
		// タイプAリストとJSONを取得する
		$typeAList = $this->Hinagata->getTypeAList();
		$type_a_json = json_encode($typeAList,JSON_HEX_TAG | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_APOS);
		
		$this->set($crudBaseData);
		$this->set(array(
			'title_for_layout'=>'フィールド雛型',
			'data'=> $data,
			'typeAList' => $typeAList,
			'type_a_json' => $type_a_json,
		));
		
		//当画面系の共通セット
		$this->setCommon();


	}

	/**
	 * 詳細画面
	 * 
	 * フィールド雛型情報の詳細を表示します。
	 * この画面から入力画面に遷移できます。
	 * 
	 */
	public function detail() {
		
		$res=$this->edit_before('Hinagata');
		$ent=$res['ent'];
	

		$this->set(array(
				'title_for_layout'=>'フィールド雛型・詳細',
				'ent'=>$ent,
		));
		
		//当画面系の共通セット
		$this->setCommon();
	
	}













	/**
	 * 入力画面
	 * 
	 * 入力フォームにて値の入力が可能です。バリデーション機能を実装しています。
	 * 
	 * URLクエリにidが付属する場合は編集モードになります。
	 * idがない場合は新規入力モードになります。
	 * 
	 */
	public function edit() {

		$res=$this->edit_before('Hinagata');
		$ent=$res['ent'];

		$this->set(array(
				'title_for_layout'=>'フィールド雛型・編集',
				'ent'=>$ent,
		));
		
		//当画面系の共通セット
		$this->setCommon();

	}
	
	 /**
	 * 登録完了画面
	 * 
	 * 入力画面の更新ボタンを押し、DB更新に成功した場合、この画面に遷移します。
	 * 入力エラーがある場合は、入力画面へ、エラーメッセージと共にリダイレクトで戻ります。
	 */
	public function reg(){
		$res=$this->reg_before('Hinagata');
		$ent=$res['ent'];
		
		$regMsg="<p id='reg_msg'>更新しました。</p>";
		
		$this->set(array(
				'title_for_layout'=>'フィールド雛型・登録完了',
				'ent'=>$ent,
				'regMsg'=>$regMsg,
		));
		
		//当画面系の共通セット
		$this->setCommon();

	}
	
	
	
	
	/**
	 * DB登録
	 *
	 * @note
	 * Ajaxによる登録。
	 * 編集登録と新規入力登録の両方に対応している。
	 */
	public function ajax_reg(){
		App::uses('Sanitize', 'Utility');
	
		$this->autoRender = false;//ビュー(ctp)を使わない。
	
		// JSON文字列をパースしてエンティティを取得する
		$json=$_POST['key1'];
		$ent = json_decode($json,true);
		
		// 登録パラメータ
		$reg_param_json = $_POST['reg_param_json'];
		$regParam = json_decode($reg_param_json,true);
	
	
		// アップロードファイルが存在すればエンティティにセットする。
		$upload_file = null;
		if(!empty($_FILES["upload_file"])){
			$upload_file = $_FILES["upload_file"]["name"];
			$ent['hinagata_fn'] = $upload_file;
		}
	
	
		// 更新ユーザーなど共通フィールドをセットする。
		$ent = $this->setCommonToEntity($ent);
	
		// エンティティをDB保存
		$this->Hinagata->begin();
		$ent = $this->Hinagata->saveEntity($ent,$regParam);
		$this->Hinagata->commit();//コミット

		if(!empty($upload_file)){
			
			// ファイルパスを組み立て
			$upload_file = $_FILES["upload_file"]["name"];
			$ffn = "game_rs/app{$id}/app_icon/{$fn}";
			
			// 一時ファイルを所定の場所へコピー（フォルダなければ自動作成）
			$this->copyEx($_FILES["upload_file"]["tmp_name"], $ffn);
	
	
		}

		$json_data=json_encode($ent,true);//JSONに変換
	
		return $json_data;
	}
	
	
	
	
	
	
	
	/**
	 * 削除登録
	 *
	 * @note
	 * Ajaxによる削除登録。
	 * 削除更新でだけでなく有効化に対応している。
	 * また、DBから実際に削除する抹消にも対応している。
	 */
	public function ajax_delete(){
		App::uses('Sanitize', 'Utility');
	
		$this->autoRender = false;//ビュー(ctp)を使わない。
	
		// JSON文字列をパースしてエンティティを取得する
		$json=$_POST['key1'];
		$ent0 = json_decode($json,true);
		
		// 登録パラメータ
		$reg_param_json = $_POST['reg_param_json'];
		$regParam = json_decode($reg_param_json,true);

	   // 抹消フラグ
	   $eliminate_flg = 0;
	   if(isset($regParam['eliminate_flg'])) $eliminate_flg = $regParam['eliminate_flg'];
	   
		// 削除用のエンティティを取得する
		$ent = $this->getEntForDelete($ent0['id']);
		$ent['delete_flg'] = $ent0['delete_flg'];
	
		// エンティティをDB保存
		$this->Hinagata->begin();
		if($eliminate_flg == 0){
			$ent = $this->Hinagata->saveEntity($ent,$regParam); // 更新
		}else{
		    $this->Hinagata->delete($ent['id']); // 削除
		}
		$this->Hinagata->commit();//コミット
	
		$ent=Sanitize::clean($ent, array('encode' => true));//サニタイズ（XSS対策）
		$json_data=json_encode($ent);//JSONに変換
	
		return $json_data;
	}
	
	
	/**
	* Ajax | 自動保存
	* 
	* @note
	* バリデーション機能は備えていない
	* 
	*/
	public function auto_save(){
		
		App::uses('Sanitize', 'Utility');
		
		$this->autoRender = false;//ビュー(ctp)を使わない。
		
		$json=$_POST['key1'];
		
		$data = json_decode($json,true);//JSON文字を配列に戻す
		
		// データ保存
		$this->Hinagata->begin();
		$this->Hinagata->saveAll($data);
		$this->Hinagata->commit();

		$res = array('success');
		
		$json_str = json_encode($res);//JSONに変換
		
		return $json_str;
	}
	

	
	
	/**
	 * CSVインポート | AJAX
	 *
	 * @note
	 *
	 */
	public function csv_fu(){
		$this->autoRender = false;//ビュー(ctp)を使わない。
		
		$this->csv_fu_base($this->Hinagata,array('id','hinagata_val','hinagata_name','hinagata_date','type_a','hinagata_dt','note','sort_no'));
		
	}
	



	
	



	/**
	 * CSVダウンロード
	 *
	 * 一覧画面のCSVダウンロードボタンを押したとき、一覧データをCSVファイルとしてダウンロードします。
	 */
	public function csv_download(){
		$this->autoRender = false;//ビューを使わない。
	
		//ダウンロード用のデータを取得する。
		$data = $this->getDataForDownload();
		
		
		// ユーザーエージェントなど特定の項目をダブルクォートで囲む
		foreach($data as $i=>$ent){
			if(!empty($ent['user_agent'])){
				$data[$i]['user_agent']='"'.$ent['user_agent'].'"';
			}
		}

		
		
		//列名配列を取得
		$clms=array_keys($data[0]);
	
		//データの先頭行に列名配列を挿入
		array_unshift($data,$clms);
	
	
		//CSVファイル名を作成
		$date = new DateTime();
		$strDate=$date->format("Y-m-d");
		$fn='hinagata'.$strDate.'.csv';
	
	
		//CSVダウンロード
		App::uses('CsvDownloader','Vendor/Wacg');
		$csv= new CsvDownloader();
		$csv->output($fn, $data);
		 
	
	
	}
	
	

	
	
	//ダウンロード用のデータを取得する。
	private function getDataForDownload(){
		 
		
        //セッションから検索条件情報を取得
        $kjs=$this->Session->read('hinagata_kjs');
        
        // セッションからページネーション情報を取得
        $pages = $this->Session->read('hinagata_pages');

        $page_no = 0;
        $row_limit = 100000;
        $sort_field = $pages['sort_field'];
        $sort_desc = $pages['sort_desc'];

		//DBからデータ取得
	   $data=$this->Hinagata->findData($kjs,$page_no,$row_limit,$sort_field,$sort_desc);
		if(empty($data)){
			return array();
		}
	
		return $data;
	}
	

	/**
	 * 当画面系の共通セット
	 */
	private function setCommon(){

		
		// 新バージョンであるかチェックする。
		$new_version_flg = $this->checkNewPageVersion($this->this_page_version);
		
		$this->set(array(
				'header' => 'header_demo',
				'new_version_flg' => $new_version_flg, // 当ページの新バージョンフラグ   0:バージョン変更なし  1:新バージョン
				'this_page_version' => $this->this_page_version,// 当ページのバージョン
		));
	}
	

	/**
	 * CrudBase用の初期化処理
	 *
	 * @note
	 * フィールド関連の定義をする。
	 *
	 *
	 */
	private function initCrudBase(){

		
		
		
		
		/// 検索条件情報の定義
		$this->kensakuJoken=array(
		
			array('name'=>'kj_id','def'=>null),
			array('name'=>'kj_hina_code','def'=>null),
			array('name'=>'kj_type_a','def'=>null),
			array('name'=>'kj_hinagata','def'=>null),
			array('name'=>'kj_sort_no','def'=>null),
			array('name'=>'kj_delete_flg','def'=>0),
			array('name'=>'kj_update_user','def'=>null),
			array('name'=>'kj_ip_addr','def'=>null),
			array('name'=>'kj_created','def'=>null),
			array('name'=>'kj_modified','def'=>null),
			array('name'=>'row_limit','def'=>50),
					
		);
		
		
		
		
		
		/// 検索条件のバリデーション
		$this->kjs_validate=array(
		
				'kj_id' => array(
						'naturalNumber'=>array(
								'rule' => array('naturalNumber', true),
								'message' => 'IDは数値を入力してください',
								'allowEmpty' => true
						),
				),
					
				'kj_hina_code'=> array(
						'maxLength'=>array(
								'rule' => array('maxLength', 255),
								'message' => '雛型コードは255文字以内で入力してください',
								'allowEmpty' => true
						),
				),
					
				'kj_hinagata'=> array(
						'maxLength'=>array(
								'rule' => array('maxLength', 255),
								'message' => '雛型は255文字以内で入力してください',
								'allowEmpty' => true
						),
				),
			
				'kj_sort_no' => array(
					'custom'=>array(
						'rule' => array( 'custom', '/^[-]?[0-9]+?$/' ),
						'message' => '順番は整数を入力してください。',
						'allowEmpty' => true
					),
				),
					
				'kj_update_user'=> array(
						'maxLength'=>array(
								'rule' => array('maxLength', 50),
								'message' => '更新者は50文字以内で入力してください',
								'allowEmpty' => true
						),
				),
					
				'kj_ip_addr'=> array(
						'maxLength'=>array(
								'rule' => array('maxLength', 40),
								'message' => '更新IPアドレスは40文字以内で入力してください',
								'allowEmpty' => true
						),
				),
					
				'kj_created'=> array(
						'maxLength'=>array(
								'rule' => array('maxLength', 20),
								'message' => '生成日時は20文字以内で入力してください',
								'allowEmpty' => true
						),
				),
					
				'kj_modified'=> array(
						'maxLength'=>array(
								'rule' => array('maxLength', 20),
								'message' => '更新日時は20文字以内で入力してください',
								'allowEmpty' => true
						),
				),
		);
		
		
		
		
		
		///フィールドデータ
		$this->field_data = array('def'=>array(
		
			'id'=>array(
					'name'=>'ID',//HTMLテーブルの列名
					'row_order'=>'Hinagata.id',//SQLでの並び替えコード
					'clm_show'=>1,//デフォルト列表示 0:非表示 1:表示
			),
			'hina_code'=>array(
					'name'=>'雛型コード',
					'row_order'=>'Hinagata.hina_code',
					'clm_show'=>1,
			),
			'type_a'=>array(
				'name'=>'タイプA',
				'row_order'=>'Hinagata.type_a',
				'clm_show'=>1,
			),
			'hinagata'=>array(
					'name'=>'雛型',
					'row_order'=>'Hinagata.hinagata',
					'clm_show'=>1,
			),
			'sort_no'=>array(
				'name'=>'順番',
				'row_order'=>'Hinagata.sort_no',
				'clm_show'=>0,
			),
			'delete_flg'=>array(
					'name'=>'削除フラグ',
					'row_order'=>'Hinagata.delete_flg',
					'clm_show'=>1,
			),
			'update_user'=>array(
					'name'=>'更新者',
					'row_order'=>'Hinagata.update_user',
					'clm_show'=>0,
			),
			'ip_addr'=>array(
					'name'=>'更新IPアドレス',
					'row_order'=>'Hinagata.ip_addr',
					'clm_show'=>0,
			),
			'created'=>array(
					'name'=>'生成日時',
					'row_order'=>'Hinagata.created',
					'clm_show'=>0,
			),
			'modified'=>array(
					'name'=>'更新日時',
					'row_order'=>'Hinagata.modified',
					'clm_show'=>0,
			),
		));

		// 列並び順をセットする
		$clm_sort_no = 0;
		foreach ($this->field_data['def'] as &$fEnt){
			$fEnt['clm_sort_no'] = $clm_sort_no;
			$clm_sort_no ++;
		}
		unset($fEnt);

		
		 
	}
	
	
	/**
	 * 雛型コードを指定して一括コピー | Ajax 非同期通信
	 * @return string
	 */
	public function bulkCopyByHinaCode(){
		$this->autoRender = false;//ビュー(ctp)を使わない。

		// 通信元から送信されてきたパラメータを取得する。
		$param_json = $_POST['key1'];
		$param=json_decode($param_json,true);//JSON文字を配列に戻す
		
		$hina_code_orig = $param['hina_code_orig'];
		$hina_code_new = $param['hina_code_new'];
		
		$sql = "
			INSERT INTO hinagatas(
				hina_code, 
				type_a, 
				hinagata, 
				sort_no, 
				delete_flg, 
				update_user_id, 
				update_user, 
				ip_addr, 
				created, 
				modified
			) 
			SELECT 
				'{$hina_code_new}' AS hina_code, 
				type_a, 
				hinagata, 
				sort_no, 
				delete_flg, 
				update_user_id, 
				update_user, 
				ip_addr, 
				created, 
				modified
			 FROM hinagatas WHERE hina_code='{$hina_code_orig}';
		";
		$res = $this->Hinagata->query($sql);

		//データ加工や取得
		$res['success'] = 1;
		
		// JSONに変換し、通信元に返す。
		$json_str = json_encode($res, JSON_HEX_TAG | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_APOS);
		return $json_str;
		
	}
	
	
	/**
	 * 雛型コード・一括定型入力 | Ajax 非同期通信
	 * @return string
	 */
	public function bulkCommonByHinaCode(){
		$this->autoRender = false;//ビュー(ctp)を使わない。
		
		// 通信元から送信されてきたパラメータを取得する。
		$param_json = $_POST['key1'];
		$param=json_decode($param_json,true);//JSON文字を配列に戻す
		
		$hina_code = $param['hina_code'];
		if(empty($hina_code)) throw new Exception('雛コードが未入力です。');
		
		$sql = "SELECT MAX(sort_no) AS max_sort_no FROM hinagatas";
		$res = $this->Hinagata->query($sql);
		$next_sort_no = 0;
		if(!empty($res)){
			$next_sort_no = $res[0][0]['max_sort_no'];
			$next_sort_no ++;
		}

		$sql = "
			INSERT INTO `hinagatas` (`hina_code`, `type_a`, `hinagata`, `sort_no`, `delete_flg`, `update_user_id`, `update_user`, `ip_addr`) VALUES
			('{$hina_code}', 33, '', {$next_sort_no}, 0, NULL, 'kenzy', '::1'),
			('{$hina_code}', 26, '', {$next_sort_no}, 0, NULL, 'kenzy', '::1'),
			('{$hina_code}', 19, '', {$next_sort_no}, 0, NULL, 'kenzy', '::1'),
			('{$hina_code}', 18, '', {$next_sort_no}, 0, NULL, 'kenzy', '::1'),
			('{$hina_code}', 12, '', {$next_sort_no}, 0, NULL, 'kenzy', '::1'),
			('{$hina_code}', 17, '', {$next_sort_no}, 0, NULL, 'kenzy', '::1'),
			('{$hina_code}', 22, '', {$next_sort_no}, 0, NULL, 'kenzy', '::1');
		";
		$res = $this->Hinagata->query($sql);
		
		//データ加工や取得
		$res['success'] = 1;
		
		// JSONに変換し、通信元に返す。
		$json_str = json_encode($res, JSON_HEX_TAG | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_APOS);
		return $json_str;
		
	}
	
	
	/**
	 * 雛型コード・一括削除	 | Ajax 非同期通信
	 * @return string
	 */
	public function bulkDeleteByHinaCode	(){
		$this->autoRender = false;//ビュー(ctp)を使わない。
		
		// 通信元から送信されてきたパラメータを取得する。
		$param_json = $_POST['key1'];
		$param=json_decode($param_json,true);//JSON文字を配列に戻す
		
		$hina_code = $param['hina_code'];
		$del_type = $param['del_type'];
		
		if(empty($hina_code)) throw new Exception('雛コードが未入力です。');
		
		switch ($del_type){
			case 'delete_flg_on': // 削除フラグON
				$sql = "UPDATE hinagatas SET delete_flg = 1  WHERE hina_code='{$hina_code}'";
				$res = $this->Hinagata->query($sql);
				break;
			case 'delete_flg_off': // 削除フラグOFF
				
				$sql = "UPDATE hinagatas SET delete_flg = 0  WHERE hina_code='{$hina_code}'";
				$res = $this->Hinagata->query($sql);
				break;
			case 'destroy': // DBから完全削除
				
				$sql = "DELETE  FROM hinagatas WHERE hina_code='{$hina_code}'";
				$res = $this->Hinagata->query($sql);
				break;
			default:
				throw new Exception('$del_type is empty!');
		}

		
		//データ加工や取得
		$param['success'] = 1;
		
		// JSONに変換し、通信元に返す。
		$json_str = json_encode($param, JSON_HEX_TAG | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_APOS);
		return $json_str;
		
	}


}