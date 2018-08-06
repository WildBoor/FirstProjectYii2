<?php
namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $excelTable;

    public function rules()
    {
        return [
            [['excelTable'], 'file', 'skipOnEmpty' => false,
               // 'extensions' => 'xls'
                ],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->excelTable->saveAs('uploads/' . $this->excelTable->baseName . '.' . $this->excelTable->extension);
            return true;
        } else {
            return false;
        }
    }
}