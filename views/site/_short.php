<?php
use app\models\Url;
use yii\bootstrap\Html;

/**
 * @var yii\web\View $this
 * @var Url          $model
 */

echo Html::textarea('short', $model->getShortUrl(), ['class' => 'form-control', 'rows' => 3]);

$this->registerJs('
$(document).ready(function() {
    $("textarea")
        .focus(function () { $(this).select(); } )
        .mouseup(function (e) {e.preventDefault(); });
});

$("textarea").focus();
');
