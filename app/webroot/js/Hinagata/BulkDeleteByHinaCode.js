/**
 * 雛型コード・一括削除
 * @since 2023-10-2
 * @version 1.0.0
*/
class BulkDeleteByHinaCode{
	
	/**
	* コンストラクタ
	* @param {}
	*/
	constructor(param){
		
		if(param == null) param = {};
		if(param.main_slt == null) throw new Error('システムエラー:BulkDeleteByHinaCode:2023100209C');
		
		// HTMLを生成し、メイン要素にセットする。
		let html = this._createHtml(); 
		this.jqMain = jQuery(param.main_slt);
		this.jqMain.html(html);

		this.jqForm = this.jqMain.find('#bdel_form'); // フォーム要素
		this.jqErr = this.jqMain.find('#bdel_err'); // エラー要素
		this.jqSuccess = this.jqMain.find('#bdel_success'); // 成功要素
		
		
		this.jqExeBtn = this.jqMain.find('#bdel_exe_btn'); // 実行ボタン要素
		this.jqExeBtn.click((evt)=>{
			this._exeAction(); // 実行ボタン押下アクション
		});
		
		
		// 表示ボタン要素にイベントを組み込む
		this.jqShowBtn = this.jqMain.find('#bdel_show_btn');
		this.jqShowBtn.click((evt)=>{
			this.jqForm.toggle(300);
		});
		
		
		this.param = param;

	}
	
	
	// HTMLを生成する
	_createHtml(){
		
		let html = `
			<button id='bdel_show_btn' type="button" class="btn btn-default btn-xs">一括削除</button>
			<div id="bdel_form" style='margin:5px;padding:12px;border-radius:5px;background-color:#fc8b7e;display:none'>
				<br>
				<h4>雛型コード・一括削除</h4
				<table>
					<tbody>
						<tr><td>削除する雛型コード</td><td><input id='bdel_hina_code' type='text' value='test' class='form-control' style="width:8em" ></td></tr>
						<tr><td colspan="2">
							<label class="radio-inline">
							  <input type="radio" name="bdel_del_type" value="delete_flg_on" checked> 削除フラグON
							</label><br>
							<label class="radio-inline">
							  <input type="radio" name="bdel_del_type" value="delete_flg_off"> 削除取消
							</label><br>
							<label class="radio-inline">
							  <input type="radio" name="bdel_del_type" value="destroy"> DBから完全削除
							</label><br>
						</td></tr>
						<tr><td><button id='bdel_exe_btn' type='button' class='btn btn-primary'>実行</button></td><td></td></tr>
						<tr><td colspan="2"><span id="bdel_err" class="text-danger"></span></td></tr>
						<tr><td colspan="2"><span id="bdel_success" class="text-success"></span></td></tr>
					</tbody>
				</table>
			</div>
		`;
		
		return html;
	}
	
