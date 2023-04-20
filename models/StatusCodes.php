<?php

namespace app\models;

use yii\db\ActiveRecord;

class StatusCodes extends ActiveRecord
{
	public function getInterests()
	{
		return $this->hasMany(Interests::class, ['status_id' => 'status_id']);
	}
}