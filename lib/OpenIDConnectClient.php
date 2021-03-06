<?php
/**
 * ownCloud - useroidc
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Sigmund Augdal <sigmund.augdal@uninett.no>
 * @copyright Sigmund Augdal 2016
 */

namespace OCA\UserOidc;

use OCP\IConfig;

class OpenIDConnectClient {

    private $config, $oidc, $provider;

	public function __construct(IConfig $config) {
        $this->config = $config;
        $this->oidc = NULL;
        $this->provider = NULL;
    }

    public function setProvider($provider) {
        $this->provider = $provider;
        $oidc_config = $this->config->getSystemValue('openid_connect')[$provider];
        $oidc = new \OpenIDConnectClient($oidc_config['provider'], $oidc_config['client_id'], $oidc_config['client_secret']);
        $this->oidc = $oidc;
    }

    public function addScope($scope) {
        $this->oidc->addScope($scope);
    }

    public function setRedirectUrl($url) {
        $this->oidc->setRedirectUrl($url);
    }

    public function requestUserInfo($info) {
        return $this->oidc->requestUserInfo($info);
    }

    public function authenticate() {
        $this->oidc->authenticate();
    }

    public function getAccessToken() {
        return $this->oidc->getAccessToken();
    }
}
