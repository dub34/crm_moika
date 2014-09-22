<?php

namespace app\modules\employee\models;

class Employee extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $employeename;
    public $password;
    public $authKey;
    public $accessToken;

    private static $employees = [
        '100' => [
            'id' => '100',
            'employeename' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'employeename' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return isset(self::$employees[$id]) ? new static(self::$employees[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$employees as $employee) {
            if ($employee['accessToken'] === $token) {
                return new static($employee);
            }
        }

        return null;
    }

    /**
     * Finds employee by employeename
     *
     * @param  string      $employeename
     * @return static|null
     */
    public static function findByEmployeename($employeename)
    {
        foreach (self::$employees as $employee) {
            if (strcasecmp($employee['employeename'], $employeename) === 0) {
                return new static($employee);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current employee
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
