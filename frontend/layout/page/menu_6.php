<?php
$listCatChild = arrSearch($menuTable,"pa=={$fileId}");
$listCatChildId[] = $pageInfo["db"]["id"];
$strCheckIn = "in";
if(!empty($listCatChild)) {
    foreach ($listCatChild as $key => $value) {
        $listCatChildId[]=$value["id"];
    }
}

$strFilerUrl = "/api/post/answers?match=questionnaires&test=useranwsersList&localstorage=listanswers";

$viewItemList = isset($pageInfo["more"]["showItem"]) && !empty($pageInfo["more"]["showItem"]) ? $pageInfo["more"]["showItem"] : 1;

$strElement = '{"geturl":"'.$strFilerUrl.'",
	"viewItemList":'.$viewItemList.',
	"limit":"10","id":"'.$pageInfo["db"]["id"].'","cat":"'.implode(',', $listCatChildId).'"}';
?>
<div class="row page-subject-category" >
	<div class="col-xs-12 col-sm-8 col-md-9 pull-right">
		<form class="post-form form-horizontal">
			<div class="localstorage-input-hidden" 
				data-elm-data='<?=$strElement?>'
				data-elm-data-has-old="elm" 
				data-copy-template="" 
				data-view-template-local="true" 
				data-view-template=".localstorage-input-hidden" 
				data-storage="listanswers" 
				data-set-storage-to-window="languageText.dropdownLocalOption.listanswers" 
				data-template-id="entryAnswerFormInput"></div>
		</form>
	</div>
	<div class="col-xs-12 col-sm-4 col-md-3">
		<div class="subject-category" data-copy-template="" data-view-template-local="true" data-option-local="menuStructure" data-object="menuStructure" data-filter-in="opp=6" data-view-template=".subject-category" data-template-id="entryLinkCategory"></div>
	</div>
</div>