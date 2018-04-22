<?php
/**
 * @link      https://github.com/clearbold/craft-campaignmonitor-transactional
 * @copyright Copyright (c) Clearbold, LLC
 */

namespace clearbold\cmtransactional;

use Swift_Events_EventListener;
use Swift_Mime_SimpleMessage;

/**
 * Transport
 *
 * @author    Clearbold
 * @package   Campaign Monitor Transactional
 * @since     3.0
 */

abstract class Transport implements \Swift_Transport
{
    /**
     * @inheritdoc
     */
    public function isStarted(): bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function start(): bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function stop(): bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function ping(): bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function registerPlugin(Swift_Events_EventListener $plugin) { }
}
