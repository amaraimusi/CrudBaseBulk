<?php
App::uses('AppController', 'Controller');

/**
 * CRUD系画面用の基本クラス
 * 
 * CRUD系のコントローラはこちらを継承することにより、検索条件、ページネーション、ソートなどの開発が簡易になります。。
 * 
 *
 */
class CrudBaseController extends AppController {

	///バージョン
	var $version = "2.3.0";

	///デフォルトの並び替え対象フィールド
	var $defSortFeild='sort_no';

	///デフォルトソートタイプ
	var $defSortType=0;//0:昇順 1:降順

	///検索条件のセッション保存フラグ
	public $kj_session_flg = false;

	///検索条件定義（要,オーバーライド）
	public $kensakuJoken=array();

	///検索条件のバリデーション（要,オーバーライド）
	public $kjs_validate = array();

	///フィールドデータ（要、オーバーライド）
	public $field_data = array();

	///一覧列情報(ソート機能付	 $field_dataの簡易版）
	public $table_fields=array();

	///編集エンティティ定義（要,オーバーライド）
	public $entity_info=array();

	///編集用バリデーション（要,オーバーライド）
	public $edit_validate = array();

	///巨大データ判定行数
	public $big_data_limit=501;

	//巨大データフィールド
	public $big_data_fields = array();
	
	// 当ページバージョン（各ページでオーバーライドすること)
	public $this_page_version = '1.0';
	
	// バージョン情報
	public $verInfo = array();

	// -- ▽ 内部処理用
	private $m_kj_keys;//検索条件キーリスト
	private $m_kj_defs;//検索条件デフォルト値
	private $m_edit_keys;//編集エンティティキーリスト
	private $m_edit_defs;//編集エンティティのデフォルト値
	private $main_model_name=null;//対応付けるモデルの名称。（例→AnimalX)
	private $main_model_name_s=null;//モデル名のスネーク記法番(例→animal_x)

	/**
	 * indexアクションの共通処理
	 *
	 * 検索条件情報の取得、入力エラー、ページネーションなどの情報を取得します。
	 * このメソッドはindexアクションの冒頭部分で呼び出されます。
	 * @param string $name 	対応するモデル名（キャメル記法）
	 * @param array $request 	HTTPリクエスト
	 * @return array
	 * - kjs <array> 検索条件情報
	 * - errMsg <string> 検索条件入力のエラーメッセージ
	 * - pages <array> ページネーション情報
	 * - saveKjFlg <bool> 検索条件保存フラグ。true:検索条件を保存する, false:保存しない
	 * - bigDataFlg <bool> true:一覧データ件数が500件を超える,false:500件以下。500件の制限はオーバーライドで変更可能。
	 *
	 */
	protected function indexBefore($name,$request=null){
	    

		if(empty($request)) $request = $this->request->data;

		$this->MainModel=ClassRegistry::init($name);
		$this->main_model_name=$name;
		$this->main_model_name_s=$this->snakize($name);

		// POSTデータを取得
		$postData = null;
		if(isset($this->request->data[$name])){
			$postData = $this->request->data[$name];
		}

		// アクションを判定してアクション種別を取得する（0:初期表示、1:検索ボタン、2:ページネーション、3:ソート）
		$actionType = $this->judgActionType();

		//▽検索入力保存フラグの処理
		$saveKjFlg = $this->kj_session_flg;
		

		
 		// 新バージョンであるかチェック。新バージョンである場合セッションクリアを行う。２回目のリクエスト（画面表示）から新バージョンではなくなる。
		$new_version_chg = 0; // 新バージョン変更フラグ: 0:通常  ,  1:新バージョンに変更
		$system_version = $this->checkNewPageVersion($this->this_page_version);

		if(!empty($system_version)){
			$new_version_chg = 1;
			$this->sessionClear();
		}
		//URLクエリ（GET)にセッションクリアフラグが付加されている場合、当画面に関連するセッションをすべてクリアする。
		if(!empty($this->request->query['sc'])){
			$this->sessionClear();
		}
		

		//URLクエリ（GET)から初期フラグを取得する。
		$iniFlg=0;
		if(!empty($this->request->query['ini'])){
			$iniFlg=$this->request->query['ini'];
		}

		//URLクエリ（GET)からCRUDタイプを取得する
		$crudType = 0; // 0:AjaxCrud.js型   1:submit型
		if(!empty($this->request->query['crud_type'])){
			$crudType = $this->request->query['crud_type'];
		}

		//巨大データフィールドデータを取得
		$big_data_fields = $this->big_data_fields;

		//フィールドデータが画面コントローラで定義されている場合、以下の処理を行う。
		if(!empty($this->field_data)){
			$res=$this->exe_field_data($this->field_data,$this->main_model_name_s);//フィールドデータに関する処理
			$this->table_fields=$res['table_fields'];
			$this->field_data=$res['field_data'];

		}

		//フィールドデータから列表示配列を取得
		$csh_ary = $this->exstractClmShowHideArray($this->field_data);
		$csh_json=json_encode($csh_ary);

		//サニタイズクラスをインポート
		App::uses('Sanitize', 'Utility');

		//検索条件情報をPOST,GET,SESSION,デフォルトのいずれから取得。
		$kjs=$this->getKjs($name,$saveKjFlg);

		//SQLインジェクション対策
		foreach($kjs as $i => $kj){
			if(!empty($kj)){
				$kjs[$i] = str_replace("'", '\'', $kj);
			}
		}

		//パラメータのバリデーション
		$errMsg=$this->valid($kjs,$this->kjs_validate);

		//入力エラーがあった場合。
		if(isset($errMsg)){
			//再表示用の検索条件情報をSESSION,あるいはデフォルトからパラメータを取得する。
			$kjs= $this->getKjsSD($name,$saveKjFlg);
		}
		
		//検索ボタンが押された場合
		$pages=array();
		if(!empty($request['search'])){
		    
		    //ページネーションパラメータを取得
		    $pages = $this->getPageParamForSubmit($kjs,$postData,$saveKjFlg);

		}else{
		    //ページネーション用パラメータを取得
		    $overData['row_limit']=$kjs['row_limit'];
		    $pages=$this->getPageParam($saveKjFlg,$overData);
		    
		}

		$bigDataFlg=$this->checkBigDataFlg($kjs);//巨大データ判定

		//巨大データフィールドデータを取得
		$big_data_fields = $this->big_data_fields;

		//フィールドデータが定義されており、巨大データと判定された場合、巨大フィールドデータの再ソートをする。（列並替に対応）
		if(!empty($this->field_data) && $bigDataFlg ==true){

			//巨大データフィールドを列並替に合わせて再ソートする。
			$big_data_fields = $this->sortBigDataFields($big_data_fields,$this->field_data['active']);

		}

		$def_kjs_json=$this->getDefKjsJson();// 検索条件情報からデフォルト検索情報JSONを取得する

		$debug_mode=Configure::read('debug');//デバッグモードを取得

		//アクティブフィールドデータを取得
		$active = array();
		if(!empty($this->field_data['active'])){
			$active = $this->field_data['active'];
		}

		// ユーザー情報を取得する
		$userInfo = $this->getUserInfo();
		
		// アクティブフラグをリクエストから取得する
		$act_flg = $this->getValueFromPostGet('act_flg');
		
		$kjs_json = json_encode($kjs,JSON_HEX_TAG | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_APOS);

		
		
		// セッションへセット（CSVエクスポートで利用）
		$this->Session->write($this->main_model_name_s.'_kjs',$kjs);
		
		//$crudBaseData['']
		$crudBaseData = array(
		    'field_data'=>$active, // アクティブフィールドデータ
		    'kjs'=>$kjs, // 検索条件情報
		    'kjs_json'=>$kjs_json, // 検索条件JSON
		    'def_kjs_json'=>$def_kjs_json, // デフォルト検索情報JSON
		    'errMsg'=>$errMsg, // エラーメッセージ
		    'version'=>$this->version, // CrudBaseのバージョン
		    'userInfo'=>$userInfo, // ユーザー情報
		    'new_version_chg'=>$new_version_chg, // 新バージョン変更フラグ: 0:通常  ,  1:新バージョンに変更
		    'debug_mode'=>$debug_mode, // デバッグモード    CakePHPのデバッグモードと同じもの
		    'csh_ary'=>$csh_ary, // 列表示配列    列表示切替機能用
		    'csh_json'=>$csh_json, // 列表示配列JSON     列表示切替機能用
		    'bigDataFlg'=>$bigDataFlg, // 巨大データフラグ    画面に表示する行数が制限数（$big_data_limit）を超えるとONになる。
		    'big_data_fields'=>$big_data_fields, // 巨大データ用のフィールド情報 (高速化のため列の種類は少なめ）
		    'pages'=>$pages, // ページネーションパラメータ
		    'act_flg'=>$act_flg, // アクティブフラグ    null:初期表示 , 1:検索アクション , 2:ページネーションアクション , 3:列ソートアクション
		    'crudType'=>$crudType, // CRUDタイプ 0:AjaxCrud.js型   1:submit型
		    'iniFlg'=>$iniFlg, // 初期フラグ（非推奨）    URLクエリで指定する初期状態を表すフラグ
		    'saveKjFlg'=>$saveKjFlg, // 検索条件保存フラグ（非推奨）
		);
		
		return $crudBaseData;
	}


