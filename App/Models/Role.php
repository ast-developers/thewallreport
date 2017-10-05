<?php

namespace App\Models;

use Core\Model;


/**
 * Class Role
 * @package App\Models
 */
class Role extends Model
{

    /**
     * @var mixed
     */
    public $db;

    /**
     * @var array
     */
    protected $permissions;

    /**
     *
     */
    public function __construct()
    {
        $this->db          = static::getDB();
        $this->dbTable     = 'roles';
        $this->permissions = array();
    }

    /**
     * @return bool
     */
    public function getRoles()
    {

        $sql = "SELECT * FROM $this->dbTable";
        $stm = $this->db->prepare($sql);
        $res = $stm->execute();

        if ($res) {
            $row = $stm->fetchAll(\PDO::FETCH_ASSOC);
            return $row;
        } else {
            return false;
        }
    }

    /**
     * return a role object with associated permissions
     * @param $role_id
     * @return Role
     */
    public function getRolePerms($role_id)
    {
        $role = new Role();
        $sql
              = "SELECT p.value FROM role_permission as rp
                JOIN permissions as p ON rp.permission_id = p.id
                WHERE rp.role_id = :role_id";
        $stm  = $this->db->prepare($sql);
        $stm->execute(array(":role_id" => $role_id));

        while ($row = $stm->fetch(\PDO::FETCH_ASSOC)) {
            $role->permissions[$row["value"]] = true;
        }
        return $role;
    }

    /**
     * check if a permission is set
     * @param $permission
     * @return bool
     */
    public function hasPerm($permission)
    {
        return isset($this->permissions[$permission]);
    }

}
