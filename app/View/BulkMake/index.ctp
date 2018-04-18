<?php
$this->CrudBase->setModelName('BulkMake');

// CSSファイルのインクルード
$cssList = $this->CrudBase->getCssList();
$cssList[] = 'BulkMake/index.css';
$this->assign('css', $this->Html->css($cssList));

// JSファイルのインクルード
$jsList = $this->CrudBase->getJsList();
$jsList[] = 'BulkMake/index'; // 当画面専用JavaScript
$this->assign('script', $this->Html->script($jsList,array('charset'=>'utf-8')));

?>




<h2>一括作成</h2>

一括作成の検索閲覧および編集する画面です。<br>
<br>

<?php
	$this->Html->addCrumb("トップ",'/');
	$this->Html->addCrumb("一括作成");
	echo $this->Html->getCrumbs(" > ");
?>

<?php echo $this->element('CrudBase/crud_base_new_page_version');?>
<div id="err" class="text-danger"><?php echo $errMsg;?></div>


<!-- 検索条件入力フォーム -->
<div style="margin-top:5px">
	<?php 
		echo $this->Form->create('BulkMake', array('url' => true ));
	?>

	
	<div style="clear:both"></div>
	
	<div id="detail_div" style="display:none">
		
		<?php 
		
		// --- Start kj_input
		$this->CrudBase->inputKjText($kjs,'kj_mission_id','任務id',300);
		$this->CrudBase->inputKjText($kjs,'kj_field_name','フィールド名',300);
		$this->CrudBase->inputKjSelect($kjs,'kj_type_a','タイプA',$typeAList);
		$this->CrudBase->inputKjText($kjs,'kj_field_type','フィールド型',300);
		$this->CrudBase->inputKjText($kjs,'kj_orig_type','オリジナル型',300);
		$this->CrudBase->inputKjText($kjs,'kj_type_long','型長さ',300);
		$this->CrudBase->inputKjText($kjs,'kj_null_flg','NULLフラグ',300);
		$this->CrudBase->inputKjText($kjs,'kj_p_key_flg','主キーフラグ',300);
		$this->CrudBase->inputKjText($kjs,'kj_def_val','デフォルト値',300);
		$this->CrudBase->inputKjText($kjs,'kj_extra','補足',300);
		$this->CrudBase->inputKjText($kjs,'kj_comment','コメント',300);
		
		$this->CrudBase->inputKjId($kjs); 
		$this->CrudBase->inputKjHidden($kjs,'kj_sort_no');
		$this->CrudBase->inputKjDeleteFlg($kjs);
		echo "<div style='clear:both'></div>";
		$this->CrudBase->inputKjText($kjs,'kj_update_user','更新者',150);
		$this->CrudBase->inputKjText($kjs,'kj_ip_addr','更新IPアドレス',200);
		$this->CrudBase->inputKjCreated($kjs);
		$this->CrudBase->inputKjModified($kjs);
		echo "<div style='clear:both'></div>";
		$this->CrudBase->inputKjLimit($kjs);
		// --- End kj_input
		
		echo $this->element('CrudBase/crud_base_cmn_inp');
		
		?>

		
		
		<?php 
		
		echo $this->Form->submit('検索', array('name' => 'search','class'=>'btn btn-success','div'=>false,));
		
		echo $this->element('CrudBase/crud_base_index');
		
		$csv_dl_url = $this->html->webroot . 'bulk_make/csv_download';
		$this->CrudBase->makeCsvBtns($csv_dl_url);
		?>
	

	<div style="margin-top:40px">
		
	</div>

	</div><!-- detail_div -->

	<div id="func_btns" >
		
			<div class="line-left">
				<button type="button" onclick="$('#detail_div').toggle(300);" class="btn btn-default btn-sm">
					<span class="glyphicon glyphicon-cog"></span>
				</button>

			</div>
			
			<div class="line-middle"></div>
			
			<div class="line-right">
				<a href="<?php echo $home_url; ?>" class="btn btn-info" title="この画面を最初に表示したときの状態に戻します。（検索状態、列並べの状態を初期状態に戻します。）">
					<span class="glyphicon glyphicon-certificate"  ></span></a>
				<?php 
					// 新規入力ボタンを作成
					$newBtnOption = array(
							'scene'=>'<span class="glyphicon glyphicon-plus"></span>追加'
					);
					$this->CrudBase->newBtn($newBtnOption);
				?>

			</div>



	</div>
	<div style="clear:both"></div>
	<?php echo $this->Form->end()?>

	
