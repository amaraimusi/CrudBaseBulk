

$(function() {
	init();//初期化
});


var crudBase;//AjaxによるCRUD
var pwms; // ProcessWithMultiSelection.js | 一覧のチェックボックス複数選択による一括処理

/**
 *  一括作成画面の初期化
 * 
  * ◇主に以下の処理を行う。
 * - 日付系の検索入力フォームにJQueryカレンダーを組み込む
 * - 列表示切替機能の組み込み
 * - 数値範囲系の検索入力フォームに数値範囲入力スライダーを組み込む
 * 
 * @version 1.2
 * @date 2015-9-16 | 2016-12-14
 * @author k-uehara
 */
function init(){
	
	// 検索条件情報を取得する
	var kjs_json = jQuery('#kjs_json').val();
	var kjs = jQuery.parseJSON(kjs_json);
	
	//AjaxによるCRUD
	crudBase = new CrudBase({
			'src_code':'bulk_make', // 画面コード（スネーク記法)
			'kjs':kjs,
		});
	
	// タイプAリストJSON
	var type_a_json = jQuery('#type_a_json').val();
	var typeAList = JSON.parse(type_a_json);

	// 表示フィルターデータの定義とセット
	var disFilData = {
			'type_a':{
				'fil_type':'select',
				'option':{'list':typeAList}
			},
			'delete_flg':{
				'fil_type':'delete_flg',
			},
			
	};
	crudBase.setDisplayFilterData(disFilData);

	//列並替変更フラグがON（列並べ替え実行）なら列表示切替情報をリセットする。
	if(localStorage.getItem('clm_sort_chg_flg') == 1){
		this.crudBase.csh.reset();//列表示切替情報をリセット
		localStorage.removeItem('clm_sort_chg_flg');
	}

	// 一覧のチェックボックス複数選択による一括処理
	pwms = new ProcessWithMultiSelection({
		'tbl_slt':'#bulk_make_tbl',
		'ajax_url':'bulk_make/ajax_pwms',
			});

	// 新規入力フォームのinput要素にEnterキー押下イベントを組み込む。
	$('#ajax_crud_new_inp_form input').keypress(function(e){
		if(e.which==13){ // Enterキーである場合
			newInpReg(); // 登録処理
		}
	});
	
	// 編集フォームのinput要素にEnterキー押下イベントを組み込む。
	$('#ajax_crud_edit_form input').keypress(function(e){
		if(e.which==13){ // Enterキーである場合
			editReg(); // 登録処理
		}
	});
	
	

	
	// ■■■□□□■■■□□□■■■□□□■■■
//	// CSVインポートの初期化  <CrudBase/index.js>
//	initCsvImportFu('bulk_make/csv_fu');
	
}

/**
 * 新規入力フォームを表示
 * @param btnElm ボタン要素
 */
function newInpShow(btnElm){
	crudBase.newInpShow(btnElm);
}

/**
 * 編集フォームを表示
 * @param btnElm ボタン要素
 */
function editShow(btnElm){
	crudBase.editShow(btnElm);
}

/**
 * 複製フォームを表示（新規入力フォームと同じ）
 * @param btnElm ボタン要素
 */
function copyShow(btnElm){
	crudBase.copyShow(btnElm);
}


/**
 * 削除アクション
 * @param btnElm ボタン要素
 */
function deleteAction(btnElm){
	crudBase.deleteAction(btnElm);
}


/**
 * 有効アクション
 * @param btnElm ボタン要素
 */
function enabledAction(btnElm){
	crudBase.enabledAction(btnElm);
}


/**
 * 抹消フォーム表示
 * @param btnElm ボタン要素
 */
function eliminateShow(btnElm){
	crudBase.eliminateShow(btnElm);
}

/**
 * 詳細検索フォーム表示切替
 * 
 * 詳細ボタンを押した時に、実行される関数で、詳細検索フォームなどを表示します。
 */
function show_kj_detail(){
	$("#kjs2").fadeToggle();
}

/**
 * フォームを閉じる
 * @parma string form_type new_inp:新規入力 edit:編集 delete:削除
 */
function closeForm(form_type){
	crudBase.closeForm(form_type)
}



/**
 * 検索条件をリセット
 * 
 * すべての検索条件入力フォームの値をデフォルトに戻します。
 * リセット対象外を指定することも可能です。
 * @param array exempts リセット対象外フィールド配列（省略可）
 */
