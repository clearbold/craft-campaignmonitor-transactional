<?php
/**
 * @link      https://github.com/clearbold/craft-campaignmonitor-transactional
 * @copyright Copyright (c) Clearbold, LLC
 */

namespace clearbold\cmtransactional;

use clearbold\cmtransactional\CmTransactionalAdapter;

use craft\base\Plugin;
use craft\events\RegisterComponentTypesEvent;
use craft\helpers\MailerHelper;
use yii\base\Event;

/**
 * CmTransactionalAdapter implements a Campaign Monitor Transactional Email transport adapter into Craft’s mailer.
 *
 * @author Mark Reeves, Clearbold, LLC <hello@clearbold.com>
 * @since 1.0
 */
class CmTransactional extends Plugin
{
    // Public Methods
    // =========================================================================

    public function init()
    {
        parent::init();

        Event::on(MailerHelper::class, MailerHelper::EVENT_REGISTER_MAILER_TRANSPORT_TYPES, function(RegisterComponentTypesEvent $event) {
            $event->types[] = CmTransactionalAdapter::class;
        });
    }
}
