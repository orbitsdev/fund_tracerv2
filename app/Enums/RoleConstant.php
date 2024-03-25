<?php
namespace App\Enums;

class RoleConstant{

    public const ADMIN = 'Admin';
    public const FINANCE_MANAGER = 'Finance Manager';
    public const STAFF = 'Staff';


    public const ROLES = [
        self::STAFF =>  self::STAFF,
        self::FINANCE_MANAGER =>  self::FINANCE_MANAGER,
        self::ADMIN =>  self::ADMIN,

    ];

}
