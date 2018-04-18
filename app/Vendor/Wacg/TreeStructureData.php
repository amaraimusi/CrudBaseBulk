<?php

/**
 * ツリー構造データ関連クラス
 * 
 * @note
 * 2次元型のツリー構造データに対応。
 * 2次元型のツリー構造データは親ID型を持つエンティティの配列である。
 * 
 * @author kenji uehara
 * @date 2018-4-17 | 2018-4-18 複数のレスポンスタイプに対応
 * @version 1.1
 *
 */
class TreeStructureData{
	
	
	/**
	 * ツリー変換
	 * 
	 * @note
	 * 2次元ツリー構造データにツリー構造に関連したプロパティである子ノードリスト、世代（オフセットX）、オフセットY,兄弟番号
	 * などをセットする。オプションのレスポンスデータタイプにレスポンスのデータ構造を選べる。
	 * 
	 * @param array $data 2次元ツリー構造データ	親IDを含むデータ
	 * @param array $option オプション
	 *  - res_structure    レスポンスタイプ    （複数指定する場合はコンマで連結する）
	 *     'normal':エンティティ配列型 （デフォ） , 
	 *     'key_id':キーがidの構造 , 
	 *     'tree':ツリー構造 ,
	 *     'map':2次元マップ構造
	 *     'html_table':HTMLテーブル文字列
	 *  - sort_field    子ノードソートフィールド     デフォ→空   子ノードをソートするフィールド。    空ならソートしない。（デフォ）
	 *  - sort_order    子ノードソート向き     デフォ→0   0:昇順 （デフォ）, 1:降順
	 *  - id_field    IDのフィールド名     デフォ→id   
	 *  - par_id_field    親IDのフィールド名     デフォ→par_id   
	 *  - child_ids_field    子ノードIDリストのフィールド名     デフォ→child_ids   
	 *  - child_nodes_field    子ノードリストのフィールド名     デフォ→child_nodes   
	 *  - bros_no_field    兄弟番号のフィールド名     デフォ→bros_no   
	 *  - gene_no_field    世代のフィールド名     デフォ→gene_no   
	 *  - offset_x_field    オフセットXのフィールド名     デフォ→offset_x   
	 *  - offset_y_field    オフセットYのフィールド名     デフォ→offset_y  
	 *  - html_tbl_class    htmlテーブルのclass属性     デフォ→空
	 *  - html_tbl_fields    htmlテーブルの表示フィールド(配列指定可能）     デフォ→id
	 */
	public function tree(&$data,$option = array()){

		if(empty($data)) return $data;
		
		// オプションの初期化
		$option = $this->initOption($option);
		
		// 子ノードリストをセットする
		$data = $this->setChilds($data,$option);
		
		// キーid構造に変換する
		$datax = $this->convStructKeyId($data,$option);
		
		// 世代（オフセットX）、オフセットY、兄弟番号をセットする。
		$datax = $this->setOffsetsX($datax,$option);
		
		// レスポンス関連
		$res_structure = $option['res_structure']; // レスポンスデータタイプ
		$rsList = explode(",",$res_structure);
		$res = array(); // レスポンス
		foreach($rsList as $res_type){
			// 通常タイプ（エンティティ配列型）
			if($res_type = 'normal'){
				// キーID構造からエンティティ配列構造に戻す
				$res['normal'] = $this->convToStructNormal($datax);
			}
			
			// キーID構造タイプ
			if($res_type = 'key_id'){
				$res['key_id'] = $datax;
			}
			
			// ツリー構造タイプ
			if($res_type = 'tree'){
				$res['tree'] = $this->convToStructTreeX($datax,$option); // ツリー構造データに変換する;
			}
			
			// 2次元マップ構造タイプ
			if($res_type = 'map'){
				
				$res['map'] = $this->convToMap($datax,$option);// 2次元マップに変換する;
			}
			
			// HTMLテーブル文字列
			if($res_type = 'html_table'){
				$map = array();
				if(isset($res['map'])){
					$map = $res['map'];
				}else{
					$map = $this->convToMap($datax,$option);
				}
				$res['html_table'] = $this->createHtmlTbl($map,$option); // 2次元マップからHTMLテーブルのソースコードを作成
			}
			
			if(count($rsList) == 1){
				$res_type = $rsList[0];
				return $res[$res_type];
			}
			
			return $res;
			
		}

		return $datax;
	}
	
	
	/**
	 * オプションの初期化
	 * @param array $option オプション
	 * @return array 初期化後のオプション
	 */
	private function initOption($option){
		if(empty($option)) $option =array();
		
		if(empty($option['res_structure'])) $option['res_structure'] = 'normal';  // レスポンスデータタイプ
		if(empty($option['sort_field'])) $option['sort_field'] = '';  // 子ノードソートフィールド
		if(empty($option['sort_order'])) $option['sort_order'] = 0;  // 子ノードソート向き
		if(empty($option['id_field'])) $option['id_field'] = 'id';  // IDのフィールド名
		if(empty($option['par_id_field'])) $option['par_id_field'] = 'par_id';  // 親IDのフィールド名
		if(empty($option['child_ids_field'])) $option['child_ids_field'] = 'childIds';  // 子ノードIDリストのフィールド名
		if(empty($option['child_nodes_field'])) $option['child_nodes_field'] = 'childNodes';  // 子ノードリストのフィールド名
		if(empty($option['bros_no_field'])) $option['bros_no_field'] = 'bros_no';  // 兄弟番号のフィールド名
		if(empty($option['gene_no_field'])) $option['gene_no_field'] = 'gene_no';  // 世代のフィールド名
		if(empty($option['offset_x_field'])) $option['offset_x_field'] = 'offset_x';  // オフセットXのフィールド名
		if(empty($option['offset_y_field'])) $option['offset_y_field'] = 'offset_y';  // オフセットYのフィールド名
		if(empty($option['html_tbl_class'])) $option['html_tbl_class'] = '';  // htmlテーブルのclass属性
		if(empty($option['html_tbl_fields'])) $option['html_tbl_fields'] = 'id';  // htmlテーブルの表示フィールド
		
		
		return $option;
	}
	
	
	/**
	 * 子ノードリストをセットする
	 *
	 * @note
	 * 2次元型のツリー構造データに対応。（親ID型）
	 *
	 * @param array $data 2次元ツリー構造データ	親IDを含むデータ
	 * @param array $option オプション
	 *  - sort_field 子ノードをソートするフィールド。    空ならソートしない。（デフォ）
	 *  - sort_order 子ノードのソート方向   0:昇順 （デフォ）, 1:降順
	 *  - id_field IDフィールド名
	 *  - par_id_field 親IDフィールド名
	 *  - child_ids_field 子ノードフィールド名
	 * @return array 子ノードリストをセットした2次元ツリー構造データ
	 */
	private function setChilds(&$data,$option=array('sort_field'=>'name')){

		$sort_field = $option['sort_field']; // 子ノードソートフィールド
		$sort_order = $option['sort_order']; // 子ノードソート向き
		$id_field = $option['id_field']; // IDのフィールド名
		$par_id_field = $option['par_id_field']; // 親IDのフィールド名
		$child_ids_field = $option['child_ids_field']; // 子ノードIDリストのフィールド名

		
		// ソートフラグ
		$sort_flg = 0;
		if(!empty($sort_field)) $sort_flg=1;
		
		// 各ノードごとに子ノードのIDを検索し、子ノートリストとしてセットする。
		$tmps=array();
		foreach($data as &$ent){
			$childs = array();
			$par_id1 = $ent[$id_field];
			foreach($data as &$ent2){
				
				// 子ノードである場合
				if($par_id1 == $ent2[$par_id_field]){
					// ソートフラグがOFFなら、そのまま子ノードのIDを子ノードリストに追加する。
					if($sort_flg==0){
						$childs[] = $ent2[$id_field];
					}
					
					// ソートフラグがONなら、一時的データに格納する。
					else{
						$tmps[] = array(
								$id_field => $ent2[$id_field],
								$sort_field => $ent2[$sort_field],
						);
					}
				}
			}
			unset($ent2);
			
			// ソートフラグがONなら、一時的データをソートフィールドで並べ替えてからIDを子ノードリストにセットする。
			if($sort_flg == 1){
				$tmps = $this->sortData($tmps,$sort_field,$sort_order);
				foreach($tmps as $tmpEnt){
					$childs[] = $tmpEnt[$id_field];
				}
				$tmps=array(); // 一時的データをクリア
			}
			
			$ent[$child_ids_field] = $childs;
			
		}
		unset($ent);
		
		return $data;
	}
	
	
	/**
	 * 特定のフィールドでデータを並べ替える
	 * @param array $data データ（2次元配列）
	 * @param string $sortField 並べ替えフィールド名
	 * @param int $orderFlg 0:昇順  , 1:降順
	 */
	private function sortData($data,$sortField,$orderFlg){
		$sfList=array();// ソートフィールドリスト
		foreach($data as $key=> $ent){
			$sfList[$key]=$ent[$sortField];
		}
		
		$sortFlg = SORT_ASC;
		if(!empty($orderFlg)){
			$sortFlg = SORT_DESC;
		}
		
		array_multisort($sfList,$sortFlg,$data);
		
		return $data;
	}
	
	
	
