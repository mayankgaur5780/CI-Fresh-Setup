<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mailer
{
    protected $to;
    protected $subject;
    protected $userName;
    protected $password;
    protected $emailHost;
    protected $mailFrom;
    protected $attachments;
    protected $mailDirectory;

    public function __construct()
    {
        $this->emailHost = getenv('MAIL_HOST');
        $this->userName = getenv('MAIL_USERNAME');
        $this->password = getenv('MAIL_PASSWORD');
        $this->mailFrom = [getenv('MAIL_USERNAME') => getenv('MAIL_FROM_NAME')];

        // Define email directory
        $this->mailDirectory = VIEWPATH . '/emails';
    }

    protected function init()
    {
        $transport = (new Swift_SmtpTransport($this->emailHost, getenv('MAIL_PORT'), getenv('MAIL_ENCRYPTION')))
            ->setUsername($this->userName)
            ->setPassword($this->password);

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);
        return $mailer;
    }

    protected function initializeTemplate($template, $__data)
    {
        ob_start();
        extract($__data);

        include $this->mailDirectory . '/' . $template;

        return ltrim(ob_get_clean());
    }

    public function to($email)
    {
        $this->to = $email;
        return $this;
    }

    public function subject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function attach($files)
    {
        $this->attachments = $files;
        return $this;
    }

    public function send($view, array $data = [])
    {
        // Initialize Swift Mailer
        $mailer = $this->init();
        $template = $this->initializeTemplate("{$view}.php", $data);

        // Create a message
        $message = (new Swift_Message($this->subject))
            ->setFrom($this->mailFrom)
            ->setTo([$this->to])
            ->setBody($template, 'text/html');

        // Set attachments if has any
        if ($this->attachments !== null) {
            foreach ($this->attachments as $attachment) {
                $message->attach(
                    Swift_Attachment::fromPath($attachment)
                );
            }
        }

        // Send the message
        return $mailer->send($message);
    }
}
