<?php
/**
 * Created by victor
 * Date: 06.03.15
 * Time: 19:06
 * @var $services
 * @var $relatedServices
 */
use yii\helpers\Html;

?>


	<?php foreach ($services as $key => $service) : ?>
		<div class="col-sm-2">
			<?= Html::label($service->name); ?>
			<?= Html::input('number', 'Ticket[services_list][' . $service->id . ']',
				isset($relatedServices[$service->id]['count']) ?: false, ['class' => 'form-control', 'min' => 0]); ?>
		</div>
	<?php endforeach; ?>
