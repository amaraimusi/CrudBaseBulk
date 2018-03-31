
<?php
$this->CrudBase->setModelName('Neko');

$this->assign('css', $this->Html->css(array('CrudBase/detail')));
?>

<h2>ネコ・詳細</h2>
<?php
$this->Html->addCrumb("トップ",'/');
$this->Html->addCrumb("ネコ",'/neko');
$this->Html->addCrumb("詳細");
echo $this->Html->getCrumbs(" > ");

if(empty($ent)){
	echo "<div id='no_data'>NO DATA</div>";
	return;
}
?>

<?php

if(!empty($regMsg)){
	echo $regMsg;
}

?>

<style>
	#forms1 td{padding:4px;}

	#forms1 td:nth-child(1) {
    	color:#535353;
	}
	#forms1 td:nth-child(2) {
    	color:#143c7c;
	}
</style>

<hr>


<table id="forms1">

	<?php 
	// --- Start detail_preview
	$this->CrudBase->tpId($ent['id'],'ID');
	$this->CrudBase->tpMoney($ent['neko_val'],'ネコ数値');
	$this->CrudBase->tpStr($ent['neko_name'],'ネコ名前');
	$this->CrudBase->tpPlain($ent['neko_date'],'ネコ日');
	$this->CrudBase->tpList($ent['neko_group'],'ネコ種別',$nekoGroupList);
	$this->CrudBase->tpPlain($ent['neko_dt'],'ネコ日時');
	$this->CrudBase->tpNote($ent['note'],'備考');
	$this->CrudBase->tpDeleteFlg($ent['delete_flg'],'有無');
	$this->CrudBase->tpPlain($ent['update_user'],'更新者');
	$this->CrudBase->tpPlain($ent['ip_addr'],'更新IPアドレス');
	$this->CrudBase->tpPlain($ent['created'],'生成日時');
	$this->CrudBase->tpPlain($ent['modified'],'更新日時');
	// --- End detail_preview
	?>


</table>

<hr>
<?php
	$rtnUrl= $this->Html->webroot.'neko';
	$refixUrl=$this->Html->webroot."neko/edit?id={$ent['id']}";
?>
<ul class="ul_side_by_side" >
	<li><a href='<?php echo $rtnUrl ?>' >一覧に戻る</a></li>
	<li><a href='<?php echo $refixUrl ?>' class='btn btn-warning btn-xs'>編集</a></li>
</ul>
<div style="clear:both"></div>
<hr />









