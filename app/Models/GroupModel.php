<?php

namespace App\Models;
use CodeIgniter\Model;

class GroupModel extends Model
{
    protected $table      = 'group';
    protected $primaryKey = 'id_group';
    protected $useAutoIncrement = false;
    protected $returnType = 'object';
    protected $allowedFields = ['name_group'];
    // protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}