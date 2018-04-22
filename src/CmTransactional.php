<?php
/**
 * @link      https://github.com/putyourlightson/craft-amazon-ses
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace clearbold\cmtransactional;

// use clearbold\cmtransactional\mail\CampaignmonitorTransactionalAdapter;

use craft\base\Plugin;
use craft\events\RegisterComponentTypesEvent;
use craft\helpers\MailerHelper;
use yii\base\Event;

/**
 * Amazon SES plugin
 *
 * @author    PutYourLightsOn
 * @package   Amazon SES
 * @since     1.0.0
 */
class CmTransactional extends Plugin
{
    // Public Methods
    // =========================================================================

    public function init()
    {
        parent::init();

        Event::on(MailerHelper::class, MailerHelper::EVENT_REGISTER_MAILER_TRANSPORT_TYPES, function(RegisterComponentTypesEvent $event) {
            // $event->types[] = CampaignmonitorTransactionalAdapter::class;
        });
    }
}
