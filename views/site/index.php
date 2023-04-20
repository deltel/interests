<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap5\ActiveForm;
use yii\jui\DatePicker;
?>
<h1>Interests</h1>
<section>
    <a href=<?= Url::to(['site/new']) ?>>New</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Instrument</th>
                <th>Payment Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($interests as $interest): ?>
        
                <tr>
                    <td><?= $interest->interest_id ?></td>
                    <td><?= $interest->instruments->description ?></td>
                    <td><?php
                        $date=date_create($interest->payment_date);
                        echo date_format($date,"d/m/Y");
                        ?></td>
                    <td><?= $interest->statusCodes->status_name ?></td>
                    <td>
                        <ul>
                            <?php if($interest->statusCodes->status_id == 1): ?>
                                <li><a href=<?= Url::toRoute(['site/edit', 'id' => $interest->interest_id]) ?>>Edit</a></li>
                                <li><a href=<?= Url::toRoute(['site/delete', 'id' => $interest->interest_id]) ?>>Delete</a></li>
                                <li><a href=<?= Url::toRoute(['site/approve', 'id' => $interest->interest_id]) ?>>Approve</a></li>
                            <?php elseif($interest->statusCodes->status_id == 2): ?>
                                <li><a href=<?= Url::toRoute(['site/cancel', 'id' => $interest->interest_id]) ?>>Cancel</a></li>
                            <?php endif; ?>
                        </ul>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>


<?= LinkPager::widget(['pagination' => $pagination]) ?>