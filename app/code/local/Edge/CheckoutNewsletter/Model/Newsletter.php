<?php

class Edge_CheckoutNewsletter_Model_Newsletter
{
    public function setSubscribeToNewsletterStatus(Varien_Event_Observer $observer)
    {
        $controllerAction = $observer->getEvent()->getControllerAction();
        if ($controllerAction) {
            $newsletterCheckbox = $controllerAction->getRequest()->getPost('subscribe_to_newsletter');
            Mage::getModel('core/session')->setNewsletterChecked((bool)$newsletterCheckbox);
        }
    }

    public function subscribeToNewsletter(Varien_Event_Observer $observer)
    {
        $quote = $observer->getEvent()->getQuote();
        if (in_array($quote->getCheckoutMethod(), array('login_in', 'guest')) && Mage::getModel('core/session')->getNewsletterChecked()) {
            Mage::getModel('newsletter/subscriber')->subscribe($quote->getBillingAddress()->getEmail());
            Mage::getModel('core/session')->unsNewsletterChecked();
        }
    }
}
