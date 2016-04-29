<?php

class ModelConditionFactory
{
    public function  __construct($model, $params)
    {
        $this->model = $model;
        $this->filter = $params['filter'];
        $this->text = $params['text'];
    }

    public function produce()
    {
        switch($this->model) {
            case 'User':
                return $this->getUserCondition();
            case 'Item':
                return $this->getItemCondition();
            case 'Customer':
                return $this->getCustomerCondition();
            case 'Transaction':
                return $this->getTransactionCondition();
            default:
                return [];
        }
    }

    private function getUserCondition()
    {
        switch($this->filter) {
        case 'username':
            return ['User.username LIKE' => '%' . $this->text . '%'];
        case 'display_name':
            return ['User.display_name LIKE' => '%' . $this->text . '%'];
        default:
            return [];
        }
    }

    private function getItemCondition()
    {
        switch($this->filter) {
        case 'item_name':
            return ['Item.item_name LIKE' => '%' . $this->text . '%'];
        default:
            return [];
        }
    }

    private function getCustomerCondition()
    {
        switch($this->filter) {
        case 'name':
            return ['Customer.name LIKE' => '%' . $this->text . '%'];
        case 'address':
            return ['Customer.address LIKE' => '%' . $this->text . '%'];
        case 'group':
            return ['Group.name LIKE' => '%' . $this->text . '%'];
        default:
            return [];
        }
    }

    private function getTransactionCondition()
    {
        switch($this->filter) {
        case 'id':
            return ['Transaction.transaction_id LIKE' => '%' . $this->text . '%'];
        case 'item_name':
            return ['Item.item_name LIKE' => '%' . $this->text . '%'];
        case 'name':
            return ['Customer.name LIKE' => '%' . $this->text . '%'];
        case 'type':
            return ['Transaction.type LIKE' => '%' . $this->text . '%'];
        case 'payed':
            return ['Transaction.payed' => 1];
        default:
            return [];
        }
    }
}
