<?php

namespace app\models;

use yii\db\ActiveRecord;

class Interests extends ActiveRecord
{
	public function getInstruments()
	{
		return $this->hasOne(Instruments::class, ['ins_code' => 'ins_code']);
	}
	
	public function getStatusCodes()
	{
		return $this->hasOne(StatusCodes::class, ['status_id' => 'status_id']);
	}

	public function new()
    {
		$this->status_id = 1;
		$this->record_date = date("Y-m-d H:i:s");
		$this->save();
        return true;
    }
	
	public function updateCustom()
    {
		$this->record_date = date("Y-m-d H:i:s");
		$this->save();
        return true;
    }
	
	public function remove()
    {
		$this->delete();
        return true;
    }
	
	public function approve()
    {
		$this->status_id = 2;
		$this->save();
        return true;
    }
	
	public function cancel()
    {
		$this->status_id = 3;
		$this->save();
        return true;
    }

	public function rules()
	{
		return [
			[['ins_code', 'interest_rate', 'payment_date'], 'required']
		];
	}
}