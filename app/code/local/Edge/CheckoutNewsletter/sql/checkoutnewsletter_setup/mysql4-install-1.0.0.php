<?php

$this->startSetup();

$salesSetup = new Mage_Sales_Model_Mysql4_Setup('sales_setup');

$salesSetup->getConnection()->addColumn($salesSetup->getTable('sales_flat_quote'), 'subscribe_to_newsletter', 'smallint(6) NULL DEFAULT NULL');
$salesSetup->addAttribute('quote', 'subscribe_to_newsletter', array('type' => 'static', 'visible' => false));

$this->endSetup();