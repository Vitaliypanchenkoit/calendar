<?php

namespace App\PersistModule;

interface PersistInterface
{
    public function create(array $data);
    public function update(array $data);
}
