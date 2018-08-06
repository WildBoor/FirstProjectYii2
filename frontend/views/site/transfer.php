<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\User;

$this->title = 'Перевод средств';
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-5 col-sm-4 col-md-3 col-lg-4">
            <?php if (User::findOne(Yii::$app->user->id)->getId() == 1) :?>
            <h3>Админ</h3>
            <?php endif; ?>
            <?php if (User::findOne(Yii::$app->user->id)->getId() !== 1) :?>
                <h3>Контрагент: <?= $username?></h3>
            <?php endif; ?>
        </div>
        <div class="col-xs-2 col-sm-4 col-md-6 col-lg-4"></div>
        <div class="col-xs-5 col-sm-4 col-md-3 col-lg-4">
            <h4>Ваш счёт: <?= $bill?></h4>
            <br>
            <h4>Сумма на счёте: <?= $amount?></h4>
        </div>
    </div>
</div>
<div class="container">
    <div class="row" style="padding: 3%">
        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
            <?php
            $form = ActiveForm::begin([
                'id' => 'transfer-form',
                'options' => ['class' => 'form-horizontal'],
            ]) ?>
            <?= $form->field($model, 'email_to')->input('email')->label('Email получателя'); ?>
            <?= $form->field($model, 'transfer_amount')->label('Сумма перевода')?>

            <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
        <div class="col-xs-1 col-sm-3 col-md-3 col-lg-3"> </div>
        <?php if (User::findOne(Yii::$app->user->id)->getId() == 1) :?>
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                <div>
                    <?= Html::a('<h4><span class="glyphicon glyphicon-list"></span> Список контрагентов</h4>',
                        Url::to(['/site/list'],true),
                        ['class' => 'btn btn-default']);
                    ?>
                </div>
                <br>
                <div>
                    <?= Html::a('<h4><span class="glyphicon glyphicon-list"></span> Список переводов</h4>',
                        Url::to(['/site/operations'],true),
                        ['class' => 'btn btn-default']);
                    ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if (User::findOne(Yii::$app->user->id)->getId() !== 1) :?>
            <div class="col-xs-10 col-sm-3 col-md-3 col-lg-3">
                <?= Html::a('<h4><span class="glyphicon glyphicon-list"></span> История переводов</h4>',
                    Url::to(['/site/operations'],true),
                    ['class' => 'btn btn-default']);
                ?>
            </div>
        <?php endif; ?>
    </div>
</div>