	/**
	 * アクション種別を取得する
	 * @return int アクション種別   0:初期表示、1:検索ボタン、2:ページネーション、3:ソート
	 */
	private function judgActionType(){

		$postData = $this->request->data;
		$getData = $this->request->query;

		$post_flg =false;
		if($postData){
			$post_flg = true;
		}

		$get_flg = false;
		if($getData){
			$get_flg = true;
		}

		$actionType = null;

		if($post_flg == true && $get_flg == true){
			$actionType = 1 ; // 検索ボタンアクション

		}else if($post_flg == true && $get_flg == false){
			$actionType = 1 ; // 検索ボタンアクション

		}else if($post_flg == false && $get_flg == true){

			// GETのパラメータを判定してアクション種別を取得する
			$actionType = $this->judgActionTypeByGet($getData);

		}else if($post_flg == false && $get_flg == false){
			$actionType = 0 ; // 初期表示アクション

		}

		return $actionType;
	}

	/**
	 * GETのパラメータを判定してアクション種別を取得する
	 * @param array $getData GETリクエストのパラメータ
	 * @return int アクション種別  0:初期表示、 2:ページネーション、 3:ソート
	 */
	private function judgActionTypeByGet($getData){

		// GETパラメータにkj_○○というフィールドが存在したらアクション種別は「初期表示」と判定する
		foreach($getData as $key => $dummy){
			$s3 =mb_substr($key,0,3);
			if($s3 == 'kj_'){
				return 0; // 初期表示
			}
		}

		// ソートアクションの判定
		if(isset($getData['page_no']) && isset($getData['row_limit']) && isset($getData['sort_field'])){
			return 3; // ソート
		}

		// ページネーションアクションの判定
		else if(isset($getData['page_no']) && isset($getData['row_limit']) && !isset($getData['sort_field'])){
			return 2; // ページネーション・アクション
		}

		return 0; // その他は初期表示
	}

	/**
	 * 検索入力保存フラグの判定、取得、セッション更新を行う。
	 * @param array $postData POSTリクエストのデータ
	 * @param int $actionType アクション種別  0:初期表示、1:検索ボタン、2:ページネーション、3:ソート
	 * @param string $name モデル名
	 * @return bool 検索入力保存フラグ
	 */
	private function judeSessionFlg($postData,$actionType,$name){

		// KJセッション保存フラグ(検索条件セッション保存フラグ）をメンバから取得
		$saveKjFlg = $this->kj_session_flg;

		// フォーム・KSFを取得
		$f_saveKjFlg = null;
		if(isset($postData)){
			if(isset($postData['saveKjFlg'])){
				$f_saveKjFlg = $postData['saveKjFlg'];
			}
		}
		if(!isset($f_saveKjFlg)){
			if(isset($this->request->query['saveKjFlg'])){
				$f_saveKjFlg=$this->request->query['saveKjFlg'];
			}
		}

		// セッション・KSFを取得
		$s_saveKjFlg=$this->Session->read($this->main_model_name_s.'_saveKjFlg');

		// フォームKSF = 有
		if(isset($f_saveKjFlg)){

			// フォームからの値をKJセッション保存フラグにセットする。
			$saveKjFlg = $f_saveKjFlg;
			$s_saveKjFlg = $saveKjFlg;

		}

		// フォームKSF = 空
		else{
			// 	セッションKSF=有
			if(isset($s_saveKjFlg)){

				// 初期表示アクション
				if($actionType == 0){
					if($this->kj_session_flg==true){
						$saveKjFlg = $s_saveKjFlg;
					}

				}

				// 検索アクション
				else if($actionType == 1){
					if($this->kj_session_flg==true){
						$saveKjFlg = $s_saveKjFlg;
					}

				}

				// ページネーション・アクション
				else if($actionType == 2){
					$saveKjFlg = true;
				}

				// ソート
				else if($actionType == 3){
					$saveKjFlg = true;
				}

			}

			// セッションKSF=空
			else{
				// なにもしない
			}

		}

		// セッションKSFを保存する
		$this->Session->write($this->main_model_name_s.'_saveKjFlg',$s_saveKjFlg);

		$skfData = array(
				'kj_session_flg' => $this->kj_session_flg,// デフォルト
				'saveKjFlg'=>$saveKjFlg,// 実質のフラグ
				'f_saveKjFlg'=>$f_saveKjFlg,// フォームからのフラグ
				's_saveKjFlg'=>$s_saveKjFlg,// セッションからのフラグ
		);

		return $skfData;

	}


	/**
	 * 当画面に関連するセッションをすべてクリアする
	 * 
	 */
	public function sessionClear(){

		$page_code = $this->main_model_name_s; // スネーク記法のページコード（モデル名）
		$pageCode = $this->main_model_name; // スネーク記法のページコード（キャメル記法）

		$fd_ses_key=$page_code.'_sorter_field_data';//フィールドデータのセッションキー
		$tf_ses_key=$page_code.'_table_fields';//一覧列情報のセッションキー
		$err_ses_key=$page_code.'_err';//入力エラー情報のセッションキー
		$page_ses_key=$pageCode.'_page_param';//ページパラメータのセッションキー
		$kjs_ses_key=$pageCode;	//検索条件情報のセッションキー
		$svkj_ses_key=$page_code.'_saveKjFlg';//検索入力保存フラグのセッションキー
		$csv_ses_key=$page_code.'_kjs';//CSV用のセッションキー
		$mains_ses_key = $page_code.'_mains_cb';//主要パラメータのセッションキー
		$ini_cnds_ses_key = $page_code.'_ini_cnds';// 初期条件データのセッションキー
		
		

		$this->Session->delete($fd_ses_key);
		$this->Session->delete($tf_ses_key);
		$this->Session->delete($err_ses_key);
		$this->Session->delete($page_ses_key);
		$this->Session->delete($kjs_ses_key);
		$this->Session->delete($svkj_ses_key);
		$this->Session->delete($csv_ses_key);
		$this->Session->delete($mains_ses_key);
		$this->Session->delete($ini_cnds_ses_key);

	}

