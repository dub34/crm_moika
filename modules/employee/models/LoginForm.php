<?php

namespace app\modules\employee\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $employeename;
    public $password;
    public $rememberMe = true;

    private $_employee = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // employeename and password are both required
            [['employeename', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $employee = $this->getEmployee();

            if (!$employee || !$employee->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect employeename or password.');
            }
        }
    }

    /**
     * Logs in a employee using the provided employeename and password.
     * @return boolean whether the employee is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getEmployee(), $this->rememberMe ? 3600*24*30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds employee by [[employeename]]
     *
     * @return Employee|null
     */
    public function getEmployee()
    {
        if ($this->_employee === false) {
            $this->_employee = Employee::findByEmployeename($this->employeename);
        }

        return $this->_employee;
    }
}
