<?php function headerPanel($year){
$html = <<<"HTML"
<div class="page-menu">
    <img src="/consulting-logo.png" height=30>
    <p style="margin: 0px 20px;"> $year War Map calendar</p>
</div>
HTML;
return $html;
}