</div>

<hr>

<div id="mission_info">
<strong>任務情報</strong>&nbsp;&nbsp;
任務ID:<?php echo $missionEnt['id']; ?>&nbsp;
任務名:<?php echo $missionEnt['mission_name']; ?>&nbsp;
<input type="button" value="詳細" class="btn btn-info btn-xs" onclick="jQuery('#mission_info_tbl').toggle(300)" />
<table id="mission_info_tbl" class="tbl2" style="display:none">
	<thead><tr><th>任務フィールド</th><th>値</th></tr></thead>
	<tbody>
		<tr><td>任務ID</td><td><?php echo $missionEnt['id']; ?></td></tr>
		<tr><td>任務名</td><td><?php echo $missionEnt['mission_name']; ?></td></tr>
		<tr><td>複製元パス</td><td><?php echo $missionEnt['from_path']; ?></td></tr>
		<tr><td>複製元画面コード</td><td><?php echo $missionEnt['from_scr_code']; ?></td></tr>
		<tr><td>複製元DB名</td><td><?php echo $missionEnt['from_db_name']; ?></td></tr>
		<tr><td>複製元テーブル名</td><td><?php echo $missionEnt['from_tbl_name']; ?></td></tr>
		<tr><td>複製元和名</td><td><?php echo $missionEnt['from_wamei']; ?></td></tr>
		<tr><td>複製先パス</td><td><?php echo $missionEnt['to_path']; ?></td></tr>
		<tr><td>複製先画面コード</td><td><?php echo $missionEnt['to_scr_code']; ?></td></tr>
		<tr><td>複製先DB名</td><td><?php echo $missionEnt['to_db_name']; ?></td></tr>
		<tr><td>複製先テーブル名</td><td><?php echo $missionEnt['to_tbl_name']; ?></td></tr>
		<tr><td>複製先和名</td><td><?php echo $missionEnt['to_wamei']; ?></td></tr>
	</tbody>
</table>
</div>


<hr>
<div id="read_fd">
    <input type="button" value="フィールドデータ読取" class="btn btn-success btn-lg" onclick="readFieldData()" />
    <div style="display:inline-block;padding-left:10px">
    	<label for="type_a_over"><input type="checkbox" id="type_a_over" value="1" /> タイプA上書き</label>
    </div>
</div>

<div id="total_div">
	<table><tr>
		<td>件数:<?php echo $data_count ?></td>
		<td><a href="#help_lists" class="livipage btn btn-info btn-xs" title="ヘルプ"><span class="glyphicon glyphicon-question-sign"></span></a></td>
	</tr></table>
</div>


<div style="margin-bottom:5px">
	<?php echo $pages['page_index_html'];//ページ目次 ?>
</div>



<div id="crud_base_auto_save_msg" style="height:20px;" class="text-success"></div>
<!-- 一覧テーブル -->
<table id="bulk_make_tbl" border="1"  class="table table-striped table-bordered table-condensed">

<thead>
<tr>
	<?php
	foreach($field_data as $ent){
		$row_order=$ent['row_order'];
		echo "<th class='{$ent['id']}'>{$pages['sorts'][$row_order]}</th>";
	}
	?>
	<th></th>
</tr>
</thead>
<tbody>
<?php

// td要素出力を列並モードに対応させる
$this->CrudBase->startClmSortMode($field_data);

