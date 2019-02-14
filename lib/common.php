<?php

function htmlEsc($item){
	return htmlspecialchars($item, ENT_HTML5, 'UTF-8');
}
?>