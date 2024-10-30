<?php

namespace Megamo;

require_once MGO_PLUGIN_DIR . '/includes/services/class-mgosync-service.php';
require_once MGO_PLUGIN_DIR . '/includes/class-megamo-api-rest-client.php';

class Megamo_Service
{

    private $mgosync_service;
    private $megamo_api_client;
    private $shopUrl;

    private $platform = 'woocommerce';

    public function __construct()
    {

        $this->mgosync_service = new MgoSync_Service();
        $this->shopUrl = \get_option('siteurl');
        $megamo_api_key = $this->get_megamo_apikey();

        if (!empty($megamo_api_key)) {
            $this->megamo_api_client = new Megamo_Api_Rest_Client(MEGAMO_SERVICE_URL, $megamo_api_key, MGO_VERSION);
        }
    }

	public function prepare_registration_link()
	{
		return $this->prepare_link("authshop");
	}

	public function prepare_integration_panel_link()
	{
		return $this->prepare_link("myadmin");
	}
    public function prepare_link($slug)
    {

        $userId = \get_current_user_id();
        $userData = \get_userdata($userId);

        $mgoSyncToken = $this->mgosync_service->get_mgosync_api_access_token($this->shopUrl);

        $suggestedUserName = str_replace(['http://', 'https://', '/'], [
            '',
            '',
            '-'
        ], $this->shopUrl);

        $registerAtMegamoBaseUrl = MEGAMO_SERVICE_URL . "/{$slug}";
        $registerAtMegamoUrlUrlParts = [
            "platform" => $this->platform,
            "token" => $mgoSyncToken,
            "name" => $suggestedUserName,
            "username" => $suggestedUserName,
            "email" => $userData->user_email,
            "url" => urlencode($this->shopUrl),
            "callback_url" => urlencode($this->shopUrl . '/wp-json/' . MGO_SYNC_API_NAMESPCE . '/ad'),
        ];

        $registerAtMegamoUrl = $registerAtMegamoBaseUrl . "?" . http_build_query($registerAtMegamoUrlUrlParts);

        return $registerAtMegamoUrl;
    }

    public function get_megamo_apikey()
    {

        return \get_option('megamo_api_key');
    }

    public function update_megamo_apikey(string $new_value)
    {

        return \update_option('megamo_api_key', $new_value);
    }

    public function update_shop_access()
    {

        if (is_null($this->megamo_api_client)) {
            return false;
        }

        try {
            $shop = $this->find_shop($this->shopUrl);
            $shopParams = $this->get_shop_params();

            if (is_null($shop)) {
                $this->register_shop($shopParams);
                return true;
            }

            $this->megamo_api_client->update_shop($shop['id'], $shopParams);
        } catch (\Exception $e) {
            throw $e;
        }

        return true;
    }

    public function register_shop(array $shopParams)
    {

        try {
            $add_shop_response = $this->megamo_api_client->add_shop($shopParams);
        } catch (\Exception $e) {
            throw $e;
        }

        return $add_shop_response;
    }

    private function find_shop(string $url, ?string $domain = null)
    {

        try {
            $shops = $this->megamo_api_client->get_shops();;
            //by url
            foreach ($shops as $shop) {
                if ($url === $shop['url']) {
                    return $shop;
                }
            }

            //by domain
            if ($domain) {
                foreach ($shops as $shop) {
                    if ($domain === $shop['domain']) {
                        return $shop;
                    }
                }
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return null;
    }

    private function get_shop_params()
    {

        $mgoSyncToken = $this->mgosync_service->get_mgosync_api_access_token($this->shopUrl);
        $mgoSyncAccessData = $this->mgosync_service->get_mgoSync_access_data(true);

        $shopParams = [
            'platform' => $this->platform,
            'url' => $this->shopUrl,
            'token' => $mgoSyncToken,
            'access_data' => $mgoSyncAccessData,
        ];

        return $shopParams;
    }
}