	/**
	 * キーid構造に変換する
	 * 
	 * @param array $data エンティティ配列構造のデータ
	 * @param array $option 
	 *  - id_field IDフィールド名
	 * @return array キーid構造に変換したデータ 
	 */
	private function convStructKeyId(&$data,$option){
		
		$id_field = $option['id_field'];

		$datax = array();
		foreach($data as $ent){
			$id = $ent[$id_field];
			$datax[$id] = $ent;
		}
		
		return $datax;
	}
	
	
	/**
	 * 世代（オフセットX）、オフセットY、兄弟番号をセットする。
	 * 
	 * @note
	 * 先にsetChilds関数で子ノードリストをデータにセットしておくこと。
	 * 
	 * @param array $datax キーid構造データ
	 * @param array $option オプション
	 * @return array セット後のキーid構造データ
	 */
	private function setOffsetsX(&$datax,&$option){
		
		$par_id_field = $option['par_id_field']; // 親IDフィールド

		$id_field = $option['id_field']; // IDのフィールド名

		// 創始ノードを探す
		$start_id = -1;
		foreach($datax as &$node){
			if($node[$par_id_field] == 0){
				$start_id = $node[$id_field];
				break;
			}
		}
		unset($node);

		if($start_id == -1) return $datax;

		// 再起呼び出し型関数：  世代番号付与関数（データ、id、世代番号、兄弟通番、&オフセットY,オプション）
		$option['offset_y'] = 1;
		$this->setOffsets($datax,$start_id,1,1,$option);
		
		return $datax;
	}
	
	
	