foreach($data as $i=>$ent){

	echo "<tr id=i{$ent['id']}>";
	// --- Start field_table
	$this->CrudBase->tdId($ent,'id',array('checkbox_name'=>'pwms'));
	$this->CrudBase->tdPlain($ent,'mission_id');
	$this->CrudBase->tdPlain($ent,'field_name');
	$this->CrudBase->tdList($ent,'type_a',$typeAList);
	$this->CrudBase->tdPlain($ent,'field_type');
	$this->CrudBase->tdPlain($ent,'orig_type');
	$this->CrudBase->tdPlain($ent,'type_long');
	$this->CrudBase->tdPlain($ent,'null_flg');
	$this->CrudBase->tdPlain($ent,'p_key_flg');
	$this->CrudBase->tdPlain($ent,'def_val');
	$this->CrudBase->tdPlain($ent,'extra');
	$this->CrudBase->tdPlain($ent,'comment');
	$this->CrudBase->tdPlain($ent,'sort_no');
	$this->CrudBase->tdDeleteFlg($ent,'delete_flg');
	$this->CrudBase->tdPlain($ent,'update_user');
	$this->CrudBase->tdPlain($ent,'ip_addr');
	$this->CrudBase->tdPlain($ent,'created');
	$this->CrudBase->tdPlain($ent,'modified');
	// --- End field_table
	
	$this->CrudBase->tdsEchoForClmSort();// 列並に合わせてTD要素群を出力する
	
	// 行のボタン類
	echo "<td><div class='btn-group'>";
	$id = $ent['id'];
	echo  "<input type='button' value='↑↓' onclick='rowExchangeShowForm(this)' class='row_exc_btn btn btn-info btn-xs' />";
	$this->CrudBase->rowDeleteBtn($ent); // 削除ボタン
	$this->CrudBase->rowEnabledBtn($ent); // 有効ボタン
	$this->CrudBase->rowEditBtn($id);
	$this->CrudBase->rowPreviewBtn($id);
	$this->CrudBase->rowCopyBtn($id);
	$this->CrudBase->rowEliminateBtn($ent);// 抹消ボタン
	echo "</div></td>";
	
	echo "</tr>";
}

?>
</tbody>
</table>


<div id="exe_bulk_make_par">

	<input type="button" class="btn btn-danger btn-lg" value="一括作成実行" onclick="exeBulkMake()" />
    <div style="display:inline-block;padding-left:10px">
    	<label for="type_a_over"><input type="checkbox" id="file_over" value="1" /> ファイル上書き</label>
    </div>
    <pre id="exe_bulk_make_err"></pre>
</div><br>




<?php echo $this->element('CrudBase/crud_base_pwms'); // 複数選択による一括処理 ?>

