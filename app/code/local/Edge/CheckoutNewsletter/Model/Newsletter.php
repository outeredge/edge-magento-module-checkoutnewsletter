<?php

class Edge_CheckoutNewsletter_Model_Newsletter
{
    protected function _getLastOrderId() {
        return (int)(Mage::getSingleton('checkout/type_onepage')->getCheckout()->getLastOrderId());
    }

    public function setSubscribeToNewsletterStatus(Varien_Event_Observer $observer)
    {
        $controllerAction = $observer->getEvent()->getControllerAction();
        if ($controllerAction) {
            $newsletterCheckbox = $controllerAction->getRequest()->getPost('subscribe_to_newsletter');

            Mage::getModel('checkout/cart')
                ->getQuote()
                ->setSubscribeToNewsletter((bool)$newsletterCheckbox)
                ->save();
        }
    }

    public function subscribeToNewsletter(Varien_Event_Observer $observer)
    {
        $orderId = $this->_getLastOrderId();
        $order = Mage::getModel('sales/order')->load($orderId);

        $quoteId = $order->getQuoteId();
        $quote = Mage::getModel('sales/quote')->load($quoteId);

        if (in_array($quote->getCheckoutMethod(), array('login_in', 'guest')) && $quote->getSubscribeToNewsletter()) {
            Mage::getModel('newsletter/subscriber')->subscribe($quote->getBillingAddress()->getEmail());
        }
    }
}
