<?php

global $wpdb;
$contactform_sql = "CREATE TABLE IF NOT EXISTS `Lord_linus_contact_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `email` varchar(256) NOT NULL,
  `subject` varchar(256) NOT NULL,
  `message` varchar(256) NOT NULL,
  `other_fields` text NOT NULL,
  PRIMARY KEY (`id`)
);";
$wpdb->query($contactform_sql); 
?>