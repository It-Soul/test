<?php

class EditorMenu extends CWidget
{
    public function run()
    {
        $url = explode('/', Yii::app()->request->url);

        $this->render('editor-menu', array(
            'active' => end($url)
        ));
    }
}