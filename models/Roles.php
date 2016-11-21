<?php

namespace app\models;
use yii\rbac\Item;

class Roles extends AuthItem
{
	public $child;

    public function init()
    {
        parent::init();
        $this->type = Item::TYPE_ROLE;
    }

}
