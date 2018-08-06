<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Импорт данных';
?>
<div class="site-index">
    <div class="jumbotron">
        <?php  if(Yii::$app->user->isGuest) :?>
        <p>Пройдите регистрацию или совершите вход:</p>
        </br>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <?= Html::a('<h4><span class="glyphicon glyphicon-plus"></span> Регистрация</h4>',
                Url::to(['/site/signup'],true),
                ['class' => 'btn btn-default']);
            ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <?= Html::a('<h4><span class="glyphicon glyphicon-home"></span> Вход</h4>',
                Url::to(['/site/login'],true),
                ['class' => 'btn btn-default']);
            ?>
        </div>
        <?php endif; ?>

        <?php  if(!(Yii::$app->user->isGuest)) :?>
            <div class="row">
                <div class="col-xs-1 col-sm-3 col-md-3 col-lg-3"></div>
                <div class="col-xs-1 col-sm-6 col-md-6 col-lg-6">
                    <?= Html::a('<h4><span class="glyphicon glyphicon-home"></span> Аккаунт</h4>',
                        Url::to(['/site/account'],true),
                        ['class' => 'btn btn-default']);
                    ?>
                </div>
                <div class="col-xs-1 col-sm-3 col-md-3 col-lg-3"></div>
            </div>
        <?php endif; ?>

    </div>
</div>

