<?php

class ContactsService
{

    public $data;

    public function __construct(IData $data)
    {
        $this->data = $data;
    }

    public function getUser($limit = 1)
    {
        return $this->data->getUser($limit);
    }
}
