<?php
App::uses('CrudBaseController', 'Controller');
App::uses('PagenationForCake', 'Vendor/Wacg');

/**
 * 一括作成
 * 
 * 一括作成画面では一括作成一覧を検索閲覧、および編集ができます。
 * 
 * 
 * @date 2015-9-16	新規作成 
 * @author k-uehara
 *
 */
class BulkMakeController extends CrudBaseController {

	/// 名称コード
	public $name = 'BulkMake';
	
	/// 使用しているモデル
	public $uses = array('BulkMake','Mission','CrudBase');
	
	/// オリジナルヘルパーの登録
	public $helpers = array('CrudBase');

	/// デフォルトの並び替え対象フィールド
	public $defSortFeild='BulkMake.sort_no';
	
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
	
		parent::beforeFilter();
	
		$this->initCrudBase();// フィールド関連の定義をする。
	
	}

	/**
	 * indexページのアクション
	 *
	 * indexページでは一括作成一覧を検索閲覧できます。
	 * 一覧のidから詳細画面に遷移できます。
	 * ページネーション、列名ソート、列表示切替、CSVダウンロード機能を備えます。
	 */
	public function index() {
		
        // CrudBase共通処理（前）
		$crudBaseData = $this->indexBefore('BulkMake');//indexアクションの共通先処理(CrudBaseController)
		
		//一覧データを取得
		$data = $this->BulkMake->findData2($crudBaseData);
		$data_json = json_encode($data,JSON_HEX_TAG | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_APOS);
		

		// CrudBase共通処理（後）
		$crudBaseData = $this->indexAfter($crudBaseData);//indexアクションの共通後処理
		
		// 任務エンティティを取得する
		$kjs = $crudBaseData['kjs'];
		$kj_mission_id = $kjs['kj_mission_id'];
		$missionEnt = $this->Mission->findEntity($kj_mission_id);
		$mission_json = json_encode($missionEnt,JSON_HEX_TAG | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_APOS);

		// タイプAリストとJSONを取得する
		$typeAList = $this->BulkMake->getTypeAList();
		$type_a_json = json_encode($typeAList,JSON_HEX_TAG | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_APOS);

	
		$this->set($crudBaseData);
		$this->set(array(
			'title_for_layout'=>'一括作成',
		    'data'=> $data,
		    'data_json'=> $data_json,
			'typeAList' => $typeAList,
		    'type_a_json' => $type_a_json,
		    'missionEnt' => $missionEnt,
		    'mission_json' => $mission_json,
		));
		
		//当画面系の共通セット
		$this->setCommon();


	}

	/**
	 * 詳細画面
	 * 
	 * 一括作成情報の詳細を表示します。
	 * この画面から入力画面に遷移できます。
	 * 
	 */
	public function detail() {
		
		$res=$this->edit_before('BulkMake');
		$ent=$res['ent'];
	

		$this->set(array(
				'title_for_layout'=>'一括作成・詳細',
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

		$res=$this->edit_before('BulkMake');
		$ent=$res['ent'];

		$this->set(array(
				'title_for_layout'=>'一括作成・編集',
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
		$res=$this->reg_before('BulkMake');
		$ent=$res['ent'];
		
		$regMsg="<p id='reg_msg'>更新しました。</p>";

		
		//★DB保存
		$this->BulkMake->begin();//トランザクション開始
		$ent=$this->BulkMake->saveEntity($ent);//登録
		$this->BulkMake->commit();//コミット

		$this->set(array(
				'title_for_layout'=>'一括作成・登録完了',
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
			$ent['bulk_make_fn'] = $upload_file;
		}
	
	
		// 更新ユーザーなど共通フィールドをセットする。
		$ent = $this->setCommonToEntity($ent);
	
		// エンティティをDB保存
		$this->BulkMake->begin();
		$option = array();
		if(isset($regParam['ni_tr_place'])) $option['ni_tr_place'] = $regParam['ni_tr_place'];
		$ent = $this->BulkMake->saveEntity($ent,$option);
		$this->BulkMake->commit();//コミット

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

	   // 抹消フラグ
	   $eliminate_flg = 0;
	   if(isset($_POST['eliminate_flg'])) $eliminate_flg = $_POST['eliminate_flg'];
	   
		// 削除用のエンティティを取得する
		$ent = $this->getEntForDelete($ent0['id']);
		$ent['delete_flg'] = $ent0['delete_flg'];
	
		// エンティティをDB保存
		$this->BulkMake->begin();
		if($eliminate_flg == 0){
		    $ent = $this->BulkMake->saveEntity($ent); // 更新
		}else{
		    $this->BulkMake->delete($ent['id']); // 削除
		}
		$this->BulkMake->commit();//コミット
	
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
		
		$data = Sanitize::clean($data, array('encode' => false));
		
		// データ保存
		$this->BulkMake->begin();
		$this->BulkMake->saveAll($data);
		$this->BulkMake->commit();

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
		
		$this->csv_fu_base($this->BulkMake,array('id','bulk_make_val','bulk_make_name','bulk_make_date','bulk_make_group','bulk_make_dt','note','sort_no'));
		
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
		$fn='bulk_make'.$strDate.'.csv';
	
	
		//CSVダウンロード
		App::uses('CsvDownloader','Vendor/Wacg');
		$csv= new CsvDownloader();
		$csv->output($fn, $data);
		 
	
	
	}
	
	

	
	
	//ダウンロード用のデータを取得する。
	private function getDataForDownload(){
		 
		
        //セッションから検索条件情報を取得
        $kjs=$this->Session->read('bulk_make_kjs');
        
        // セッションからページネーション情報を取得
        $pages = $this->Session->read('bulk_make_pages');

        $page_no = 0;
        $row_limit = 100000;
        $sort_field = $pages['sort_field'];
        $sort_desc = $pages['sort_desc'];

		//DBからデータ取得
	   $data=$this->BulkMake->findData($kjs,$page_no,$row_limit,$sort_field,$sort_desc);
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
		    array('name'=>'kj_mission_id','def'=>null),
		    array('name'=>'kj_field_name','def'=>null),
		    array('name'=>'kj_type_a','def'=>null),
		    array('name'=>'kj_field_type','def'=>null),
		    array('name'=>'kj_orig_type','def'=>null),
		    array('name'=>'kj_type_long','def'=>null),
		    array('name'=>'kj_null_flg','def'=>null),
		    array('name'=>'kj_p_key_flg','def'=>null),
		    array('name'=>'kj_def_val','def'=>null),
		    array('name'=>'kj_extra','def'=>null),
		    array('name'=>'kj_comment','def'=>null),
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
		    
	           'kj_mission_id' => array(
				    'naturalNumber'=>array(
				        'rule' => array('naturalNumber', true),
				        'message' => '任務IDは数値を入力してください',
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
					'row_order'=>'BulkMake.id',//SQLでの並び替えコード
					'clm_show'=>1,//デフォルト列表示 0:非表示 1:表示
			),
		    'mission_id'=>array(
		        'name'=>'任務id',
		        'row_order'=>'BulkMake.mission_id',
		        'clm_show'=>1,
		    ),
		    'field_name'=>array(
		        'name'=>'フィールド名',
		        'row_order'=>'BulkMake.field_name',
		        'clm_show'=>1,
		    ),
		    'type_a'=>array(
		        'name'=>'タイプA',
		        'row_order'=>'BulkMake.type_a',
		        'clm_show'=>1,
		    ),
		    'field_type'=>array(
		        'name'=>'フィールド型',
		        'row_order'=>'BulkMake.field_type',
		        'clm_show'=>1,
		    ),
		    'orig_type'=>array(
		        'name'=>'オリジナル型',
		        'row_order'=>'BulkMake.orig_type',
		        'clm_show'=>0,
		    ),
		    'type_long'=>array(
		        'name'=>'型長さ',
		        'row_order'=>'BulkMake.type_long',
		        'clm_show'=>0,
		    ),
		    'null_flg'=>array(
		        'name'=>'NULLフラグ',
		        'row_order'=>'BulkMake.null_flg',
		        'clm_show'=>0,
		    ),
		    'p_key_flg'=>array(
		        'name'=>'主キーフラグ',
		        'row_order'=>'BulkMake.p_key_flg',
		        'clm_show'=>0,
		    ),
		    'def_val'=>array(
		        'name'=>'デフォルト値',
		        'row_order'=>'BulkMake.def_val',
		        'clm_show'=>0,
		    ),
		    'extra'=>array(
		        'name'=>'補足',
		        'row_order'=>'BulkMake.extra',
		        'clm_show'=>0,
		    ),
		    'comment'=>array(
		        'name'=>'コメント',
		        'row_order'=>'BulkMake.comment',
		        'clm_show'=>1,
		    ),
			'sort_no'=>array(
				'name'=>'順番',
				'row_order'=>'BulkMake.sort_no',
				'clm_show'=>0,
			),
			'delete_flg'=>array(
					'name'=>'削除フラグ',
					'row_order'=>'BulkMake.delete_flg',
					'clm_show'=>0,
			),
			'update_user'=>array(
					'name'=>'更新者',
					'row_order'=>'BulkMake.update_user',
					'clm_show'=>0,
			),
			'ip_addr'=>array(
					'name'=>'更新IPアドレス',
					'row_order'=>'BulkMake.ip_addr',
					'clm_show'=>0,
			),
			'created'=>array(
					'name'=>'生成日時',
					'row_order'=>'BulkMake.created',
					'clm_show'=>0,
			),
			'modified'=>array(
					'name'=>'更新日時',
					'row_order'=>'BulkMake.modified',
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
	 * フィールドデータ読取処理 | AJAX
	 */
	public function read_field_data(){
		$this->autoRender = false;//ビュー(ctp)を使わない。
		
		$data_json = $_POST['data_json'];
		$mission_json = $_POST['mission_json'];
		$option_json = $_POST['option_json'];
		
		$fieldData = json_decode($data_json,true);
		$mission = json_decode($mission_json,true);
		$option = json_decode($option_json,true);
		$to_db_name = $mission['to_db_name']; // 複製先DB名 
		$to_tbl_name = $mission['to_tbl_name']; // 複製先テーブル名
		$mission_id = $mission['id']; // 任務ID
		
		// 複製先のDBに切り替える
		App::uses('OuterDb','Model');
		$this->OuterDb=ClassRegistry::init('OuterDb');
		$rs = $this->OuterDb->changeDbName($to_db_name); // DB変更する。
		if ($rs == false) return "DB change fail!";

		// 複製先DBのテーブルからフィールドデータを取得する
		$sql = "SHOW FULL COLUMNS FROM {$to_tbl_name}";
		$fieldData2 = $this->OuterDb->query($sql);
		
		$rs = $this->OuterDb->changeDbName('crud_base_bulk'); // DBを元に戻す

		// フィールドデータを一括作成用に変換する
		$fieldData = $this->BulkMake->convFieldDataForBulkMake($fieldData,$fieldData2,$mission_id,$option);

		// フィールドデータを一括作成テーブルへ保存する
		$this->BulkMake->saveFieldData($fieldData);
		
		// フィールドデータをJSON化して保存
		$field_json = json_encode($fieldData,JSON_HEX_TAG | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_APOS);
		

		return $field_json;
	}
	
	
	/**
	 * 一括作成実行 | AJAX
	 */
	public function exe_bulk_make(){
		$this->autoRender = false;//ビュー(ctp)を使わない。
		
		$data_json = $_POST['data_json'];
		$mission_json = $_POST['mission_json'];
		$option_json = $_POST['option_json'];
		
		$fieldData = json_decode($data_json,true);
		$mission = json_decode($mission_json,true);
		$option = json_decode($option_json,true);
		$to_db_name = $mission['to_db_name']; // 複製先DB名
		$to_tbl_name = $mission['to_tbl_name']; // 複製先テーブル名
		$mission_id = $mission['id']; // 任務ID
		
		
		
		$hina_file_id = $mission['hina_file_id']; // 雛ファイルID
		$from_scr_code = $mission['from_scr_code']; // 複製元コード
		$to_scr_code = $mission['to_scr_code']; // 複製先コード
		$from_path = $mission['from_path']; // 複製元パス
		$to_path = $mission['to_path']; // 複製先パス
		
		// 複製元と複製先のファイルパスを取得してデータにセットする
 		$hinaFiles = $this->BulkMake->getGHinaFiles($hina_file_id);// 雛ファイルIDから雛ファイルリストを取得する
 		
		// 複製元ファイルパスおよび複製先ファイルパスを雛ファイルリストとコードから作成し、データにセットする。
 		$fromFps = $this->BulkMake->makeFilePath($hinaFiles,$from_scr_code,$from_path);
 		$toFps = $this->BulkMake->makeFilePath($hinaFiles,$to_scr_code,$to_path);

		// 複製元ファイルからソースコードを読み取り、データにセットする。
 		$scrTexts = $this->BulkMake->readScrText($fromFps);
 		
 		// ソースコードのコード（キャメルとスネーク）と和名を置換する。
 		$scrTexts = $this->BulkMake->replaceCodes($scrTexts,$mission);
 		
 		// フィールドソースコードに置換する
 		$scrTexts = $this->BulkMake->replaceFieldScr($scrTexts,$fieldData);
 		
 		// ソースコードテキストリストを出力
 		$this->BulkMake->outputScrTexts($scrTexts,$toFps);

		$res = array('success');
		
		// フィールドデータをJSON化して保存
		$field_json = json_encode($res,JSON_HEX_TAG | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_APOS);
		
		
		return $field_json;
	}
	
	
	
	
	
	
	
	
	
	
	
	

}