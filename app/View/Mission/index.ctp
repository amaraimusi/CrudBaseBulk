<?php
$this->CrudBase->setModelName('Mission');

// CSSファイルのインクルード
$cssList = $this->CrudBase->getCssList();
$this->assign('css', $this->Html->css($cssList));

// JSファイルのインクルード
$jsList = $this->CrudBase->getJsList();
$jsList[] = 'Mission/index'; // 当画面専用JavaScript
$this->assign('script', $this->Html->script($jsList,array('charset'=>'utf-8')));

?>




<h2>任務</h2>

任務の検索閲覧および編集する画面です。<br>
<br>

<?php
	$this->Html->addCrumb("トップ",'/');
	$this->Html->addCrumb("任務");
	echo $this->Html->getCrumbs(" > ");
?>

<?php echo $this->element('CrudBase/crud_base_new_page_version');?>
<div id="err" class="text-danger"><?php echo $errMsg;?></div>


<!-- 検索条件入力フォーム -->
<div style="margin-top:5px">
	<?php 
		echo $this->Form->create('Mission', array('url' => true ));
	?>

	
	<div style="clear:both"></div>
	
	<div id="detail_div" style="display:none">
		
		<?php 
		
		// --- Start kj_input
		$this->CrudBase->inputKjText($kjs,'kj_mission_name','任務名',300);
		$this->CrudBase->inputKjSelect($kjs,'kj_hina_file_id','雛ファイル',$hinaFileList);
		$this->CrudBase->inputKjText($kjs,'kj_from_path','複製元パス',300);
		$this->CrudBase->inputKjText($kjs,'kj_from_scr_code','複製元画面コード',300);
		$this->CrudBase->inputKjText($kjs,'kj_from_db_name','複製元DB名',300);
		$this->CrudBase->inputKjText($kjs,'kj_from_tbl_name','複製元テーブル名',300);
		$this->CrudBase->inputKjText($kjs,'kj_from_wamei','複製元和名',300);
		$this->CrudBase->inputKjText($kjs,'kj_to_path','複製先パス',300);
		$this->CrudBase->inputKjText($kjs,'kj_to_scr_code','複製先画面コード',300);
		$this->CrudBase->inputKjText($kjs,'kj_to_db_name','複製先DB名',300);
		$this->CrudBase->inputKjText($kjs,'kj_to_tbl_name','複製先テーブル名',300);
		$this->CrudBase->inputKjText($kjs,'kj_to_wamei','複製先和名',300);
		
		$this->CrudBase->inputKjHidden($kjs,'kj_sort_no');
		$this->CrudBase->inputKjDeleteFlg($kjs);
		$this->CrudBase->inputKjText($kjs,'kj_update_user','更新者',150);
		$this->CrudBase->inputKjText($kjs,'kj_ip_addr','更新IPアドレス',200);
		$this->CrudBase->inputKjCreated($kjs);
		$this->CrudBase->inputKjModified($kjs);
		$this->CrudBase->inputKjLimit($kjs);
		// --- End kj_input
		
		echo $this->element('CrudBase/crud_base_cmn_inp');
		
		?>

		
		
		<?php 
		
		echo $this->Form->submit('検索', array('name' => 'search','class'=>'btn btn-success','div'=>false,));
		
		echo $this->element('CrudBase/crud_base_index');
		
		$csv_dl_url = $this->html->webroot . 'mission/csv_download';
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

				<a href="type_a" class="btn btn-primary btn-sm">タイプA</a>
				<a href="hinagata" class="btn btn-primary btn-sm">フィールド雛型</a>
				<a href="hina_file" class="btn btn-primary btn-sm">雛ファイル</a>
			</div>



	</div>
	<div style="clear:both"></div>
	<?php echo $this->Form->end()?>

	
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
<table id="mission_tbl" border="1"  class="table table-striped table-bordered table-condensed">

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
	$this->CrudBase->tdStr($ent,'mission_name');
	$this->CrudBase->tdList($ent,'hina_file_id',$hinaFileList);
	$this->CrudBase->tdStr($ent,'from_path');
	$this->CrudBase->tdStr($ent,'from_scr_code');
	$this->CrudBase->tdStr($ent,'from_db_name');
	$this->CrudBase->tdStr($ent,'from_tbl_name');
	$this->CrudBase->tdStr($ent,'from_wamei');
	$this->CrudBase->tdStr($ent,'to_path');
	$this->CrudBase->tdStr($ent,'to_scr_code');
	$this->CrudBase->tdStr($ent,'to_db_name');
	$this->CrudBase->tdStr($ent,'to_tbl_name');
	$this->CrudBase->tdStr($ent,'to_wamei');
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
	echo "<a href='bulk_make?kj_mission_id={$id}' class='btn btn-success btn-xs' >一括作成</a>";
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

		<!-- Start ajax_form_new_start -->
		<tr><td>任務名: </td><td>
			<input type="text" name="mission_name" class="valid" value=""  maxlength="255" title="255文字以内で入力してください" />
			<label class="text-danger" for="mission_name"></label>
		</td></tr>
		<tr><td>雛ファイル: </td><td>
			<?php $this->CrudBase->selectX('hina_file_id',null,$hinaFileList,null,'-- 雛ファイル --');?>
			<label class="text-danger" for="hina_file_id"></label>
		</td></tr>
		<tr><td>複製元パス: </td><td>
			<input type="text" name="from_path" class="valid" value=""  maxlength="1024" title="1024文字以内で入力してください" />
			<label class="text-danger" for="from_path"></label>
		</td></tr>
		<tr><td>複製元画面コード: </td><td>
			<input type="text" name="from_scr_code" class="valid" value=""  maxlength="64" title="64文字以内で入力してください" />
			<label class="text-danger" for="from_scr_code"></label>
		</td></tr>
		<tr><td>複製元DB名: </td><td>
			<input type="text" name="from_db_name" class="valid" value=""  maxlength="64" title="64文字以内で入力してください" />
			<label class="text-danger" for="from_db_name"></label>
		</td></tr>
		<tr><td>複製元テーブル名: </td><td>
			<input type="text" name="from_tbl_name" class="valid" value=""  maxlength="64" title="64文字以内で入力してください" />
			<label class="text-danger" for="from_tbl_name"></label>
		</td></tr>
		<tr><td>複製元和名: </td><td>
			<input type="text" name="from_wamei" class="valid" value=""  maxlength="256" title="256文字以内で入力してください" />
			<label class="text-danger" for="from_wamei"></label>
		</td></tr>
		<tr><td>複製先パス: </td><td>
			<input type="text" name="to_path" class="valid" value=""  maxlength="1024" title="1024文字以内で入力してください" />
			<label class="text-danger" for="to_path"></label>
		</td></tr>
		<tr><td>複製先画面コード: </td><td>
			<input type="text" name="to_scr_code" class="valid" value=""  maxlength="64" title="64文字以内で入力してください" />
			<label class="text-danger" for="to_scr_code"></label>
		</td></tr>
		<tr><td>複製先DB名: </td><td>
			<input type="text" name="to_db_name" class="valid" value=""  maxlength="64" title="64文字以内で入力してください" />
			<label class="text-danger" for="to_db_name"></label>
		</td></tr>
		<tr><td>複製先テーブル名: </td><td>
			<input type="text" name="to_tbl_name" class="valid" value=""  maxlength="64" title="64文字以内で入力してください" />
			<label class="text-danger" for="to_tbl_name"></label>
		</td></tr>
		<tr><td>複製先和名: </td><td>
			<input type="text" name="to_wamei" class="valid" value=""  maxlength="256" title="256文字以内で入力してください" />
			<label class="text-danger" for="to_wamei"></label>
		</td></tr>
		<!-- Start ajax_form_new_end -->
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
		
		<tr><td>任務名: </td><td>
			<input type="text" name="mission_name" class="valid" value=""  maxlength="255" title="255文字以内で入力してください" />
			<label class="text-danger" for="mission_name"></label>
		</td></tr>
		<tr><td>雛ファイル: </td><td>
			<?php $this->CrudBase->selectX('hina_file_id',null,$hinaFileList,null,'-- 雛ファイル --');?>
			<label class="text-danger" for="hina_file_id"></label>
		</td></tr>
		<tr><td>複製元パス: </td><td>
			<input type="text" name="from_path" class="valid" value=""  maxlength="1024" title="1024文字以内で入力してください" />
			<label class="text-danger" for="from_path"></label>
		</td></tr>
		<tr><td>複製元画面コード: </td><td>
			<input type="text" name="from_scr_code" class="valid" value=""  maxlength="64" title="64文字以内で入力してください" />
			<label class="text-danger" for="from_scr_code"></label>
		</td></tr>
		<tr><td>複製元DB名: </td><td>
			<input type="text" name="from_db_name" class="valid" value=""  maxlength="64" title="64文字以内で入力してください" />
			<label class="text-danger" for="from_db_name"></label>
		</td></tr>
		<tr><td>複製元テーブル名: </td><td>
			<input type="text" name="from_tbl_name" class="valid" value=""  maxlength="64" title="64文字以内で入力してください" />
			<label class="text-danger" for="from_tbl_name"></label>
		</td></tr>
		<tr><td>複製元和名: </td><td>
			<input type="text" name="from_wamei" class="valid" value=""  maxlength="256" title="256文字以内で入力してください" />
			<label class="text-danger" for="from_wamei"></label>
		</td></tr>
		<tr><td>複製先パス: </td><td>
			<input type="text" name="to_path" class="valid" value=""  maxlength="1024" title="1024文字以内で入力してください" />
			<label class="text-danger" for="to_path"></label>
		</td></tr>
		<tr><td>複製先画面コード: </td><td>
			<input type="text" name="to_scr_code" class="valid" value=""  maxlength="64" title="64文字以内で入力してください" />
			<label class="text-danger" for="to_scr_code"></label>
		</td></tr>
		<tr><td>複製先DB名: </td><td>
			<input type="text" name="to_db_name" class="valid" value=""  maxlength="64" title="64文字以内で入力してください" />
			<label class="text-danger" for="to_db_name"></label>
		</td></tr>
		<tr><td>複製先テーブル名: </td><td>
			<input type="text" name="to_tbl_name" class="valid" value=""  maxlength="64" title="64文字以内で入力してください" />
			<label class="text-danger" for="to_tbl_name"></label>
		</td></tr>
		<tr><td>複製先和名: </td><td>
			<input type="text" name="to_wamei" class="valid" value=""  maxlength="256" title="256文字以内で入力してください" />
			<label class="text-danger" for="to_wamei"></label>
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
		

		<tr><td>任務名: </td><td>
			<span class="mission_name"></span>
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
		

		<tr><td>任務名: </td><td>
			<span class="mission_name"></span>
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
	<input id="hina_file_json" type="hidden" value='<?php echo $hina_file_json; ?>' />
</div>



<!-- ヘルプ用  -->
<input type="button" class="btn btn-info btn-sm" onclick="$('#help_x').toggle()" value="ヘルプ" />
<div id="help_x" class="help_x" style="display:none">
	<h2>ヘルプ</h2>

	<?php echo $this->element('CrudBase/crud_base_help');?>


</div>



