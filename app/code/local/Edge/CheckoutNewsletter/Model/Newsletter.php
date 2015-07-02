<?php

class Edge_CheckoutNewsletter_Model_Newsletter
{
    public function setSubscribeToNewsletterStatus(Varien_Event_Observer $observer)
    {
        $controllerAction = $observer->getEvent()->getControllerAction();
        if ($controllerAction) {
            $newsletterCheckbox = $controllerAction->getRequest()->getPost('subscribe_to_newsletter');
            Mage::getModel('checkout/type_onepage')->getCheckout()->setNewsletterChecked((bool)$newsletterCheckbox);
        }
    }

    public function subscribeToNewsletter(Varien_Event_Observer $observer)
    {
        $quote = $observer->getEvent()->getQuote();
        if (in_array($quote->getCheckoutMethod(), array('login_in', 'guest')) &&
            Mage::getModel('checkout/type_onepage')->getCheckout()->getNewsletterChecked())
        {
            Mage::getModel('newsletter/subscriber')->subscribe($quote->getBillingAddress()->getEmail());
            Mage::getModel('checkout/type_onepage')->getCheckout()->unsNewsletterChecked();
        }
    }
}
