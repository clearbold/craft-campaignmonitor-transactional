<?php
/**
 * @link https://clearbold.com/
 * @copyright Copyright (c) Clearbold, LLC.
 * @license Craft
 */

namespace clearbold\cmtransactional;

require_once CRAFT_VENDOR_PATH.'/campaignmonitor/createsend-php/csrest_general.php';

use Craft;
use craft\mail\transportadapters\BaseTransportAdapter;
use Swift_Events_SimpleEventDispatcher;

/**
 * CmTransactionalAdapter implements a Campaign Monitor Transactional Email transport adapter into Craft’s mailer.
 *
 * @property mixed $settingsHtml
 * @author Mark Reeves, Clearbold, LLC <hello@clearbold.com>
 * @since 3.0
 */
class CmTransactionalAdapter extends BaseTransportAdapter
{
    // Static
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        /** @noinspection ClassConstantCanBeUsedInspection */
        return 'Campaign Monitor Transactional';
    }

    // Properties
    // =========================================================================

    /**
     * @var string The API key that should be used
     */
    public $apiKey;

    /**
     * @var string The subaccount that should be used
     */
    public $clientId;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'apiKey' => Craft::t('cm-transactional', 'API Key'),
            // 'clientId' => Craft::t('cm-transactional', 'Client ID'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['apiKey'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('cm-transactional/settings', [
            'adapter' => $this
        ]);
    }

    /**
     * @inheritdoc
     */
    public function defineTransport()
    {

        $auth = array('api_key' => $this->apiKey);
        $client = new \CS_REST_General($auth);

        // Need more logic here, if there's a Client ID, or to validate the account

        return new CmTransactionalTransport($auth);
    }
}