<?php
$this->CrudBase->setModelName('Hinagata');

// CSSファイルのインクルード
$cssList = $this->CrudBase->getCssList();
$cssList[] = 'Hinagata/index'; // 当画面専用CSS
$this->assign('css', $this->Html->css($cssList));

// JSファイルのインクルード
$jsList = $this->CrudBase->getJsList();
$jsList[] = 'Hinagata/index'; // 当画面専用JavaScript
$this->assign('script', $this->Html->script($jsList,array('charset'=>'utf-8')));

?>




<h2>フィールド雛型</h2>

フィールド雛型の検索閲覧および編集する画面です。<br>
<br>

<?php
	$this->Html->addCrumb("トップ",'/');
	$this->Html->addCrumb("フィールド雛型");
	echo $this->Html->getCrumbs(" > ");
?>

<?php echo $this->element('CrudBase/crud_base_new_page_version');?>
<div id="err" class="text-danger"><?php echo $errMsg;?></div>


<!-- 検索条件入力フォーム -->
<div style="margin-top:5px">
	<?php 
		echo $this->Form->create('Hinagata', array('url' => true ));
	?>

	
	<div style="clear:both"></div>
	
	<div id="detail_div" style="display:none">
		
		<?php 
		
		// --- Start kj_input
		$this->CrudBase->inputKjText($kjs,'kj_hina_code','雛型コード',300);
		$this->CrudBase->inputKjNouislider($kjs,'hinagata_val','フィールド雛型数値'); 
		$this->CrudBase->inputKjSelect($kjs,'kj_type_a','タイプA',$typeAList); 
		$this->CrudBase->inputKjText($kjs,'kj_hinagata','雛型',200,'部分一致検索');
		
		$this->CrudBase->inputKjId($kjs); 
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
		
		$csv_dl_url = $this->html->webroot . 'hinagata/csv_download';
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


<br />

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
<table id="hinagata_tbl" border="1"  class="table table-striped table-bordered table-condensed">

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
	$this->CrudBase->tdStr($ent,'hina_code');
	$this->CrudBase->tdList($ent,'type_a',$typeAList);
	$this->CrudBase->tdNote($ent,'hinagata',200);
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

		<tr><td>雛型コード: </td><td>
			<input type="text" name="hina_code" class="valid" value=""  maxlength="255" title="255文字以内で入力してください" />
			<label class="text-danger" for="hina_code"></label>
		</td></tr>

		<tr><td>タイプA: </td><td>
			<?php $this->CrudBase->selectX('type_a',null,$typeAList,null);?>
			<label class="text-danger" for="type_a"></label>
		</td></tr>
		
		<tr><td>雛型： </td><td>
			<textarea name="hinagata" style="width:480px;height:200px;"></textarea>
			<label class="text-danger" for="hinagata"></label>
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

	<button type="button"  onclick="editReg();" class="btn btn-success">
		<span class="glyphicon glyphicon-ok"></span>
	</button>
	<table><tbody>

		<!-- Start ajax_form_edit_start -->
		<tr><td>ID: </td><td>
			<span class="id"></span>
		</td></tr>

		<tr><td>雛型コード: </td><td>
			<input type="text" name="hina_code" class="valid" value=""  maxlength="255" title="255文字以内で入力してください" />
			<label class="text-danger" for="hina_code"></label>
		</td></tr>

		<tr><td>タイプA: </td><td>
			<?php $this->CrudBase->selectX('type_a',null,$typeAList,null);?>
			<label class="text-danger" for="type_a"></label>

		</td></tr>

		<tr><td>雛型： </td><td>
			<textarea name="hinagata" class="hinagata_ta" ></textarea>
			<label class="text-danger" for="hinagata"></label>
			<table class="tbl2"><thead><tr><th>可変コード</th><th>説明</th><th>詳細</th></tr></thead><tbody>
				<tr><td>%model_s</td><td>モデル名（スネーク記法）</td><td></td></tr>
				<tr><td>%model_c</td><td>モデル名（キャメル記法）</td><td></td></tr>
				<tr><td>%model_lcc</td><td>モデル名（ローワーキャメル記法）</td><td></td></tr>
				<tr><td>%field_s</td><td>フィールド名（スネーク記法）</td><td></td></tr>
				<tr><td>%field_c</td><td>フィールド名（キャメル記法）</td><td></td></tr>
				<tr><td>%field_lcc</td><td>フィールド名（ローワーキャメル記法）</td><td></td></tr>
				<tr><td>%field_type</td><td>型</td><td></td></tr>
				<tr><td>%type_long</td><td>型長</td><td>int</td></tr>
				<tr><td>%null_flg</td><td>NULLフラグ</td><td>0:NULLでない , 1:NULL</td></tr>
				<tr><td>%p_key_flg</td><td>主キーフラグ</td><td></td></tr>
				<tr><td>%def_val</td><td>デフォルト値　</td><td></td></tr>
				<tr><td>%comment</td><td>コメント（和名）　</td><td></td></tr>
				<tr><td>%field_out_model_s</td><td>ID系フィールド・外部モデル名(スネーク記法）</td>
					<td><aside>フィールド名がbig_cat_idである場合、「big_cat」になる</aside></td></tr>
				<tr><td>%field_out_model_c</td><td>ID系フィールド・外部モデル名</td>
					<td><aside>フィールド名がbig_cat_idである場合、「BigCat」になる</aside></td></tr>
				<tr><td>%field_out_model_lcc</td><td>ID系フィールド・外部モデル名(先頭小文字のキャメル記法）</td>
					<td><aside>フィールド名がbig_cat_idである場合、「bigCat」になる</aside></td></tr>
				<tr><td>%outer_model_s</td><td>外部モデル名</td><td>フィールド名から「_id」を取り除いた外部モデル名。例：buta_id⇒buta</td></tr>
				<tr><td>%tbl_s</td><td>テーブル名</td><td>例→big_cats</td></tr>
				<tr><td>%form_required</td><td>Form inputのrequired属性</td><td>DBフィールドがNOT NULLなら"required"をセット</td></tr>
				<tr><td>%label_required</td><td>【必須】</td><td>ラベルの必須入力表示】</td></tr>
				
			</tbody></table>
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
		

		<tr><td>雛型コード: </td><td>
			<span class="hina_code"></span>
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
		

		<tr><td>雛型コード: </td><td>
			<span class="hina_code"></span>
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
</div>



<!-- ヘルプ用  -->
<input type="button" class="btn btn-info btn-sm" onclick="$('#help_x').toggle()" value="ヘルプ" />
<div id="help_x" class="help_x" style="display:none">
	<h2>ヘルプ</h2>

	<?php echo $this->element('CrudBase/crud_base_help');?>


</div>























