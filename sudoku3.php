<?php
// $field = [
// 	[0,1,4,6,0,8,2,7,0],
// 	[7,0,2,4,0,9,1,0,8],
// 	[6,8,0,2,0,1,0,3,5],
// 	[9,5,3,0,0,0,7,4,2],
// 	[0,0,0,0,0,0,0,0,0],
// 	[1,2,8,0,0,0,6,5,3],
// 	[8,7,0,9,0,2,0,1,6],
// 	[2,0,1,5,0,3,9,0,7],
// 	[0,9,6,1,0,7,5,2,0],
// ];
// $field = [
//      [0, 0, 0, 0, 2, 7, 0, 0, 8],
//      [0, 0, 1, 0, 0, 0, 0, 0, 7],
//      [0, 6, 4, 0, 0, 5, 0, 1, 9],
//      [2, 7, 0, 9, 6, 3, 1, 5, 4],
//      [4, 0, 0, 2, 7, 0, 6, 8, 3],
//      [6, 1, 3, 0, 0, 4, 0, 0, 0],
//      [0, 8, 7, 6, 3, 2, 0, 4, 1],
//      [0, 9, 0, 0, 4, 8, 0, 0, 5],
//      [3, 4, 2, 5, 1, 9, 8, 7, 0],
//  ];

// $field = [
// 	[6,0,2,0,0,0,0,0,0],
// 	[0,0,8,0,2,7,0,0,3],
// 	[0,0,0,0,0,0,0,0,0],
// 	[0,0,0,0,0,0,0,1,0],
// 	[4,5,0,0,3,0,0,0,0],
// 	[1,3,0,0,7,0,0,6,2],
// 	[0,1,0,0,6,3,0,9,0],
// 	[0,0,0,0,0,1,0,0,0],
// 	[2,0,5,0,0,0,8,0,0],
// ];

$field = [
	[5,0,7,0,0,0,0,0,0],
	[0,0,2,6,0,0,0,0,0],
	[0,0,0,9,0,0,0,0,7],
	[0,0,5,0,0,0,0,0,0],
	[0,6,0,0,0,5,1,7,8],
	[2,0,1,0,4,7,0,6,0],
	[0,0,0,0,0,1,5,0,0],
	[4,7,0,0,3,6,0,0,0],
	[0,0,6,0,0,0,0,0,9],
];

//変わらない数字なので、定数で設定
 const X_MAX = 9;
 const Y_MAX = 9;

//横軸をx,縦軸をyを表現
$point = [
    'x' => 0,
    'y' => 0,
];

sudoku($field, $point);
// main
function sudoku($field, $point) {
	// 空いているマスの探索
	$point = findEmptyPoint($field, $point);
	//空いているマスがないとき
		if($point === null){
			printField($field);
			return;
		}
	// 1〜9総当りで当てはめる
	for($num = 1; $num <= 9 ; $num ++) {
		//$numが$pointに置けるか
		if(checkPoint( $field, $point, $num)) {
			$field[$point['y']] [$point['x']] = $num;
			//次のマスへ
			sudoku($field, $point);
		}
	}
}

// 空いているマスを取得
function findEmptyPoint($field, $point) {
	while ( $point['y'] < Y_MAX ) {
		while ( $point['x'] < X_MAX ) {
			// 空いているマスが存在
			if ($field[$point['y']][$point['x']] === 0) {
				return $point;
			}
			$point['x']++;
		}
		$point['x'] = 0;
		$point['y']++;
	}
	//空いているマスが存在しない
	return null;
}

// 値がマスに入れられるかチェックする
function checkPoint($field, $point, $num) {
	$usedNums = array_fill( 0, 10, 0 );
	//使えない数字（既に使われている数字）にフラグを立てる
	for($i = 0; $i < 9; $i++) {
		$usedNums[$field [$point['y']] [$i]] = true;
	}

	for($i = 0; $i < 9; $i++) {
		$usedNums[$field [$i] [$point['x']]] = true;
	}
	for($i = 0; $i < 3; $i++) {
		for($j = 0; $j < 3; $j ++) {
			$usedNums[$field [ floor ($point['y'] / 3 ) * 3  + $i ]  [ floor($point['x'] / 3 ) * 3 + $j] ] = true;
		}
	}
	return ! $usedNums[$num];
}

// フィールド標準出力
function printField($field){
	echo '======='.PHP_EOL;
	for($i = 0; $i < 9; $i ++) {
		for($j = 0; $j < 9; $j ++) {
			echo $field [$i] [$j].' ';
		}
		echo PHP_EOL;
	}
	echo '======='.PHP_EOL;
}