function resetKjs(exempts){
	
	crudBase.resetKjs(exempts);
	
}




/**
 * 列並替画面に遷移する
 */
function moveClmSorter(){
	
	//列並替画面に遷移する <CrudBase:index.js>
	moveClmSorterBase('bulk_make');
	
}








/**
 * 新規入力フォームの登録ボタンアクション
 */
function newInpReg(){
	crudBase.newInpReg(null,null);
}

/**
 * 編集フォームの登録ボタンアクション
 */
function editReg(){
	crudBase.editReg(null,null);
}

/**
 * 削除フォームの削除ボタンアクション
 */
function deleteReg(){
	crudBase.deleteReg();
}

/**
 * 抹消フォームの抹消ボタンアクション
 */
function eliminateReg(){
	crudBase.eliminateReg();
}


/**
 * リアクティブ機能：TRからDIVへ反映
 * @param div_slt DIV要素のセレクタ
 */
function trToDiv(div_slt){
	crudBase.trToDiv(div_slt);
}

/**
 * 行入替機能のフォームを表示
 * @param btnElm ボタン要素
 */
function rowExchangeShowForm(btnElm){
	crudBase.rowExchangeShowForm(btnElm);
}

/**
 * 自動保存の依頼をする
 * 
 * @note
 * バックグランドでHTMLテーブルのデータをすべてDBへ保存する。
 * 二重処理を防止するメカニズムあり。
 */
function saveRequest(){
	crudBase.saveRequest();
}


/**
 * セッションをクリアする
 * 
 * @note
 * ついでに列表示切替機能も初期化する
 * 
 */
function session_clear(){
	
	// 列表示切替機能を初期化
	crudBase.csh.reset();
	
	location.href = '?ini=1&sc=1';
}



/**
 * フィールドデータ読取AJAX
 */
function readFieldData(){

	var data_json = jQuery('#data_json').val();
	var mission_json = jQuery('#mission_json').val();
	
	// オプション情報を取得する
	var parElm = jQuery('#read_fd');
	var type_a_over = parElm.find('#type_a_over:checked').val(); // タイプA上書きフラグ
	if(type_a_over == null) type_a_over = 0;
	var option = {'type_a_over':type_a_over};
	var option_json = JSON.stringify(option);

	var data_str = 
		'data_json=' + data_json + 
		'&mission_json=' + mission_json +
		'&option_json=' + option_json;
	
	// AJAX
	jQuery.ajax({
		type: "POST",
		url: "bulk_make/read_field_data",
		data: data_str ,
		cache: false,
		dataType: "text",
	})
	.done(function(str_json, type) {
		var ent;
		try{
			ent =jQuery.parseJSON(str_json);//パース
			location.reload(true);// パースに成功したらリロード
		}catch(e){
			jQuery("#err").html(str_json);
			return;
		}
	})
	.fail(function(jqXHR, statusText, errorThrown) {
		jQuery('#err').html(jqXHR.responseText);
		alert(statusText);
	});
	
}


/**
 * 一括作成実行
 * 
 */
function exeBulkMake(){
	

	var data_json = jQuery('#data_json').val();
	var mission_json = jQuery('#mission_json').val();
	
	// オプション情報を取得する
	var parElm = jQuery('#read_fd');
	var file_over = parElm.find('#file_over:checked').val(); // タイプA上書きフラグ
	if(file_over == null) file_over = 0;
	var option = {'file_over':file_over};
	var option_json = JSON.stringify(option);

	var data_str = 
		'data_json=' + data_json + 
		'&mission_json=' + mission_json +
		'&option_json=' + option_json;
	
	// AJAX
	jQuery.ajax({
		type: "POST",
		url: "bulk_make/exe_bulk_make",
		data: data_str ,
		cache: false,
		dataType: "text",
	})
	.done(function(str_json, type) {
		var ent;
		try{
			ent =jQuery.parseJSON(str_json);//パース
			location.reload(true);// パースに成功したらリロード
		}catch(e){
			jQuery("#exe_bulk_make_err").html(str_json);
			return;
		}
	})
	.fail(function(jqXHR, statusText, errorThrown) {
		jQuery('#exe_bulk_make_err').html(jqXHR.responseText);
		alert(statusText);
	});
}












