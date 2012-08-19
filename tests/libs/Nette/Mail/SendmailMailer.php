<?php

/**
 * This file is part of the Nette Framework (http://nette.org)
 *
 * Copyright (c) 2004 David Grudl (http://davidgrudl.com)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 * @package Nette\Mail
 */



/**
 * Sends emails via the PHP internal mail() function.
 *
 * @author     David Grudl
 * @package Nette\Mail
 */
class SendmailMailer extends Object implements IMailer
{
	/** @var string */
	public $commandArgs;



	/**
	 * Sends email.
	 * @param  Mail
	 * @return void
	 */
	public function send(Mail $mail)
	{
		$tmp = clone $mail;
		$tmp->setHeader('Subject', NULL);
		$tmp->setHeader('To', NULL);

		$parts = explode(Mail::EOL . Mail::EOL, $tmp->generateMessage(), 2);

		Debugger::tryError();
		$args = array(
			str_replace(Mail::EOL, PHP_EOL, $mail->getEncodedHeader('To')),
			str_replace(Mail::EOL, PHP_EOL, $mail->getEncodedHeader('Subject')),
			str_replace(Mail::EOL, PHP_EOL, $parts[1]),
			str_replace(Mail::EOL, PHP_EOL, $parts[0]),
		);
		if ($this->commandArgs) {
			$args[] = (string) $this->commandArgs;
		}
		$res = call_user_func_array('mail', $args);

		if (Debugger::catchError($e)) {
			throw new InvalidStateException('mail(): ' . $e->getMessage(), 0, $e);

		} elseif (!$res) {
			throw new InvalidStateException('Unable to send email.');
		}
	}

}
