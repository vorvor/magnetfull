<style>

	#table {
		width:  3000px;
	}

	#table-header {
		display: flex;

		top: 0;
	}

	.product {
		padding:  6px 0;
	}

	.details {
		display: flex;
	}

	.data, .header-label {
		border-bottom:  1px solid #ccc;
		flex-basis: 200px;
		flex-grow: 0;
		flex-shrink: 0;
	}

	.history-row {
		display: flex;
	}

	.date {
		width:  200px;
	}
</style>
<?php


// Parse hash codes.
$data = file_get_contents('./codes.json');
$rows = preg_match_all('/{"name":"(.*?)","value":"(.*?)"}/i', $data, $matches);

$map = [];
for ($c = 0; $c < count($matches[1]); $c++) {
	$map[$matches[2][$c]] = $matches[1][$c];
}

// Parse states
$rows = preg_match_all('/{"id":"(.*?)".*?"name":"(.*?)"/i', $data, $matches);
$map_states = [];
for ($c = 0; $c < count($matches[1]); $c++) {
	$map_states[$matches[1][$c]] = $matches[2][$c];
}


// Parse users.
$data = file_get_contents('./users.json');
$rows = preg_match_all('/{"id":(\d*?),"username":"(.*?)","email"/i', $data, $matches);

$users = [];
for ($c = 0; $c < count($matches[1]); $c++) {
	$users[$matches[1][$c]] = $matches[2][$c];
}

print "<pre>";
//print_r($map_states);
print "</pre>";


$json = file_get_contents('./data.json');
$data = json_decode($json, false);


function map($data) {

	global $map;

	$translate = '';
	if (isset($map[$data])) {
		$translate = $map[$data];
		return $translate;
	}

	return $data;
}

function mapUser($uid) {
	global $users;
	if (!empty($uid)) {
		return $users[$uid];
	}

	return '(empty)';
}

function mapState($hash) {
	global $map_states;

	if (isset($map_states[$hash])) {
		return $map_states[$hash];
	}

	return $hash;
}


$c = 0;
//$test = [1309];
$output[] = '<div id="table">';
$product_rebuild = [];
$products_rebuild = [];
$fields = ['serial', 'material', 'scale', 'scale_notes', 'bn', 'material_batch', 'tuner', 'serial2', 'comment', 'deadline', 'purpose', 'customer', 'contact', '100%', 'sale', 'location', 'raktar'];


foreach ($data as $key => $product) {

	if (!isset($test) || in_array($product->count, $test)) {

		$product_rebuild['worker'] = mapUser($product->workshopOwnerId);

		// Detailed data.
		$i = 0;
		foreach ($product->details as $key => $detail) {
			$value = map($detail);
			$product_rebuild[$fields[$i]] = $value;
			$i++;
		}

		// History.
		$history_in_row = '';
		$last_state = '';
		foreach ($product->history as $key => $history) {
			if (isset($history->workflowId)) {
				$state = mapState($history->workflowId);
				if ($state !== $last_state) {
					$product_rebuild['history'][$history->time] = $state;
				}
				$last_state = $state;
			}
		}

		$products_rebuild[$product->count] = $product_rebuild;

		$c++;
		if ($c > 200) {
			break;
		}
	}
}
$output[] = '</div>';

ksort($products_rebuild);

//print_r($products_rebuild);

$fields = ['serial', 'material', 'scale', 'scale_notes', 'bn', 'material_batch', 'tuner', 'serial2', 'comment', 'deadline', 'purpose', 'customer', 'contact', '100%', 'sale', 'location', 'raktar'];

$new_field_order = ['serial', 'worker', 'material', 'scale', 'scale_notes', 'bn', 'material_batch', 'tuner', 'serial2', 'comment', 'deadline', 'purpose', 'customer', 'contact', '100%', 'sale', 'location', 'raktar'];

$output = [];
$output[] = '<div id="table">';
$output[] = '<div id="table-header">';
foreach ($new_field_order as $field) {
	$output[] = '<div class="header-label">' . $field . '</div>';
}
$output[] = '</div>';
foreach ($products_rebuild as $product) {
	$output[] = '<div class="product">';
	$output[] = '<div class="details">';
	foreach ($new_field_order as $field) {
		$output[] = '<div class="data">' . $product[$field] . '</div>';	
	}
	$output[] = '</div>';

	/*
	$output[] = '<div class="history">';
	foreach ($product['history'] as $date => $state) {
		$output[] = '<div class="history-row"><div class="date">' . date('Y-m-d H:i', $date / 1000) . '</div><div class="state">' . $state . '</div></div>';
	}
	$output[] = '</div>';
	*/
	
	$output[] = '</div>';

}
$output[] = '</div>';

print implode($output);



print "<pre>";
print_r($data);
print "</pre>";