	/**
	 * フィールドデータに関する処理
	 * 
	 * @param array $def_field_data コントローラで定義しているフィールドデータ
	 * @param string $page_code ページコード（モデル名）
	 * @return array res 
	 * - table_fields 一覧列情報
	 */
	private function exe_field_data($def_field_data,$page_code){

		//フィールドデータをセッションに保存する
		$fd_ses_key=$page_code.'_sorter_field_data';

		//一覧列情報のセッションキー
		$tf_ses_key = $page_code.'_table_fields';

		//セッションキーに紐づくフィールドデータを取得する
		$field_data=$this->Session->read($fd_ses_key);

		$table_fields=array();//一覧列情報

		//フィールドデータが空である場合
		if(empty($field_data)){

			//定義フィールドデータをフィールドデータにセットする。
			$field_data=$def_field_data;

			//defをactiveとして取得。
			$active=$field_data['def'];

			//列並番号でデータを並び替える。データ構造も変換する。
			$active=$this->CrudBase->sortAndCombine($active);
			$field_data['active']=$active;

			//セッションにフィールドデータを書き込む
			$this->Session->write($fd_ses_key,$field_data);

			//フィールドデータから一覧列情報を作成する。
			$table_fields=$this->CrudBase->makeTableFieldFromFieldData($field_data);

			//セッションに一覧列情報をセットする。
			$this->Session->write($tf_ses_key,$table_fields);

		}

		//セッションから一覧列情報を取得する。
		if(empty($table_fields)){
			$table_fields = $this->Session->read($tf_ses_key);
		}

		$res['table_fields']=$table_fields;
		$res['field_data']=$field_data;

		return $res;

	}

	/**
	 * フィールドデータから列表示配列を取得
	 * @param array $field_data フィールドデータ
	 * @return array 列表示配列
	 */
	private function exstractClmShowHideArray(&$field_data){

		$csh_ary=array();
		if(!empty($field_data)){
			$csh_ary=Hash::extract($field_data, 'active.{n}.clm_show');
		}
		return $csh_ary;
	}

	/**
	 * indexアクションの共通処理（後）
	 *
	 * @param $crudBaseData
	 * @return $crudBaseData
	 */
	protected function indexAfter(&$crudBaseData){

        // 検索データ数を取得
	    $kjs = $crudBaseData['kjs'];
		$data_count=$this->MainModel->findDataCnt($kjs); 

		//ページネーション情報を取得する
		$base_url = $this->webroot.$this->main_model_name_s; // 基本ＵＲＬ
		$pages = $crudBaseData['pages'];
		
		$this->PagenationForCake = new PagenationForCake();
		$pages = $this->PagenationForCake->createPagenationData($pages,$data_count,$base_url , null,$this->table_fields,$kjs);

		$kjs_json = json_encode($kjs,JSON_HEX_TAG | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_APOS);
		
		// ホームＵＲＬを作成する
		$home_url = $this->makeHomeUrl($crudBaseData,$pages,$base_url);
		
		// 行入替機能フラグを取得する
		$row_exc_flg = $this->getRowExcFlg($crudBaseData,$pages);

		$crudBaseData['pages'] = $pages; // ページネーション情報
		$crudBaseData['data_count'] = $data_count; // 検索データ数
		$crudBaseData['kjs_json'] = $kjs_json; // 検索条件ＪＳＯＮ
		$crudBaseData['base_url'] = $base_url; // 基本ＵＲＬ
		$crudBaseData['home_url'] = $home_url; // ホームＵＲＬ
		$crudBaseData['row_exc_flg'] = $row_exc_flg; // 行入替機能フラグ  0:行入替ボタンは非表示 , 1:表示
		

		$this->Session->write($this->main_model_name_s.'_pages',$pages);

		return $crudBaseData;
	}

	
	/**
	 * ホームＵＲＬを作成する
	 * @param array $crudBaseData
	 * @param array $pages ページネーション情報
	 * @param string $base_url 基本ＵＲＬ
	 * @return string ホームＵＲＬ
	 */
	private function makeHomeUrl(&$crudBaseData,&$pages,$base_url){

	    // 初期条件データを取得する
	    $iniCnds = $this->getIniCnds($crudBaseData,$pages);

	    //　‎初期条件データからURLを作成
	    $home_url = $this->makeHomeUrlByIniCnds($iniCnds,$base_url);

        return $home_url;

	}
	
	/**
	 * 初期条件データを取得する
	 * @param array $crudBaseData
	 * @param array $pages ページネーション情報
	 * @return array 初期条件データ
	 */
	private function getIniCnds(&$crudBaseData,&$pages){
	    
	    $iniCnds = null; // 初期条件データ
	    $ses_key = $this->main_model_name_s.'_ini_cnds';
	    
	    //アクションフラグが空である場合
	    if(empty($crudBaseData['act_flg'])){
	        
	        // 初期条件データにセットする
	        $iniCnds = array('kjs' => $crudBaseData['kjs'],'pages'=>$pages);
	        
	        // ‎セッションにデータをセット
	        $this->Session->write($ses_key,$iniCnds);
	        
	    }
	    else{
	        // 	    セッションにデータが存在する場合
	        $iniCnds = $this->Session->read($ses_key);
	        
	        if(empty($iniCnds)){
	            
	            $iniCnds = array('kjs' => $crudBaseData['kjs'],'pages'=>$pages);
	            $this->Session->write($ses_key,$iniCnds);
	        }
	        
	    }
	    
	    return $iniCnds;
	}
	
	/**
	 * 初期条件データからホームURLを作成
	 * @param array $iniCnds 初期条件データ
	 * @param string $base_url 基本ＵＲＬ
	 * @return string ホームURL
	*/
	private function makeHomeUrlByIniCnds($iniCnds,$base_url){
	    
	    $query_str = "";
	    $pages = $iniCnds['pages'];
	    $kjs = $iniCnds['kjs'];
	    
	    $list = array('page_no','sort_field','sort_desc');
	    foreach($list as $field){
	        $value = $iniCnds['pages'][$field];
	        if(!empty($value) || $value === 0){
	            $value = urlencode($value);// URLエンコード
	            $query_str .= "&{$field}={$value}";
	        }
	    }
	    
	    foreach($iniCnds['kjs'] as $field => $value){
	        if(!empty($value) || $value===0){
	            $value = urlencode($value);
	            $query_str .= "&{$field}={$value}";
	        }
	    }
	    
	    $home_url = $base_url;
	    if(!empty($query_str)){
	        $query_str = mb_substr($query_str,1); // 先頭の一文字を削る(&を削る）
	        $home_url = $home_url . '?' . $query_str;
	    }
	    
	    return $home_url;
	    
	}
	
	
	/**
	 * 行入替機能フラグを取得する
	 * @param array $crudBaseData
	 * @param array $pages ページネーション情報
	 * @return int 行入替機能フラグ 1:ボタン表示 , 0:ボタン非表示
	 */
	private function getRowExcFlg(&$crudBaseData,&$pages){
	    
	    // 初期条件データを取得する
	    $iniCnds = $this->getIniCnds($crudBaseData,$pages);
	    
        // 検索条件情報の初期データと現在データを比較する。
        $iKjs = $iniCnds['kjs']; // 初期の検索条件情報
        $aKjs = $crudBaseData['kjs']; // 現在条件情報
        foreach($aKjs as $field => $a_value){
            
            if($field == 'row_limit') continue;
            
            $i_value = null;
            if(isset($iKjs[$field])) $i_value = $iKjs[$field];
            
            // ゼロ比較
            if($this->_compare0($a_value, $i_value)){
                continue;
            }else{
                return 0;
            }

        }

        // ページネーション情報の初期データと現在データを比較する。
	    $list = ['sort_field','sort_desc'];
	    
	    $iPages = $iniCnds['pages']; // 初期のページネーション情報

	    foreach( $list as $field){
	        
	        $a_value = null;
	        if(isset($pages[$field])) $a_value = $pages[$field];
	        
	        $i_value = null;
	        if(isset($iPages[$field])) $i_value = $iPages[$field];
	        
	        // ゼロ比較
	        if($this->_compare0($a_value, $i_value)){
	            continue;
	        }else{
	            return 0;
	        }
	    }
	    
	    return 1; // 一致判定
	    
	}
	

