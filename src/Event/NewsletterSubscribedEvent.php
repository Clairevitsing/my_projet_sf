<?php

namespace App\Event;

use App\Entity\Newsletter;

class NewsletterSubscribedEvent
{
    public const NAME = 'newsletter.subscribed';

    public function __construct(
        private Newsletter $newsletter      #鼠標放在上面，右邊鍵，可以看到insert php8 getters， 就會自動數顯public function getrNewsletter()   
    ) {
    }

    /**
     * Get the value of newsletter
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }
}
