<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\User;

class UserModel extends Model
{
    protected $table      = 'user';
    protected $primaryKey = 'id_user';

    protected $useAutoIncrement = false;

    protected $returnType = User::class;
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_user','username', 'usersurname','dniUsuario','userBirthday','useradress','usertel','useremail','password','tokenPassword','dateTokenPassword','id_group'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $assignGroup;
    protected $timeTokenPassword;
    protected $beforeInsert = ['addGroup'];
    // protected $beforeUpdate = ['addTimeToken'];

    protected function addGroup($data)
    {
        $data['data']['id_group'] = $this->assignGroup;
        
        return $data;
    }
    // protected function addTimeToken($data)
    // {
    //     $data['data']['updated_at'] = $this->assignGroup;
        
    //     return $data;
    // }
    public function getUserBy(string  $column,string  $value)
    {
        return $this->where($column,$value)->first();
    }
    public function getUserByParameterize(array $data)
    {
        return $this->where($data)->first();
    }

    public function withGroup(string $group)
    {
        $row= $this->db->table('group')->where('name_group',$group)->get()->getFirstRow();
        if ($row != null ) {
            $this->assignGroup= $row->id_group;
        }
        // d($row);
    }
    // protected $validationRules    = [];
    // protected $validationMessages = [];
    // protected $skipValidation     = false;
}