	/**
	 * ユーザー情報を取得する
	 * 
	 * @return array ユーザー情報
	 * - ユーザー名
	 * - IPアドレス
	 * - ユーザーエージェント
	 */
	public function getUserInfo(){

		$userInfo = $this->Auth->user();
		$update_user = 'none';
		if(!empty($userInfo['username'])) $update_user = $userInfo['username'];
		$userInfo['update_user'] = $update_user;// 更新ユーザー
		
		$userInfo['ip_addr'] = $_SERVER["REMOTE_ADDR"];// IPアドレス
		$userInfo['user_agent'] = $_SERVER['HTTP_USER_AGENT']; // ユーザーエージェント

		// 権限が空であるならオペレータ扱いにする
		if(empty($userInfo['role'])){
			$userInfo['role'] = 'oparator';
		}

		// 権力データを取得してセットする
		$userInfo['authority'] = $this->getAuthority($userInfo['role']);

		return $userInfo;
	}

	/**
	 * 権限に紐づく権力エンティティを取得する
	 * @param string $role 権限
	 * @return array 権力エンティティ
	 */
	protected function getAuthority($role){

		// 権力データを取得する
		$authorityData = $this->getAuthorityData();

		$authority = array();
		if(!empty($authorityData[$role])){
			$authority = $authorityData[$role];
		}

		return $authority;
	}

	/**
	 * 権力データを取得する
	 * @return array 権力データ
	 */
	protected function getAuthorityData(){
		$data=array(
			'master'=>array(
				'name'=>'master',
				'wamei'=>'マスター',
				'level'=>41,
			),
			'developer'=>array(
				'name'=>'developer',
				'wamei'=>'開発者',
				'level'=>40,
			),
			'admin'=>array(
				'name'=>'admin',
				'wamei'=>'管理者',
				'level'=>30,
			),
			'client'=>array(
				'name'=>'client',
				'wamei'=>'クライアント',
				'level'=>20,
			),
			'oparator'=>array(
				'name'=>'oparator',
				'wamei'=>'オペレータ',
				'level'=>10,
			),

		);

		return $data;
	}

	/**
	 * editアクションの共通処理
	 *
	 * エンティティ、入力エラーメッセージ、モードを取得します。
	 * エンティティはテーブルのレコードのことです。
	 * エラーメッセージは登録ボタン押下時の入力エラーメッセージです。
	 *
	 * @param $name 対象モデル名（キャメル記法）
	 * @return array
	 * - noData <bool> true:エンティティが空(※非推奨)
	 * - ent <array> エンティティ（テーブルのレコード）$this
	 * - errMsg <string> 入力エラーメッセージ
	 * - mode <string> new:新規入力モード, edit:編集モード
	 *
	 */
	protected function edit_before($name){
		$this->MainModel=ClassRegistry::init($name);
		$this->main_model_name=$name;
		$this->main_model_name_s=$this->snakize($name);

		App::uses('Sanitize', 'Utility');//インクルード

		$err=$this->Session->read($this->main_model_name_s.'_err');
		$this->Session->delete($this->main_model_name_s.'_err');
		$noData=false;
		$ent=null;
		$errMsg=null;
		$mode=null;

		//入力エラー情報が空なら通常の遷移
		if(empty($err)){

			$id=$this->getGet('id');//GETからIDを取得

			//IDがnullなら新規登録モード
			if(empty($id)){

				$ent=$this->getDefaultEntity();
				$mode='new';//モード（new:新規追加  edit:更新）

				//IDに数値がある場合、編集モード。
			}else if(is_numeric($id)){

				//IDに紐づくエンティティをDBより取得
				$ent=$this->MainModel->findEntity($id);
				$mode='edit';//モード（new:新規追加  edit:更新）

			}else{

				//数値以外は「NO DATA」表示
				$noData=true;
			}

		}

		//入力エラーによる再遷移の場合
		else{

			$ent=$err['ent'];
			$mode=$err['mode'];
			$errMsg=$err['errMsg'];

 			//エンティティには入力フォーム分のフィールドしか入っていないため、不足分のフィールドをDBから取得しマージする
 			$ent2=$this->MainModel->findEntity($ent['id']);
 			$ent=Hash::merge($ent2,$ent);

		}

		//リファラを取得
		$referer = ( !empty($this->params['url']['referer']) ) ? $this->params['url']['referer'] : null;

		$this->set(array(
				'noData'=>$noData,
				'mode'=>$mode,
				'errMsg'=>$errMsg,
				'referer'=>$referer,
		));

		$ret=array(
				'ent'=>$ent,
				'noData'=>$noData,
				'errMsg'=>$errMsg,
				'mode'=>$mode,
				'referer'=>$referer,
		);


		return $ret;

	}

	/**
	 * regアクション用の共通処理
	 *
	 * 結果エンティティとモードを取得します。
	 * 結果エンティティは登録したエンティティで、また全フィールドを持っています。
	 * @param string $name 対象モデル名
	 * @return array
	 * - ent <array> 結果エンティティ
	 * - mode <string> new:新規入力モード,edit:編集モード
	 *
	 */
	protected function reg_before($name){
		$this->MainModel=ClassRegistry::init($name);
		$this->main_model_name=$name;
		$this->main_model_name_s=$this->snakize($name);

		//リロードチェック
		if(empty($this->ReloadCheck)){
			App::uses('ReloadCheck','Vendor/Wacg');
			$this->ReloadCheck=new ReloadCheck();
		}

		if ($this->ReloadCheck->check()!=1){//1以外はリロードと判定し、一覧画面へリダイレクトする。
			return $this->redirect(array('controller' => $this->main_model_name_s, 'action' => 'index'));
		}

		App::uses('Sanitize', 'Utility');//インクルード

		$ent=$this->getEntityFromPost();

		$mode=$this->request->data[$this->main_model_name]['mode'];
		$errMsg=$this->valid($ent,$this->edit_validate);

		if(isset($errMsg)){

			//エラー情報をセッションに書き込んで、編集画面にリダイレクトで戻る。
			$err=array('mode'=>$mode,'ent'=>$ent,'errMsg'=>$errMsg);
			$this->Session->write($this->main_model_name_s.'_err',$err);
			$this->redirect(array('action' => 'edit'));

			return null;
		}

		//更新関係のパラメータをエンティティにセットする。
		$ent=$this->setUpdateInfo($ent,$mode);

		//リファラを取得
		$referer = ( !empty($this->request->data[$this->main_model_name]['referer']) ) ? $this->request->data[$this->main_model_name]['referer'] : null;

		$this->set(array(
				'mode'=>$mode,
				'referer'=>$referer,
		));

		$res = array(
				'ent'=>$ent,
				'mode'=>$mode,
				'referer'=>$referer,
				);

		return $res;


	}

