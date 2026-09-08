<?php
if(isset($pageInfo["examCategory"]) && count($pageInfo["examCategory"])>0) {
	$strExamID = "examid{$pageInfo["db"]["id"]}";
	$strGetUrl = "/api/post/answers?match=questionnaires&test={$strExamID}&localstorage={$strExamID}&answerskey={$strExamID}&overwritepost=1";

	$strElement = '{"geturl":"'.$strGetUrl.'","examid":"'.$strExamID.'","exam":'.json_encode($pageInfo["examCategory"]).'}';

	foreach ($pageInfo["examCategory"] as $key => $value) {
		$fileMenu = FOLDERMENU . $value["id"] . ".xml";
		if (is_file($fileMenu)) {
			$pageMenuInfo = simplexml_load_file($fileMenu);
		    $pageMenuInfo = json_encode($pageMenuInfo);
		    $pageMenuInfo = json_decode($pageMenuInfo, true);
			$strFilterAttr = 'data-filter-init=\'[
			        {"name":"cat","value":"'.$value["id"].'","compare":"equal"},
			        {"name":"st","value":"'.$value["st"].'","compare":"equal"},
			        {"name":"le","value":"'.$value["le"].'","compare":"equal"}
			        ]\'';
		}
	}
?>

<form class="post-form form-horizontal">
	<div class="localstorage-input-hidden" 
		data-elm-data='<?=$strElement?>'
		data-elm-data-has-old="elm" 
		data-copy-template="" 
		data-view-template-local="true" 
		data-view-template=".localstorage-input-hidden" 
		data-storage="<?=$strExamID?>" 
		data-set-storage-to-window="languageText.dropdownLocalOption.<?=$strExamID?>" 
		data-refres-list=".show-answer-exam-category"
		data-template-id="entryAnswerFormInput">
	</div>
</form>

<?php
if (isset($_SESSION["adminlog"]) && $_SESSION["adminlog"] ) {
?>
<h3>List answer</h3>
<div class="post-form form-horizontal show-answer-exam-category" data-view-list-by-handlebar="" data-init-button-magic=".item [data-button-magic]" data-url="/api/get/answers?test=questionnaires_<?=$strExamID?>" data-method="get" data-show-page="10" data-show-item="10" data-show-all="false" data-scroll-view="false" data-form-filter=".form-filter" data-template-id="entryAnswersShowButton">
	<table class="table table-bordered">
		<colgroup> <col class="col-xs-1" /> 
			<col class="col-xs-2" /> 
			<col class="col-xs-8" /> 
			<col class="col-xs-1" /> 
		</colgroup>
		<thead>
			<tr>
				<td>#id</td>
				<td>Persional info</td>
				<td>Point</td>
				<td>Action</td>
			</tr>
		</thead>
		<tbody data-content="">
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
		</tbody>
	</table>
</div>
<?php
}

}
?>

