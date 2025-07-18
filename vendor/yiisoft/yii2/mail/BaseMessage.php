<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace yii\mail;

use Yii;
use yii\base\BaseObject;
use yii\base\ErrorHandler;

/**
 * BaseMessage serves as a base class that implements the [[send()]] method required by [[MessageInterface]].
 *
 * By default, [[send()]] will use the "mailer" application component to send the current message.
 * The "mailer" application component should be a mailer instance implementing [[MailerInterface]].
 *
 * @see BaseMailer
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 2.0
 */
abstract class BaseMessage extends BaseObject implements MessageInterface
{
    /**
     * @var MailerInterface|null the mailer instance that created this message.
     * For independently created messages this is `null`.
     */
    public $mailer;


    /**
     * Sends this email message.
     * @param MailerInterface|null $mailer the mailer that should be used to send this message.
     * If no mailer is given it will first check if [[mailer]] is set and if not,
     * the "mailer" application component will be used instead.
     * @return bool whether this message is sent successfully.
     */
    public function send(?MailerInterface $mailer = null)
    {
        if ($mailer === null && $this->mailer === null) {
            $mailer = Yii::$app->getMailer();
        } elseif ($mailer === null) {
            $mailer = $this->mailer;
        }

        return $mailer->send($this);
    }

    /**
     * PHP magic method that returns the string representation of this object.
     * @return string the string representation of this object.
     */
    public function __toString()
    {
        // __toString cannot throw exception
        // use trigger_error to bypass this limitation
        try {
            return $this->toString();
        } catch (\Throwable $e) {
            if (PHP_VERSION_ID < 70400) {
                trigger_error(ErrorHandler::convertExceptionToString($e), E_USER_ERROR);

                return '';
            }

            throw $e;
        }
    }
}
