<?php

namespace app\models;

class PermissionForm extends AuthItem
{
    public function init()
    {
        parent::init();
        $this->type = AuthItem::TYPE_PERMISSION;
    }
}
