<?php

class ImportHelper
{
    public static $maxFileRows = [
        'csv' => 50000,
        'xls' => 10000,
        'xlsx' => 10000
    ];

    /**
     * process uploaded price file
     * @param $data
     * @return mixed|string
     */
    public static function processPriceFile($data)
    {
        ini_set('max_execution_time', 7200);

        Yii::import('ext.phpexcel.XPHPExcel');

        $providerSettings = ProviderPerson::model()->findByAttributes(array('user_id' => $data['user_id']));

        $xls = XPHPExcel::loadPHPExcelIOFactory($data['filePath']);
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();

        $highestRow = $sheet->getHighestDataRow();
        if ($highestRow > self::$maxFileRows[$data['fileExtension']]) {
            $highestRow = self::$maxFileRows[$data['fileExtension']];
        }

        for ($row = 2; $row <= $highestRow; $row++) {
            $nColumn = PHPExcel_Cell::columnIndexFromString($sheet->getHighestDataColumn());

            $product = new Results_add();
            $product->user_id = $data['user_id'];
            $product->name = trim($sheet->getCellByColumnAndRow(0, $row)->getValue());
            $product->photo = '/' . Yii::getPathOfAlias('photos') . '/' . 'Nophoto.jpg';
            $product->cod = trim($sheet->getCellByColumnAndRow(1, $row)->getValue());
            $product->manufacturer = trim($sheet->getCellByColumnAndRow(2, $row)->getValue());
            $product->price = round((double)trim($sheet->getCellByColumnAndRow(3, $row)->getValue()), 2);
            $product->state = (int)trim($sheet->getCellByColumnAndRow(4, $row)->getValue());
            $product->weight = trim($sheet->getCellByColumnAndRow(5, $row)->getValue());
            $product->date = date('Y-m-d H:i:s', time());
            $product->currency = $data['currency'];
            $product->file_id = $data['file_id'];
            $product->last_check = date('Y-m-d H:i:s', time() + ($providerSettings->data_count * 24 * 60 * 60));
            if ($product->save(false)) {
                for ($col = 6; $col < $nColumn; $col++) {
                    if ($sheet->getCellByColumnAndRow($col, $row)->getValue()) {
                        $productNumber = new Numbers_add();
                        $productNumber->user_id = $data['user_id'];
                        $productNumber->results_add_id = $product->id;
                        $productNumber->number = trim(preg_replace('![^\/\w\d\-]*!', '', $sheet->getCellByColumnAndRow($col, $row)->getValue()));
                        $productNumber->save(false);
                    }
                }
            }
        }
        return $highestRow - 1;
    }
}