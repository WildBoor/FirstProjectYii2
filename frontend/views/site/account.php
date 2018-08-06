<?php
use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Аккаунт';
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-5 col-sm-4 col-md-3 col-lg-4">
            <?php if ($role == 1) :?>
            <h3>Админ</h3>
            <?php endif; ?>
            <?php if ($role !== 1) :?>
                <h3>Контрагент: <?= $username?></h3>
            <?php endif; ?>
        </div>
        <div class="col-xs-2 col-sm-4 col-md-6 col-lg-4"></div>
        <div class="col-xs-5 col-sm-4 col-md-3 col-lg-4">
            <h4>Ваш счёт: <?= $bill ?></h4>
            
            <h4>Сумма на счёте: <?= $amount?></h4>
        </div>
    </div>
</div>
    <?php  if($role !== 1) :?>
    <div class="row" style="padding: 10%">
        <div class="col-xs-1 col-sm-2 col-md-2 col-lg-2"></div>
        <div class="col-xs-5 col-sm-4 col-md-4 col-lg-4">
            <?= Html::a('<h4><span class="glyphicon glyphicon-list"></span> История переводов</h4>',
                Url::to(['/site/operations'],true),
                ['class' => 'btn btn-default']);
            ?>
        </div>

        <div class="col-xs-5 col-sm-4 col-md-4 col-lg-4">
            <?= Html::a('<h4><span class="glyphicon glyphicon-usd"></span>Перевод средств</h4>',
                Url::to(['/site/transfer'],true),
                ['class' => 'btn btn-default']);
            ?>
        </div>
        <div class="col-xs-1 col-sm-2 col-md-2 col-lg-2"></div>
    </div>
    <?php endif; ?>

    <?php  if($role == 1) :?>
    <div class="container-fluid">
      <div class="row" style="margin-top: 6%">
            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
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
                <br>
                <div>
                    <?= Html::a('<h4><span class="glyphicon glyphicon-usd"></span> Перевод средств</h4>',
                        Url::to(['/site/transfer'],true),
                        ['class' => 'btn btn-default']);
                    ?>
                </div>
                <br>
            </div>
      </div>
    </div>
    <?php endif; ?>


