<?php
/**
 * @link https://clearbold.com/
 * @copyright Copyright (c) Clearbold, LLC.
 * @license Craft
 */

namespace clearbold\cmtransactional;

require_once CRAFT_VENDOR_PATH.'/campaignmonitor/createsend-php/csrest_transactional_classicemail.php';

// Campaign Monitor requires separate HTML and Text messages, where the Swift Mailer template creates 1 multipart message.
// That needs to be parsed out.
// https://github.com/zbateson/MailMimeParser
use ZBateson\MailMimeParser\MailMimeParser;

/**
 *
 *
 * @author Mark Reeves, Clearbold, LLC <hello@clearbold.com>
 * @since 1.0
 */

class CmTransactionalTransport extends Transport
{
    // Properties
    // =========================================================================

    /**
     * @var Array
     */
    private $_auth;

    /**
     * @var String
     */
    private $_groupName;

    // Public Methods
    // =========================================================================

    /**
     * Constructor
     *
     * @param Array $auth
     */
    public function __construct(Array $auth, String $groupName)
    {
        $this->_auth = $auth;
        $this->_groupName = $groupName;
    }

    /**
     * @inheritdoc
     */
    public function send(\Swift_Mime_SimpleMessage $message, &$failedRecipients = null): int
    {
        $data = $this->_formatMessage($message);
        $classicEmail = new \CS_REST_Transactional_ClassicEmail($this->_auth, NULL);
        $groupName = empty($this->_groupName) ?  'Craft CMS' : $this->_groupName;

        try {
            $result = $classicEmail->send($data, $groupName, 'Unchanged');
            // echo "\nSent! Here's the response:\n";
            // var_dump($result->response); exit;
        }
        catch (AwsException $e) {
            return 0;
        }

        return count($message->getTo());
    }

    // Private Methods
    // =========================================================================

    /**
     * @param \Swift_Mime_SimpleMessage $message
     * @return array
     */
    private function _formatMessage(\Swift_Mime_SimpleMessage $message): array
    {
        $from = is_array($message->getFrom()) ? key($message->getFrom()) : $message->getFrom();

        $mailParser = new MailMimeParser();
        $parsedMessage = $mailParser->parse($message->toString());

        $data = [
            'From' => $from,
            'ReplyTo' => is_array($message->getReplyTo()) ? array_keys($message->getReplyTo()) : $from,
            'To' => array_keys($message->getTo()),
            "Subject" => $message->getSubject(),
            'HTML' => $parsedMessage->getHtmlContent(),
            'Text' => $parsedMessage->getTextContent(),
        ];

        return $data;
    }
}