	/**
	 * 編集画面へリダイレクトで戻ります。その際、入力エラーメッセージも一緒に送られます。
	 *
	 * @param string $errMsg 入力エラーメッセージ
	 * @return なし。（編集画面に遷移する）
	 */
	protected function errBackToEdit($errMsg){

		$ent=$this->getEntityFromPost();
		$mode=$this->request->data[$this->main_model_name]['mode'];

		//エラー情報をセッションに書き込んで、編集画面にリダイレクトで戻る。
		$err=array('mode'=>$mode,'ent'=>$ent,'errMsg'=>$errMsg);
		$this->Session->write($this->main_model_name_s.'_err',$err);
		$this->redirect(array('action' => 'edit'));

	}


	/**
	 * 検索条件のバリデーション
	 *
	 * 引数のデータを、バリデーション情報を元にエラーチェックを行います。
	 * その際、エラーがあれば、エラーメッセージを作成して返します。
	 *
	 * @param array $data バリデーション対象データ
	 * @param array $validate バリデーション情報
	 * @return string 正常な場合、nullを返す。異常値がある場合、エラーメッセージを返す。
	 */
	protected function valid($data,$validate){

		$errMsg=null;
		//▽バリデーション（入力チェック）を行い、正常であれば、改めて検索条件情報を取得。
		$this->MainModel->validate=$validate;

		$this->MainModel->set($data);
		if (!$this->MainModel->validates($data)){

			////入力値に異常がある場合。（エラーメッセージの出力仕組みはcake phpの仕様に従う）
			$errors=$this->MainModel->validationErrors;//入力チェックエラー情報を取得
			if(!empty($errors)){

				foreach ($errors  as  $err){

					foreach($err as $val){

						$errMsg.= $val.' ： ';

					}
				}

			}

		}

		return $errMsg;
	}

	/**
	 * POST,またはSESSION,あるいはデフォルトから検索条件情報を取得します。
	 *
	 * @param $formKey form要素のキー。通常はモデル名をキーにしているので、モデルを指定すれば良い。
	 * @param int $saveKjFlg セッション保存フラグ
	 * @return array 検索条件情報
	 */
	protected function getKjs($formKey,$saveKjFlg){

		$def=$this->getDefKjs();//デフォルトパラメータ
		$keys=$this->getKjKeys();//検索条件キーリストを取得

		$kjs=$this->getParams($keys,$formKey,$def,$saveKjFlg);

		foreach($kjs as $k=>$v){
			if(is_array($v)){
				$kjs[$k]=$v;
			}else{
				$kjs[$k]=trim($v);
			}

		}

		return $kjs;

	}


	/**
	 * 検索条件キーリストを取得
	 *
	 * 検索条件情報からname要素だけを、キーリストとして取得します。
	 * @return array 検索条件キーリスト
	 */
	protected function getKjKeys(){

		if(empty($this->m_kj_keys)){
			foreach($this->kensakuJoken as $ent){
				$this->m_kj_keys[]=$ent['name'];
			}
		}

		return $this->m_kj_keys;
	}

	/**
	 * デフォルト検索条件を取得
	 *
	 * 検索条件情報からdef要素だけを、デフォルト検索条件として取得します。
	 * @return array デフォルト検索条件
	 */
	protected function getDefKjs(){

		if(empty($this->m_kj_defs)){
			foreach($this->kensakuJoken as $ent){
				$this->m_kj_defs[$ent['name']]=$ent['def'];
			}
		}

		return $this->m_kj_defs;

	}

	/**
	 * SESSION,あるいはデフォルトから検索条件情報を取得する
	 *
	 * @param string $formKey モデル名、またはformタグのname要素
	 * @param int $saveKjFlg セッション保存フラグ
	 * @return array 検索条件情報
	 */
	protected function getKjsSD($formKey,$saveKjFlg){

		$def=$this->getDefKjs();//デフォルトパラメータ
		$keys=$this->getKjKeys();
		$kjs=$this->getParamsSD($keys,$formKey,$def,$saveKjFlg);

		return $kjs;
	}

	/**
	 * 
	 * POSTからデータを取得。ついでにサニタイズする。
	 *
	 * POSTからデータを取得する際、ついでにサニタイズします。
	 * サニタイズはSQLインジェクション対策用です。
	 *
	 * @param string $key リクエストキー
	 * @return string リクエストの値
	 * 
	 */
	protected function getPost($key){
		$v=null;
		if(isset($this->request->data[$this->main_model_name][$key])){
			$v=$this->request->data[$this->main_model_name][$key];
			//$v=Sanitize::escape($v);//SQLインジェクションのサニタイズ　// 何らかのバージョンによっては2重サニタイズになってしまう。
		}
		return $v;
	}


	/**
	 * GET情報（URLのクエリ）からページネーション情報を取得します。
	 *
	 * ページネーション情報は、ページ番号の羅列であるページ目次のほかに、ソート機能にも使われます。
	 *
	 * @param int $saveKjFlg セッション保存フラグ
	 * @param array $overData 上書きデータ
	 * @return array
	 * - page_no <int> 現在のページ番号
	 * - limit <int> 表示件数
	 * - sort_field <string> ソートする列フィールド
	 * - sort_desc <int> 並び方向。 0:昇順 1:降順
	 */
	protected function getPageParam($saveKjFlg,$overData){
		//GETよりパラメータを取得する。
		$pages=$this->params['url'];

		// 上書き
		$pages=Hash::merge($pages,$overData);

		//空ならセッションから取得する。
		if(empty($pages) && $saveKjFlg==true){
			$pages=$this->Session->read($this->main_model_name_s.'_page_param');
		}

		$defs=$this->getDefKjs();//デフォルト情報を取得

		//空ならデフォルトをセット
		if(empty($pages['page_no'])){
			$pages['page_no']=0;
		}
		if(empty($pages['row_limit'])){
			$pages['row_limit']=$defs['row_limit'];
		}
		if(empty($pages['sort_field'])){
			$pages['sort_field']=$this->defSortFeild;
		}
		if(!isset($pages['sort_desc'])){
			$pages['sort_desc']=$this->defSortType;//0:昇順 1:降順
		}

		//セッションに詰める。
		if($saveKjFlg==true){
			$this->Session->write($this->main_model_name_s.'_page_param',$pages);//セッションへの書き込み
		}

		return $pages;
	}
	