	/**
	 * 世代番号付与関数
	 * @param array $datax キーid構造データ
	 * @param int $id 
	 * @param int $gene_no 世代（オフセットX)
	 * @param int $bros_no 兄弟番号
	 * @param int $offset_y オフセットY
	 * @param array $option オプション
	 */
	private function setOffsets(&$datax,$id,$gene_no,$bros_no,&$option){
		
		$id_field = $option['id_field']; // IDのフィールド名
		$par_id_field = $option['par_id_field']; // 親IDのフィールド名
		$child_ids_field = $option['child_ids_field']; // 子ノードIDリストのフィールド名
		$child_nodes_field = $option['child_nodes_field']; // 子ノードリストのフィールド名
		$bros_no_field = $option['bros_no_field']; // 兄弟番号のフィールド名
		$gene_no_field = $option['gene_no_field']; // 世代のフィールド名
		$offset_x_field = $option['offset_x_field']; // オフセットXのフィールド名
		$offset_y_field = $option['offset_y_field']; // オフセットYのフィールド名
		$offset_y = $option['offset_y']; // オフセットY
		
		$node = &$datax[$id];
		$node[$gene_no_field] = $gene_no; // 引数ノードに世代番号を付与する
		$node[$bros_no_field] = $bros_no; // 引数ノードに兄弟通番を付与する
		$node[$offset_x_field] = $gene_no; // 引数ノードにオフセットXを付与する
		$node[$offset_y_field] = $offset_y; // 引数ノードにオフセットYを付与する
		$childIds = $node[$child_ids_field]; // 引数ノードから子ノードリストを取得する
		
		$option['prev_gene_no'] = $gene_no; // オフセットYの調整用
		
		$gene_no ++;
		$bros_no = 1;
		
		foreach($childIds as $c_id){
			
			if(!empty($datax[$c_id][$gene_no_field])) continue;
			
			// 再起呼び出し　要素ノード、世代番号、兄弟通番、従妹通番、家系連番
			$this->setOffsets($datax,$c_id,$gene_no,$bros_no,$option);
			
			if($option['prev_gene_no'] == $gene_no){
				$option['offset_y'] ++; // オフセットYをインプリメント
			}
	
			$bros_no++; // 兄弟通番をインプリメント
			
		}
		
	}
	
	
	/**
	 *  ツリー構造データに変換する
	 * @param array $datax キーID構造データ
	 * @param array $option オプション
	 * @return array ツリー構造データ
	 */
	private function convToStructTreeX($datax,$option){

		$tree = array(); // ツリー構造データ
		$par_id_field = $option['par_id_field']; // 親IDフィールド
		$id_field = $option['id_field']; // IDのフィールド名
		
		// 創始ノードを探す
		$start_id = -1;
		foreach($datax as $node){
			if($node[$par_id_field] == 0){
				$start_id = $node[$id_field];
				break;
			}
		}
		if($start_id == -1) return $datax;
		
		$tree = $datax[$start_id]; // 創始ノードをツリー構造データの先頭にセット
		$datax[$start_id]['set_flg'] = 1; // セットフラグ。無限ループ回避用
		$option['counter'] = 0; // 無限ループ防止用のカウンター
		
		// 再起呼び出し型関数：  ツリー構造データに変換
		$this->convToStructTree($tree,$datax,$start_id,$option);

		return $tree;
	}
	
	
	/**
	 * 世代番号付与関数
	 * @param array tree ツリー構造データ
	 * @param array $datax キーid構造データ
	 * @param array $id
	 * @param array $option オプション
	 */
	private function convToStructTree(&$node,&$datax,$id,&$option){
		
		// 無限ループ防止
		$option['counter'] ++;
		if($option['counter'] > 10000) return;
		
		$child_ids_field = $option['child_ids_field']; // 子ノードIDリストのフィールド名
		$child_nodes_field = $option['child_nodes_field']; // 子ノードリストのフィールド名
 		$childIds = $node[$child_ids_field]; // 引数ノードから子ノードリストを取得する

		foreach($childIds as $c_id){
			
			$cNode = $datax[$c_id];
			if(empty($cNode['set_flg'])){
				$datax[$c_id]['set_flg'] = 1;
				unset($cNode['set_flg']);

				// 再起呼び出し
				$this->convToStructTree($cNode,$datax,$c_id,$option);
				
				// 子ノードリストに追加
				$node[$child_nodes_field][$c_id] = $cNode;
		
			}
			

		}
		
	}
	
	
	/**
	 * キーID構造からエンティティ配列構造に戻す
	 * @param array $datax キーID構造
	 * @return array エンティティ配列構造のデータ
	 */
	private function convToStructNormal(&$datax){
		$data = array();
		
		foreach($datax as $ent){
			$data[] = $ent;
		}
		
		return $data;
	}
	
	
	
	
	/**
	 * 2次元マップに変換する
	 * @param array $datax
	 * @return array 2次元マップ
	 */
	private function convToMap(&$datax,$option){
		
		if(empty($datax)) return array();

		$offset_x_field = $option['offset_x_field']; // オフセットXのフィールド名
		$offset_y_field = $option['offset_y_field']; // オフセットYのフィールド名
		
		$cnt_x = 0;
		$cnt_y = 0;
		foreach($datax as &$ent){
			if(isset($ent[$offset_x_field])){
				$offset_x = $ent[$offset_x_field];
				if($cnt_x < $offset_x) $cnt_x = $offset_x;
			}
			if(isset($ent[$offset_y_field])){
				$offset_y = $ent[$offset_y_field];
				if($cnt_y < $offset_y) $cnt_y = $offset_y;
			}
		}
		unset($ent);
		
		$map = array();
		for($y=0;$y<$cnt_y;$y++){
			$map[$y] = null;
			for($x=0;$x<$cnt_x;$x++){
				$map[$y][$x] = null;
			}
		}

		foreach($datax as &$ent){
			if(isset($ent[$offset_x_field]) && isset($ent[$offset_y_field])){
				$x = $ent[$offset_x_field] - 1;
				$y = $ent[$offset_y_field] - 1;
				$map[$y][$x] = $ent;
			}
		}
		
		return $map;

	}
	