	// 実行ボタン押下アクション
	_exeAction(){
		this.jqErr.html('');
		this.jqSuccess.html('');

		// フォームからデータを取得する
		let hina_code = this.jqForm.find('#bdel_hina_code').val();
		let del_type = this.jqForm.find('input[name="bdel_del_type"]:checked').val();
		
		// 未入力チェック
		if(this._empty(hina_code) || this._empty(del_type)){
			this.jqErr.html('未入力の項目があります。');
			return;
		}
		
		// トリミング
		hina_code = hina_code.trim();

		// Ajax通信で送信するデータ
		let sendData={
			hina_code:hina_code,
			del_type:del_type,
		};
		
		// データ中の「&」と「%」を全角の＆と％に一括エスケープ(&記号や%記号はPHPのJSONデコードでエラーになる)
		sendData = this._escapeAjaxSendData(sendData);

		let fd = new FormData();
		
		let send_json = JSON.stringify(sendData);//データをJSON文字列にする。
		fd.append( "key1", send_json );
		
		let ajax_url = "hinagata/bulkDeleteByHinaCode";
		
		// AJAX
		jQuery.ajax({
			type: "post",
			url: ajax_url,
			data: fd,
			cache: false,
			dataType: "text",
			processData: false,
			contentType : false,
		})
		.done((res_json, type) => {
			let res;
			try{
				res =jQuery.parseJSON(res_json);//パース
			}catch(e){
				jQuery("#err").append(res_json);
				return;
			}
			
			switch (res.del_type){
				case 'delete_flg_on' : // 削除フラグON
					this.jqSuccess.html('削除しました。');
					break;
				case 'delete_flg_off' : // 削除フラグOFF
					this.jqSuccess.html('削除を取消ました。');
					break;
				case 'destroy' : // DBから完全削除
					this.jqSuccess.html('DBから完全抹消しました。');
					break;
				default:
					this.jqSuccess.html('エラー');
					throw new Error('res.del_type is empty!');
			}

			
		})
		.fail((jqXHR, statusText, errorThrown) => {
			let errElm = jQuery('#err');
			errElm.append('アクセスエラー');
			errElm.append(jqXHR.responseText);
			alert(statusText);
		});
		
		
		
	}


	// Check empty.
	_empty(v){
		if(v == null || v == '' || v=='0'){
			return true;
		}else{
			if(typeof v == 'object'){
				if(Object.keys(v).length == 0){
					return true;
				}
			}
			return false;
		}
	}
	
	
	/**
	 * データ中の「&」と「%」を全角の＆と％に一括エスケープ
	 * 
	 * @note
	 * PHPのJSONデコードでエラーになるので、＆記号をエスケープ。％記号も後ろに数値がつくとエラーになるのでエスケープ
	 * これらの記号はMySQLのインポートなどでエラーになる場合があるのでその予防。
	 * @param mixed data エスケープ対象 :文字列、オブジェクト、配列を指定可
	 * @returns エスケープ後
	 */
	_escapeAjaxSendData(data){
		if (typeof data == 'string'){
			data = data.replace(/&/g, '＆');
			data = data.replace(/%/g, '％');
			return data;

		}else if (typeof data == 'object'){
			for(var i in data){
				data[i] = this._escapeAjaxSendData(data[i]);
			}
			return data;
		}else{
			return data;
		}
	}
	
	
	/**
	 * Ajax送信データ用エスケープ。実体参照（&lt; &gt; &amp; &）を記号に戻す。
	 * 
	 * @param any data エスケープ対象 :文字列、オブジェクト、配列を指定可
	 * @returns エスケープ後
	 */
	_escapeForAjax(data){
		if (typeof data == 'string'){
			if ( data.indexOf('&') != -1) {
				data = data.replace(/&lt;/g,'<').replace(/&gt;/g,'>').replace(/&amp;/g,'&');
				return encodeURIComponent(data);
			}else{
				return data;
			}
		}else if (typeof data == 'object'){
			for(var i in data){
				data[i] = _escapeForAjax(data[i]);
			}
			return data;
		}else{
			return data;
		}
	}
	
	/**
	 * データ中の「&」と「%」を一括エスケープ
	 * @note
	 * PHPのJSONデコードでエラーになるので、＆記号をエスケープ。％記号も後ろに数値がつくとエラーになるのでエスケープ
	 * 
	 * @param mixed data エスケープ対象 :文字列、オブジェクト、配列を指定可
	 * @returns エスケープ後
	 */
	_ampTo26(data){
		if (typeof data == 'string'){
			if ( data.indexOf('&') != -1) {
				return data.replace(/&/g, '%26');
			}else if(data.indexOf('%') != -1){
				return data.replace(/%/g, '%25');;
			}else{
				return data;
			}
		}else if (typeof data == 'object'){
			for(var i in data){
				data[i] = _ampTo26(data[i]);
			}
			return data;
		}else{
			return data;
		}
	}

}