	/**
	 * サブミット時用のページネーション情報を取得
	 *
	 * GET情報（URLのクエリ）からページネーション情報を取得します。
	 * ついでにセッションへのページネーション情報を保存します。
	 * このメソッドはサブミット時の処理用です。
	 *
	 * @param array $kjs 検索条件情報。row_limitのみ利用する。
	 * @param $postData POST
	 * @param int $saveKjFlg セッション保存フラグ
	 * @return array ページネーション情報
	 * - page_no <int> ページ番号
	 * - limit <int> 表示件数
	 *
	 */
	protected function getPageParamForSubmit(&$kjs,&$postData,$saveKjFlg){
	    
        $pages =  array();
		$defs=$this->getDefKjs();//デフォルト情報を取得
		
		$pages['page_no'] = 0;
		
		if(isset($postData['row_limit'])){
		    $pages['row_limit'] = $postData['row_limit'];
		}else{
		    $pages['row_limit'] = $defs['row_limit'];;
		}
		
		if(isset($postData['sort_field'])){
		    $pages['sort_field'] = $postData['sort_field'];
		}else{
		    $pages['sort_field'] = $this->defSortFeild;;
		}
		
		if(isset($postData['sort_desc'])){
		    $pages['sort_desc'] = $postData['sort_desc'];
		}else{
		    $pages['sort_desc'] = $this->defSortType;//0:昇順 1:降順;
		}
		
		if($saveKjFlg==true){
			$this->Session->write($this->main_model_name.'_page_param',$pages);//セッションへの書き込み
		}
		return $pages;
	}

	
	

	/**
	 * SESSION,あるいはデフォルトからパラメータを取得する。
	 * @param string $keys キーリスト
	 * @param string $formKey フォームキー
	 * @param string $def デフォルトパラメータ
	 * @param bool $saveKjFlg セッション保存フラグ
	 * @return array フォームデータ
	 */
	protected function getParamsSD($keys,$formKey,$def,$saveKjFlg){

		$ses=null;
		if($saveKjFlg==true){
			$ses=$this->Session->read($formKey);
		}

		$prms=null;
		foreach($keys as $key){
			$prms[$key]=$this->getParamSD($key, $formKey,$ses,$def);
		}
		return $prms;

	}

	/**
	 * SESSION,あるいはデフォルトからパラメータを取得する。
	 *
	 * 内部処理用です。
	 *
	 */
	protected function getParamSD($key,$formKey,$ses,$def){


		$v=null;

		if(isset($ses)){
			$v=$ses[$key];
		}else{

			$v=$def[$key];
		}

		return $v;
	}


	/**
	 * POST,GET,SESSION,デフォルトのいずれかからパラメータリストを取得する
	 * @param array $keys キーリスト
	 * @param string $formKey フォームキー
	 * @param array $def デフォルトパラメータ
	 * @param int $saveKjFlg セッション保存フラグ
	 * @return array パラメータ
	 */
	protected function getParams($keys,$formKey,$def,$saveKjFlg){

		$ses=null;
		if($saveKjFlg==true){
			$ses=$this->Session->read($this->main_model_name_s.'_kjs');//セッションのパラメータを取得
		}

		$prms=null;
		foreach($keys as $key){
			$prms[$key]=$this->getParam($key, $formKey,$ses,$def);
		}

		return $prms;
	}

	/**
	 * POST,GET,SESSION,デフォルトのいずれかからパラメータを取得する。
	 * @param string $key パラメータのキー
	 * @param string $formKey フォームキー
	 * @param array $ses セッションパラメータ
	 * @param string $def デフォルトパラメータ
	 *
	 * @return array パラメータ
	 */
	protected function getParam($key,$formKey,&$ses,&$def){
		$v=null;

		//POSTからデータ取得を試みる。
		if(isset($this->request->data[$formKey][$key])){
			$v=$this->request->data[$formKey][$key];
		}

		//GETからデータ取得を試みる。
		elseif(isset($this->params['url'][$key])){
			$v=$this->params['url'][$key];
		}

		//SESSIONからデータを読み取る。
		elseif(isset($ses[$key])){
			$v=$ses[$key];
		}

		//デフォルトのパラメータをセット
		else{
			$v=$def[$key];
		}

		return $v;
	}
	
	
	/**
	 * POST、ＧＥＴの順にキーに紐づく値を探して取得する。
	 * 
	 * @param string $key キー
	 * @return string リクエスト値
	 */
	protected function getValueFromPostGet($key){
	    $value = null;

	    //POSTからデータ取得を試みる。
	    $model_name = $this->main_model_name;
	    if(isset($this->request->data[$model_name][$key])){
	        $value = $this->request->data[$model_name][$key];
	        return $value;
	    }
	    
	    //GETからデータ取得を試みる。
	    if(isset($this->params['url'][$key])){
	        $value = $this->params['url'][$key];
	        return $value;
	    }
	    
	    return $value;
	}
	
	
	/**
	 * ＧＥＴ、POSTの順にキーに紐づく値を探して取得する。
	 *
	 * @param string $key キー
	 * @return string リクエスト値
	 */
	protected function getValueFromGetPost($key){
	    $value = null;
	    
	    //GETからデータ取得を試みる。
	    if(isset($this->params['url'][$key])){
	        $value = $this->params['url'][$key];
	        return $value;
	    }
	    
	    //POSTからデータ取得を試みる。
	    $model_name = $this->main_model_name;
	    if(isset($this->request->data[$model_name][$key])){
	        $value = $this->request->data[$model_name][$key];
	        return $value;
	    }
	    
	    return $value;
	}

	/**
	 * キャメル記法に変換
	 * @param string $str スネーク記法のコード
	 * @return string キャメル記法のコード
	 */
	protected function camelize($str) {
		$str = strtr($str, '_', ' ');
		$str = ucwords($str);
		return str_replace(' ', '', $str);
	}

	/**
	 * スネーク記法に変換
	 * @param string $str キャメル記法のコード
	 * @return string スネーク記法のコード
	 */
	protected function snakize($str) {
		$str = preg_replace('/[A-Z]/', '_\0', $str);
		$str = strtolower($str);
		return ltrim($str, '_');
	}


	/**
	 * 巨大データ判定
	 * @param array $kjs 検索条件情報
	 * @return int 巨大データフラグ 0:通常データ  1:巨大データ
	 *
	 */
	private function checkBigDataFlg($kjs){

		$bigDataFlg=0;//巨大データフラグ

		//制限行数
		$row_limit=0;
		if(empty($kjs['row_limit'])){
			return $bigDataFlg;
		}else{
			$row_limit=$kjs['row_limit'];
		}

		// 制限行数が巨大データ判定行数以上である場合
		if($row_limit >= $this->big_data_limit){

			App::uses('Sanitize', 'Utility');
			$kjs = Sanitize::clean($kjs, array('encode' => false));
			
			// DBよりデータ件数を取得
			$cnt=$this->MainModel->findDataCnt($kjs);

			// データ件数が巨大データ判定行数以上である場合、巨大データフラグをONにする。
			if($cnt >= $this->big_data_limit){
				$bigDataFlg=1;
			}

		}

		return $bigDataFlg;
	}

	/**
	 * 巨大データフィールドを列並替に合わせて再ソートする
	 * 
	 * @param array $big_data_fields 巨大データフィールド
	 * @param array $active アクティブフィールドデータ
	 * @return array ソート後の巨大データフィールド
	 */
	private function sortBigDataFields($big_data_fields,$active){

		//巨大データフィールドのキーと値を入れ替えて、マッピングを作成する。
		$map = array_flip($big_data_fields);

		//巨大データフィールドを列並替に合わせて再ソートする
		$big_data_fields2 = array();
		foreach($active as $ent){
			$f = $ent['id'];
			if(isset($map[$f])){
				$big_data_fields2[] = $f;
			}
		}

		return $big_data_fields2;

	}

