<?php
use yii\grid\GridView;
use common\models\User;
use common\models\Operation;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Список';
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-5 col-sm- col-md-3 col-lg-4">
            <?php if ($role == 1) :?>
                <h3>Админ</h3>
            <?php endif; ?>
            <?php if ($role !== 1) :?>
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
<div class="row">
    <?php if ($role == 1) :?>
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
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
        </div>
    <?php endif; ?>
    <?php if ($role !== 1) :?>
        <div class="col-xs-10 col-sm-3 col-md-3 col-lg-3">
            <?= Html::a('<h4><span class="glyphicon glyphicon-usd"></span> Перевод средств</h4>',
                Url::to(['/site/transfer'],true),
                ['class' => 'btn btn-default']);
            ?>
        </div>
    <?php endif; ?>

    <div class="col-xs-10 col-sm-9 col-md-9 col-lg-9" >
        <h4 >Cписок контрагентов</h4>
        <?php if ($role !== 1){

                echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'pager' => ['maxButtonCount' => 5],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Отправитель',
                        'attribute' => 'email_from',
                        'value' => function ($data) {
                            return $data->email_from;
                        }

                    ],
                    [
                        'label' => 'Получатель',
                        'attribute' => 'email_to',
                        'value' => function ($data) {
                            return $data->email_to;
                        }

                    ],
                    [
                        'label' => 'Сумма перевода',
                        'attribute' => 'transfer_amount',
                        'value' => function ($data) {
                            return $data->transfer_amount;
                        }

                    ],
                    
                    [
                        'label' => 'Дата создания',
                        'attribute' => 'created_at',
                        'value' => function ($data) {return $data->created_at;}
                    ],
                    // 'comment',
                    // ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
        } else {
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'pager' => ['maxButtonCount' => 5],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Контрагент',
                        'attribute' => 'username',
                        'value' => function ($data) {
                            return $data->username;
                        }

                    ],
                    [
                        'label' => 'Email',
                        'attribute' => 'email',
                        'value' => function($data){return $data->email;}

                    ],
                    [
                        'label' => 'Дата создания',
                        'attribute' => 'created_at',
                        'value' => function ($data) {
                            return $data->created_at;
                        }

                    ],

                    // ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
        }
         ?>

    </div>
</div>