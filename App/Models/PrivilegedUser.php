<?php

namespace App\Models;

use App\Models\Role;
use App\Models\User;


/**
 * Class PrivilegedUser
 * @package App\Models
 */
class PrivilegedUser extends User
{

    /**
     * @var
     */
    private $roles;

    /**
     * PrivilegedUser constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *  override User method
     * @param $username
     * @return PrivilegedUser|bool
     */
    public static function getByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = :username";
        $sth = parent::getDB()->prepare($sql);
        $sth->execute(array(":username" => $username));
        $result = $sth->fetchAll();

        if (!empty($result)) {
            $privUser          = new PrivilegedUser();
            $privUser->user_id = $result[0]["id"];
            $privUser->initRoles($result[0]["id"]);
            return $privUser;
        } else {
            return false;
        }
    }

    /**
     * populate roles with their associated permissions
     * @param int $user_id
     */
    protected function initRoles($user_id = 0)
    {
        $roleModel   = new Role();
        $this->roles = array();
        $sql
                     = "SELECT users.role_id, roles.name FROM users
                JOIN roles ON users.role_id = roles.id
                WHERE users.id = :user_id";
        $stm         = $this->db->prepare($sql);
        $stm->execute(array(":user_id" => $user_id));

        while ($row = $stm->fetch(\PDO::FETCH_ASSOC)) {
            $this->roles[$row["name"]] = $roleModel->getRolePerms($row["role_id"]);
        }
    }

    /**
     * check if user has a specific privilege
     * @param $perm
     * @return bool
     */
    public function hasPrivilege($perm)
    {
        foreach ($this->roles as $role) {
            if ($role->hasPerm($perm)) {
                return true;
            }
        }
        return false;
    }
}
