<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class DistrictUploadForm extends Model
{
	public $excelFile;
	public $filename;

	public function rules()
	{
		return [
			[['excelFile'], 'file', 'skipOnEmpty'=>false],
		];
	}

	public function upload()
	{
		if ($this->validate()) {
			$this->filename = Yii::getAlias('@webroot/uploads/') . date('YmdHis') . uniqid() . '.' . $this->excelFile->extension;
			$this->excelFile->saveAs($this->filename);
			return true;
		} else {
			return false;
		}
	}
}