<!-- 新規入力フォーム -->
<div id="ajax_crud_new_inp_form" class="panel panel-primary">

	<div class="panel-heading">
		<div class="pnl_head1">新規入力</div>
		<div class="pnl_head2"></div>
		<div class="pnl_head3">
			<button type="button" class="btn btn-primary btn-sm" onclick="closeForm('new_inp')"><span class="glyphicon glyphicon-remove"></span></button>
		</div>
	</div>
	<div class="panel-body">
	<div class="err text-danger"></div>
	
	<div style="display:none">
    	<input type="hidden" name="form_type">
    	<input type="hidden" name="row_index">
    	<input type="hidden" name="sort_no">
	</div>
	<table><tbody>
	
		<tr><td>任務id: </td><td>
			<input type="text" name="mission_id" class="valid" value="" pattern="^[0-9]+$" maxlength="11" title="数値を入力してください" />
			<label class="text-danger" for="mission_id"></label>
		</td></tr>
		<tr><td>フィールド名: </td><td>
			<input type="text" name="field_name" class="valid" value=""  maxlength="64" title="64文字以内で入力してください" />
			<label class="text-danger" for="field_name"></label>
		</td></tr>
		<tr><td>タイプA: </td><td>
			<?php $this->CrudBase->selectX('type_a',null,$typeAList,null,'-- タイプA --');?>
			<label class="text-danger" for="type_a"></label>
		</td></tr>
		<tr><td>フィールド型: </td><td>
			<input type="text" name="field_type" class="valid" value=""  maxlength="11" title="11文字以内で入力してください" />
			<label class="text-danger" for="field_type"></label>
		</td></tr>
		<tr><td>オリジナル型: </td><td>
			<input type="text" name="orig_type" class="valid" value=""  maxlength="64" title="64文字以内で入力してください" />
			<label class="text-danger" for="orig_type"></label>
		</td></tr>
		<tr><td>型長さ: </td><td>
			<input type="text" name="type_long" class="valid" value="" pattern="^[0-9]+$" maxlength="11" title="数値を入力してください" />
			<label class="text-danger" for="type_long"></label>
		</td></tr>
		<tr><td>NULLフラグ: </td><td>
			<input type="text" name="null_flg" class="valid" value="" pattern="^[0-9]+$" maxlength="11" title="数値を入力してください" />
			<label class="text-danger" for="null_flg"></label>
		</td></tr>
		<tr><td>主キーフラグ: </td><td>
			<input type="text" name="p_key_flg" class="valid" value="" pattern="^[0-9]+$" maxlength="11" title="数値を入力してください" />
			<label class="text-danger" for="p_key_flg"></label>
		</td></tr>
		<tr><td>デフォルト値: </td><td>
			<input type="text" name="def_val" class="valid" value=""  maxlength="64" title="64文字以内で入力してください" />
			<label class="text-danger" for="def_val"></label>
		</td></tr>
		<tr><td>補足: </td><td>
			<input type="text" name="extra" class="valid" value=""  maxlength="256" title="256文字以内で入力してください" />
			<label class="text-danger" for="extra"></label>
		</td></tr>
		<tr><td>コメント: </td><td>
			<input type="text" name="comment" class="valid" value=""  maxlength="256" title="256文字以内で入力してください" />
			<label class="text-danger" for="comment"></label>
		</td></tr>
		
			
	</tbody></table>
	

	<button type="button" onclick="newInpReg();" class="btn btn-success">
		<span class="glyphicon glyphicon-ok"></span>
	</button>

	</div><!-- panel-body -->
</div>



<!-- 編集フォーム -->
<div id="ajax_crud_edit_form" class="panel panel-primary">

	<div class="panel-heading">
		<div class="pnl_head1">編集</div>
		<div class="pnl_head2"></div>
		<div class="pnl_head3">
			<button type="button" class="btn btn-primary btn-sm" onclick="closeForm('edit')"><span class="glyphicon glyphicon-remove"></span></button>
		</div>
	</div>
	<div style="display:none">
    	<input type="hidden" name="sort_no">
	</div>
	<div class="panel-body">
	<div class="err text-danger"></div>
	<table><tbody>

		<!-- Start ajax_form_edit_start -->
		<tr><td>ID: </td><td>
			<span class="id"></span>
		</td></tr>
		<tr><td>フィールド名: </td><td>
			<span class="field_name"></span>
		</td></tr>
		<tr><td>タイプA: </td><td>
			<?php $this->CrudBase->selectX('type_a',null,$typeAList,null,'-- タイプA --');?>
		</td></tr>

		<tr><td>削除： </td><td>
			<input type="checkbox" name="delete_flg" class="valid"  />
		</td></tr>
		<!-- Start ajax_form_edit_end -->
	</tbody></table>
	
	

	<button type="button"  onclick="editReg();" class="btn btn-success">
		<span class="glyphicon glyphicon-ok"></span>
	</button>
	<hr>
	
	<input type="button" value="更新情報" class="btn btn-default btn-xs" onclick="$('#ajax_crud_edit_form_update').toggle(300)" /><br>
	<aside id="ajax_crud_edit_form_update" style="display:none">
		更新日時: <span class="modified"></span><br>
		生成日時: <span class="created"></span><br>
		ユーザー名: <span class="update_user"></span><br>
		IPアドレス: <span class="ip_addr"></span><br>
		ユーザーエージェント: <span class="user_agent"></span><br>
	</aside>
	

	</div><!-- panel-body -->
