<?php

namespace GO\Yubico;

require_once 'vendor/Yubico.php';

class YubicoModule extends \GO\Base\Module
{
    /**
     * Return package type
     *
     * @return string
     */
    public function package()
    {
        return self::PACKAGE_COMMUNITY;
    }

    /**
     * Return the name of the author.
     *
     * @return string
     */
    public function author()
    {
        return 'Michal Charvát';
    }

    /**
     * Return the e-mail address of the author.
     *
     * @return string
     */
    public function authorEmail()
    {
        return 'info@michalcharvat.cz';
    }

    /**
     * Return copyright information
     *
     * @return string
     */
    public function copyright()
    {
        return 'Copyright Michal Charvát';
    }

    /**
     * Return true if this module belongs in the admin menu.
     *
     * @return boolean
     */
    public function adminModule()
    {
        return true;
    }

    public static function initListeners()
    {
        $authController = new \GO\Core\Controller\AuthController();
        $authController->addListener('beforelogin', "GO\Yubico\YubicoModule", "checkToken");
    }

    public static function checkToken(array &$params, array &$response)
    {
        $oldIgnoreAcl = \GO::setIgnoreAclPermissions();

        $userModel = \GO\Base\Model\User::model()->findSingleByAttribute('username', $params['username']);
        if (!$userModel) {
            return false;
        }

        if (empty($userModel->yubico_client_id) || empty($userModel->yubico_key)) {
            \GO::setIgnoreAclPermissions($oldIgnoreAcl);
            return true;
        }

        $yubico = new \Auth_Yubico($userModel->yubico_client_id, $userModel->yubico_key);
        $res = $yubico->parsePasswordOTP($params['yubico_hash']);
        if ($res['prefix'] != $userModel->yubico_prefix) {
            $response['feedback'] = \GO::t('invalidPrex', 'yubico');
            $response['success'] = false;
            return false;
        }

        $auth = $yubico->verify($params['yubico_hash']);
        if (\Pear::isError($auth)) {
            $response['feedback'] = \GO::t($auth->message, 'yubico');
            $response['success'] = false;
            return false;
        }

        \GO::setIgnoreAclPermissions($oldIgnoreAcl);
        return true;
    }
}