	/**
	 * 2次元マップからHTMLテーブルのソースコードを作成
	 * @param array $map 2次元マップ
	 * @param array $option オプション
	 *  - html_tbl_class    htmlテーブルのclass属性     デフォ→空
	 *  - html_tbl_fields    htmlテーブルの表示フィールド(配列指定可能）     デフォ→id
	 * @return string　HTMLテーブルのソースコード
	 */
	private function createHtmlTbl(&$map,&$option){
		
		$html_tbl_class = $option['html_tbl_class']; // HTMLテーブルのclass属性
		$html_tbl_fields = $option['html_tbl_fields']; // htmlテーブルの表示フィールド

		// htmlテーブルの表示フィールドが文字列なら配列化する
		if(!is_array($html_tbl_fields)){
			$html_tbl_fields = array($html_tbl_fields);
		}
		
		if(empty($map)) return '';
		$cnt_y = count($map);
		$cnt_x = count($map[0]);
		
		$html = "<table class='tbl2'><tbody>";
		for($y=0;$y<$cnt_y;$y++){
			$html .= '<tr>';
			for($x=0;$x<$cnt_x;$x++){
				$td = "";
				if(!empty($map[$y][$x])){
					$ent = $map[$y][$x];
					$td = '';
					foreach($html_tbl_fields as $field){
						$td .= $ent[$field] . '<br>';
					}
				}
				$html .= "<td>{$td}</td>";
			}
			$html .= '</tr>';
		}
		$html .= '</tbody></table>';
		
		return $html;
		
	}

}