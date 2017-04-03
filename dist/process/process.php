<?php
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*');

function I($param){
	if(@$_POST[$param] != null){
		return @$_POST[$param];
	}else{
		return @$_GET[$param]; 
	}
}

function obj2array($stdclassobject)
{
    $_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;

    foreach ($_array as $key => $value) {
        $value = (is_array($value) || is_object($value)) ? obj2array($value) : $value;
        $array[$key] = $value;
    }

    return $array;
}

$liveurl = trim(I('liveurl'));
$bgimg = I('bgimg');
$displayimg = I('displayimg');
$qrimg = I('qrimg');
$qrintro = I('qrintro');
$tabs = json_decode(I('tabs'));

if($liveurl == '' || $bgimg == '' || $displayimg == '' || $qrimg == '' || $qrintro == '') {

	echo '<div class="build-error">';
	if ($liveurl == '') {
		echo '<p><span class="error-danger">直播间地址</span>不能为空</p>';
	}
	if ($bgimg == '') {
		echo '<p><span class="error-danger">背景图片地址</span>不能为空</p>';
	} 
	if ($displayimg == '') {
		echo '<p><span class="error-danger">头像图片地址</span>不能为空</p>';
	} 
	if ($qrimg == '') {
		echo '<p><span class="error-danger">二维码图片地址</span>不能为空</p>';
	}
	if ($qrintro == '') {
		echo '<p><span class="error-danger">二维码介绍</span>不能为空</p>';
	} 
	if (count($tabs) == 0) {
		echo '<p>请最少添加一个<span class="error-danger">选项卡</span></p>';
	}
	echo "</div>";
	return;
}

$tabArr = array();
foreach ($tabs as $key => $value) {
	$element = obj2array($value);

	$element['intro'] = nl2br($element['intro']);
	$element['colorlow'] = preg_replace("/,(\s?\d+.\d+)\)/U", ",0.4)", $element['color']);
	$element['colorhigh'] = preg_replace("/,(\s?\d+.\d+)\)/U", ",0.95)", $element['color']);

	$tabArr[] = $element;
}

include "model.php";