	/**
	 * 検索条件情報からデフォルト検索JSONを取得する
	 *
	 * @note
	 * デフォルト検索JSONはリセットボタンの処理に使われます。
	 *
	 * @param array $noResets リセット対象外フィールドリスト 省略可
	 * @return string デフォルト検索JSON
	 */
	protected function getDefKjsJson($noResets=null){

		$kjs=$this->kensakuJoken;//メンバの検索条件情報を取得

		$defKjs=Hash::combine($kjs, '{n}.name','{n}.def');//構造変換

		//リセット対象外フィールドリストが空でなければ、対象外のフィールドをはずす。
		if(!empty($noResets)){
			foreach($noResets as $noResetField){
				unset($defKjs[$noResetField]);
			}
		}

		$def_kjs_json=json_encode($defKjs);//JSON化

		return $def_kjs_json;
	}





	////////// 編集画面用 ///////////////////////


	/**
	 * POSTからデータを取得
	 *
	 * @note
	 * SQLインジェクションのサニタイズも行われます。
	 * 編集画面の内部処理用です。
	 */
	protected function getGet($key){
		$v=null;
		if(isset($this->params['url'][$key])){
			$v=$this->params['url'][$key];
			$v=Sanitize::escape($v);//SQLインジェクションのサニタイズ

		}

		return $v;
	}

	/**
	 * デフォルトエンティティを取得
	 * 
	 * @note
	 * 編集画面の内部処理用です。
	 */
	protected function getDefaultEntity(){

		if(empty($this->m_edit_defs)){
			foreach($this->entity_info as $ent){
				$this->m_edit_defs[$ent['name']]=$ent['def'];
			}
		}

		return $this->m_edit_defs;

	}

	/**
	 * 編集エンティティのキーリストを取得
	 *
	 * @note
	 * 編集画面の内部処理用です。
	 */
	protected function getKeysForEdit(){
		if(empty($this->m_edit_keys)){
			foreach($this->entity_info as $ent){
				$this->m_edit_keys[]=$ent['name'];
			}
		}

		return $this->m_edit_keys;
	}


	////////// 登録完了画面用 ///////////////////////

	/**
	 * POSTからエンティティを取得する。
	 *
	 * @note
	 * 登録完了画面の内部処理用です。
	 */
	protected function getEntityFromPost(){

		$keys=$this->getKeysForEdit();
		foreach($keys as $key){
			$v=$this->getPost($key);
			$ent[$key]=trim($v);
		}

		return $ent;
	}

	/**
	 * 更新関係のパラメータをエンティティにセット。
	 *
	 * @note
	 * 登録完了画面の内部処理用です。
	 *
	 * @param array $ent エンティティ
	 * @param string $mode モード new or edit
	 * @return array 更新関係をセットしたエンティティ
	 */
	protected function setUpdateInfo($ent,$mode){

		//更新者をセット
		$user=$this->Auth->user();
		$ent['update_user']=$user['username'];

		//更新者IPアドレスをセット
		$ent['ip_addr'] = $_SERVER["REMOTE_ADDR"];

		//新規モードであるなら作成日をセット
		if($mode=='new'){
			$ent['created']=date('Y-m-d H:i:s');
		}

		//※更新日はDBテーブルにて自動設定されているので省略

		return $ent;
	}





	/**
	 * 拡張コピー　存在しないディテクトリも自動生成
	 * 
	 * @note
	 * 日本語ファイルに対応
	 * 
	 * @param string $sourceFn コピー元ファイル名
	 * @param string $copyFn コピー先ファイル名 
	 * @param string $permission パーミッション（ファイルとフォルダの属性。デフォルトはすべて許可の777。8進数で指定する）
	 */
	protected function copyEx($sourceFn,$copyFn,$permission=0777){

		if(empty($this->CopyEx)){
			App::uses('CopyEx', 'Vendor/Wacg');
			$this->CopyEx = $this->Animal=new CopyEx();
		}

		$this->CopyEx->copy($sourceFn,$copyFn,$permission);

	}

