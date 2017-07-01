<?php

namespace app\models;

final class UserIdentity extends User implements \yii\web\IdentityInterface
{

    private static $access_token = "access_token";
    private static $users = [];

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::$users[$id];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = self::findOne([self::$access_token=>$token]);
        if(isset($user)){
            self::$users[$token] = $user;
        }
        return $user;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
//        return $this->getAttribute(self::$access_token);
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return null;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return null;
    }
}
