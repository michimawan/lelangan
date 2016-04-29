<?php

class FilterFactory
{
    public function  __construct($model)
    {
        $this->model = $model;
    }

    public function produce()
    {
        switch($this->model) {
            case 'User':
                return $this->getUserFilter();
            case 'Item':
                return $this->getItemFilter();
            case 'Customer':
                return $this->getCustomerFilter();
            case 'Transaction':
                return $this->getTransactionFilter();
            default:
                return [];
        }
    }

    private function getUserFilter()
    {
        return [
            'all' => 'Show All',
            'username' => 'Username',
            'display_name' => 'Display Name',
        ];
    }

    private function getItemFilter()
    {
        return [
            'all' => 'Show All',
            'item_name' => 'Item Name',
        ];
    }

    private function getCustomerFilter()
    {
        return [
            'all' => 'Show All',
            'name' => 'Customer Name',
            'address' => 'Address',
            'group' => 'Group',
        ];
    }

    private function getTransactionFilter()
    {
        return [
            'all' => 'Show All',
            'id' => 'Transaction ID',
            'item_name' => 'Item Name',
            'name' => 'Winner',
            'type' => 'Auction Type',
            'payed' => 'Payment Status'
        ];
    }
}