</div>



<!-- 削除フォーム -->
<div id="ajax_crud_delete_form" class="panel panel-danger">

	<div class="panel-heading">
		<div class="pnl_head1">削除</div>
		<div class="pnl_head2"></div>
		<div class="pnl_head3">
			<button type="button" class="btn btn-default btn-sm" onclick="closeForm('delete')"><span class="glyphicon glyphicon-remove"></span></button>
		</div>
	</div>
	
	<div class="panel-body" style="min-width:300px">
	<table><tbody>

		<!-- Start ajax_form_new -->
		<tr><td>ID: </td><td>
			<span class="id"></span>
		</td></tr>
		

		<tr><td>フィールド名: </td><td>
			<span class="field_name"></span>
		</td></tr>


		<!-- Start ajax_form_end -->
	</tbody></table>
	<br>
	

	<button type="button"  onclick="deleteReg();" class="btn btn-danger">
		<span class="glyphicon glyphicon-remove"></span>　削除する
	</button>
	<hr>
	
	<input type="button" value="更新情報" class="btn btn-default btn-xs" onclick="$('#ajax_crud_delete_form_update').toggle(300)" /><br>
	<aside id="ajax_crud_delete_form_update" style="display:none">
		更新日時: <span class="modified"></span><br>
		生成日時: <span class="created"></span><br>
		ユーザー名: <span class="update_user"></span><br>
		IPアドレス: <span class="ip_addr"></span><br>
		ユーザーエージェント: <span class="user_agent"></span><br>
	</aside>
	

	</div><!-- panel-body -->
</div>



<!-- 抹消フォーム -->
<div id="ajax_crud_eliminate_form" class="panel panel-danger">

	<div class="panel-heading">
		<div class="pnl_head1">抹消</div>
		<div class="pnl_head2"></div>
		<div class="pnl_head3">
			<button type="button" class="btn btn-default btn-sm" onclick="closeForm('eliminate')"><span class="glyphicon glyphicon-remove"></span></button>
		</div>
	</div>
	
	<div class="panel-body" style="min-width:300px">
	<table><tbody>

		<!-- Start ajax_form_new -->
		<tr><td>ID: </td><td>
			<span class="id"></span>
		</td></tr>
		

		<tr><td>フィールド名: </td><td>
			<span class="field_name"></span>
		</td></tr>


		<!-- Start ajax_form_end -->
	</tbody></table>
	<br>
	

	<button type="button"  onclick="eliminateReg();" class="btn btn-danger">
		<span class="glyphicon glyphicon-remove"></span>　抹消する
	</button>
	<hr>
	
	<input type="button" value="更新情報" class="btn btn-default btn-xs" onclick="$('#ajax_crud_eliminate_form_update').toggle(300)" /><br>
	<aside id="ajax_crud_eliminate_form_update" style="display:none">
		更新日時: <span class="modified"></span><br>
		生成日時: <span class="created"></span><br>
		ユーザー名: <span class="update_user"></span><br>
		IPアドレス: <span class="ip_addr"></span><br>
		ユーザーエージェント: <span class="user_agent"></span><br>
	</aside>
	

	</div><!-- panel-body -->
</div>


<br />

<!-- 埋め込みJSON -->
<div style="display:none">
	<input id="type_a_json" type="hidden" value='<?php echo $type_a_json; ?>' />
	<input id="data_json" type="hidden" value='<?php echo $data_json; ?>' />
	<input id="mission_json" type="hidden" value='<?php echo $mission_json; ?>' />
</div>



<!-- ヘルプ用  -->
<input type="button" class="btn btn-info btn-sm" onclick="$('#help_x').toggle()" value="ヘルプ" />
<div id="help_x" class="help_x" style="display:none">
	<h2>ヘルプ</h2>

	<?php echo $this->element('CrudBase/crud_base_help');?>


</div>























