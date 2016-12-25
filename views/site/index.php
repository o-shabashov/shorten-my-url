<?php
use app\models\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var Url          $model
 */
?>

<div class="jumbotron">
    <?php
    Pjax::begin([
        'enablePushState' => false,
        'timeout'         => false,
    ]);
    $form = ActiveForm::begin(
        [
            'action'  => ['site/short'],
            'options' => [
                'data-pjax' => true,
            ],
        ]
    );

    echo $form->field($model, 'source')
              ->textarea([
                  'placeholder' => $model->getAttributeLabel('source'),
                  'rows'        => 3,
              ])
              ->label(false);

    echo Html::submitButton(Yii::t('app', 'Shorten me!'), ['class' => 'btn btn-success']);

    ActiveForm::end();

    Pjax::end();
    ?>
</div>