	/**
	 * 日本語ディレクトリの存在チェック
	 * 
	 * @param string $dn ディレクトリ名
	 * @return boolean true:存在 , false:未存在
	 */
	protected function isDirEx($dn){
		$dn=mb_convert_encoding($dn,'SJIS','UTF-8');
		if (is_dir($dn)){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * パス指定によるディレクトリ作成（パーミッションをすべて許可）
	 *
	 * @note
	 * ディレクトリが既に存在しているならディレクトリを作成しない。
	 * パスに新しく作成せねばならないディレクトリ情報が複数含まれている場合でも、順次ディレクトリを作成する。
	 *
	 * @param string $path ディレクトリのパス
	 *
	 */
	protected function mkdir777($path,$sjisFlg=false){

		if(empty($this->MkdirEx)){
			App::uses('MkdirEx', 'Vendor/Wacg');
			$this->MkdirEx = new MkdirEx();
		}

		$this->MkdirEx->mkdir777($path,$sjisFlg);

	}

	// 更新ユーザーなど共通フィールドをセットする。
	protected function setCommonToEntity($ent){

		// 更新ユーザーの取得とセット
		$update_user = $this->Auth->user('username');
		$ent['update_user'] = $update_user;

		// ユーザーエージェントの取得とセット
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$user_agent = mb_substr($user_agent,0,255);
		$ent['user_agent'] = $user_agent;

		// IPアドレスの取得とセット
		$ip_addr = $_SERVER["REMOTE_ADDR"];
		$ent['ip_addr'] = $ip_addr;

		// idが空（新規入力）なら生成日をセットし、空でないなら除去
		if(empty($ent['id'])){
			$ent['created'] = date('Y-m-d H:i:s');
		}else{
			unset($ent['created']);
		}

		// 更新日時は除去（DB側にまかせる）
		unset($ent['modified']);

		return $ent;

	}

	// 更新ユーザーなど共通フィールドをデータにセットする。
	protected function setCommonToData($data){

		// 更新ユーザー
		$update_user = $this->Auth->user('username');

		// ユーザーエージェント
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$user_agent = mb_substr($user_agent,0,255);

		// IPアドレス
		$ip_addr = $_SERVER["REMOTE_ADDR"];

		// 本日
		$today = date('Y-m-d H:i:s');

		// データにセットする
		foreach($data as $i => $ent){

			$ent['update_user'] = $update_user;
			$ent['user_agent'] = $user_agent;
			$ent['ip_addr'] = $ip_addr;

			// idが空（新規入力）なら生成日をセットし、空でないなら除去
			if(empty($ent['id'])){
				$ent['created'] = $today;
			}else{
				unset($ent['created']);
			}

			// 更新日時は除去（DB側にまかせる）
			unset($ent['modified']);

			$data[$i] = $ent;
		}


		return $data;

	}



	/**
	 * 新バージョンであるかチェックする。
	 * @param string $this_page_version 当ページバージョン
	 * @return int 新バージョンフラグ  0:バージョン変更なし   1:新バージョンに変更されている
	 */
	public function checkNewPageVersion($this_page_version){

		$sesKey = $this->main_model_name_s.'_ses_page_version_cb';

		// セッションページバージョンを取得する
		$ses_page_version = $this->Session->read($sesKey);

		// セッションページバージョンがセッションに存在しない場合
		if(empty($ses_page_version)){
			// 当ページバージョンを新たにセッションに保存し、バージョン変更なしを表す"0"を返す。
			$this->Session->write($sesKey,$this_page_version);
			return 0;
		}

		// セッションページバージョンがセッションに存在する場合
		else{
		    
			// セッションページバージョンと当ページバージョンが一致する場合、バージョン変更なしを表す"0"を返す。
			if($this_page_version == $ses_page_version){
				return 0;
			}

			// セッションページバージョンと当ページバージョンが異なる場合、新バージョンによる変更を表す"1"を返す。
			else{
				$this->Session->write($sesKey,$this_page_version);
				return 1;
			}
		}
		
	}


	/**
	 * 主要パラメータをkjsにセットする。
	 * 
	 * @note
	 * kj_idなど特に主要なパラメータをセットする。
	 * 主要パラメータを単にリクエストで保持すると、常にそのパラメータを受け渡しをしなければならず不便である。
	 * 当メソッドでは、主要パラメータをセッションで保持し、リクエストで主要パラメータを保持する必要がなくなる。
	 * 
	 * @param string $mains 主要パラメータのキー。配列指定も可能。
	 * @param array $kjs 検索条件情報
	 * @param array kjs( 検索条件情報)
	 */
	protected function setMainsToKjs($mains,$kjs){

		// 配列でないなら配列化する
		if(!is_array($mains)){
			$mains = array($mains);
		}

		// 主要パラメータのセッションキー
		$sesKey = $this->main_model_name_s.'_mains_cb';

		// セッションで保持している主要パラメータ
		$sesMains = array();

		// kjsに主要パラメータをセットする。
		foreach($mains as $key){

			// kjs内のパラメータが空である場合
			if(empty($kjs[$key])){

				// セッションの主要パラメータが空ならセッションから取得
				if(empty($sesMains)){
					$sesMains = $this->Session->read($sesKey);
				}

				// セッションのパラメータをkjsにセットする
				if(!empty($sesMains[$key])){
					$kjs[$key] = $sesMains[$key];
				}

			}else{
				$sesMains[$key] = $kjs[$key];
			}
		}

		// 主要パラメータをセッションで保持する。
		$this->Session->write($sesKey,$sesMains);

		return $kjs;

	}


	/**
	 * AJAX | 一覧のチェックボックス複数選択による一括処理
	 * @return string
	 */
	public function ajax_pwms(){

		App::uses('Sanitize', 'Utility');

		$this->autoRender = false;//ビュー(ctp)を使わない。

		$json_param=$_POST['key1'];

		$param=json_decode($json_param,true);//JSON文字を配列に戻す

		// IDリストを取得する
		$ids = $param['ids'];

		// アクション種別を取得する
		$kind_no = $param['kind_no'];

		// 更新ユーザーを取得する
		$update_user = $this->Auth->user('username');

		$this->MainModel=ClassRegistry::init($this->name);

		// アクション種別ごとに処理を分岐
		switch ($kind_no){
			case 10:
				$this->MainModel->switchDeleteFlg($ids,0,$update_user); // 有効化
				break;
			case 11:
				$this->MainModel->switchDeleteFlg($ids,1,$update_user); // 削除化
				break;
			default:
				return "'kind_no' is unknown value";

		}

		return 'success';
	}


	/**
	 * アップロードファイルが存在すれば、アップロードファイル名をエンティティにセットする
	 * 
	 * @param array $files アップロードファイル情報($_FILESを指定する)
	 * @param array $ent エンティティ
	 * @param string $fnField ファイル名フィールド（複数あるときは配列指定可）
	 * @return array アップロードファイル名をセットしたエンティティ 
	 */
	protected function setUploadFileValueToEntity($files,$ent,$fnField){

		// ファイルフィールド名リストの初期セット
		$fnFields = array(); // ファイルフィールド名リスト
		if(is_array($fnField)){
			$fnFields = $fnField;
		}else{
			$fnFields[] = $fnField;
		}

		// アップロードファイル情報が空ならエンティティから該当フィールドを除去して処理抜け
		if(empty($files)){
			foreach($fnFields as $fu_key){
				unset($ent[$fu_key]);
			}

			return array(
				'ent' => $ent,
				'fuKeys' => array(),
			);
		}

		$fuKeys = array();// アップロードファイル関連のキーリスト
		foreach($fnFields as $fu_key){
			if(empty($files[$fu_key])){
				continue;
			}
			$fData = $files[$fu_key];

			if(!empty($fData["name"]) && $fData["name"] != ''){
				$fn = $fData["name"];
				$ent[$fu_key] = $fn;
				$fuKeys[] = $fu_key;
			}

			// アップロードするファイルがないなら、エンティティからアップロードファイルのフィールドを除去する。
			else{
				unset($ent[$fu_key]);
			}
		}

		$res = array(
				'ent' => $ent,
				'fuKeys' => $fuKeys,
		);

		return $res;
	}


	/**
	 * パラメータ内の指定したフィールドが数値であるかチェックする
	 * 
	 * @note
	 * リクエストパラメータ内のidなどを調べる。
	 * idにSQLインジェクションを引き起こすコードが入っていないかなどを調べる。
	 * 
	 * @param array $param リクエストパラメータ
	 * @param array $numProps 数値フィールドリスト： チェック対象のフィールドを配列で指定する
	 * @return bool 指定したフィールドに紐づくパラメータの値のうち、一つでも数値でないものがあればfalseを返す。
	 */
	protected function checkNumberParam($param,$numProps=array('id')){

		foreach($numProps as $field){
			if(!is_numeric($param[$field])){
				return false;
			}
		}
		return true;
	}

	
	
	/**
	 * 0以外の空判定
	 *
	 * @note
	 * いくつかの空値のうち、0と'0'は空と判定しない。
	 *
	 * @param $value
	 * @return int 判定結果 0:空でない , 1:空である
	 */
	protected function _empty0($value){
	    if(empty($value) && $value!==0 && $value!=='0'){
	        return 1;
	    }
	    return 0;
	}
	
	
	/**
	 *	ゼロ比較
	 *
	 * @note
	 * 比較用のカスタマイズ関数。
	 * ただし、空の値の比較は0とそれ以外の空値（null,"",falseなど）で仕様が異なる。
	 * 0とそれ以外の空値（null,"",falseなど）は不一致のみなす。
	 * 0と'0'は一致と判定する。
	 * null,'',falseのそれぞれの組み合わせは一致である。
	 * bool型のtrueは数字の1と同じ扱い。（※通常、2や3でもtrueとするが、この関数では1だけがtrue扱い）
	 * 1.0 , 1 , '1' など型が異なる数値を一致と判定する。
	 *
	 * @param $a_value
	 * @param $b_value
	 * @return bool false:不一致 , true:一致
	 */
	function _compare0($a_value,$b_value){
	    if(empty($a_value) && empty($b_value)){
	        if($a_value === 0 || $a_value === '0'){
	            if($b_value === 0 || $b_value === '0'){
	                return true;
	            }else{
	                return false;
	            }
	            
	        }else{
	            if($b_value === 0 || $b_value === '0'){
	                return false;
	            }else{
	                return true;
	            }
	            
	        }
	        
	    }else{
	        
	        if(gettype($a_value) == 'boolean'){
	            if($a_value){
	                $a_value = 1;
	            }else{
	                $a_value = 0;
	            }
	        }
	        if(gettype($b_value) == 'boolean'){
	            if($b_value){
	                $b_value = 1;
	            }else{
	                $b_value = 0;
	            }
	        }
	        
	        
	        if(is_numeric($a_value) && is_numeric($b_value)){
	            if($a_value == $b_value) return true;
	        }else{
	            if($a_value === $b_value) return true;
	            
	        }
	    }
	    
	    return false;
	}

}