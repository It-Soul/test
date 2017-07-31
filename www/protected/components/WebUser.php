<?php
class WebUser extends CWebUser {
    private $_model = null;

    function getRole() {
        if($user = $this->getModel()){
            // в таблице User есть поле role
            return $user->role;
        }
    }
    function getOrganisation()
    {
        $user = $this->loadOrganisation(Yii::app()->user->id);
        return $user->organisation;
    }
    function getProvider()
    {
        $user  = ProviderPerson::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
       if ($user->status==1)
        return true;
        else{
            return false;
        }
    }

    private function loadOrganisation($id=null){

        if($this->_model===null)
        {
            if($id!==null)
                $this->_model=Users::model()->findByPk($id);
        }
        return $this->_model;
    }
    private function getModel(){
        if (!$this->isGuest && $this->_model === null){
            $this->_model = Users::model()->findByPk($this->id, array('select' => 'role'));
        }
        return $this->_model;
    }
}