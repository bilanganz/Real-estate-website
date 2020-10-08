<?php
define('ADMIN', 's');
define('AGENT', 'a');
define('CLIENT', 'c');
define('PENDING', 'p');
define('DISABLED', 'd');
define('INCOMPLETE', 'i');

define('HASH_ALGORITHM','md5');

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'group08_db');
define('DB_PORT', 5432);
define('DB_PASSWORD', 'webd3201');
define('DB_USER', 'group08_admin');

define('COOKIE_LIFESPAN',2592000);

define('EMAIL','e');
define('PHONE','p');
define('POSTED_MAIL','l');

define('MAX_NUMBER_OF_IMAGE',5);

define('OPEN','o');
define('CLOSED','c');
define('SOLD','s');
define('HIDDEN','h');

define('MIN_AREA_PHONE_NUMBER',200);
define('MAX_AREA_PHONE_NUMBER',999);

define('MIN_PASSWORD_LENGTH',8);
define('MAX_PASSWORD_LENGTH',16);

define('MIN_USER_ID_LENGTH',6);
define('MAX_USER_ID_LENGTH',20);

define('MIN_PHONE_NUMBER_LENGTH',10);
define('MAX_PHONE_NUMBER_LENGTH',15);

define('MAX_FIRST_NAME_LENGTH',128);
define('MAX_LAST_NAME_LENGTH',128);
define('MAX_STREET_ADDRESS_LENGTH',128);
define('MAX_CITY_LENGTH',64);
define('MAX_PROVINCE_LENGTH',2);
define('MAX_POSTAL_CODE_LENGTH',6);
define('MAX_EMAIL_LENGTH',256);
define('MAX_HEADLINE_LENGTH',100);
define('MAX_DESCRIPTION_LENGTH',1000);

define('PREFERRED_CONTACT_METHOD','preferred_contact_methods');
define('LISTING_STATUS','listing_status');

define('LIMIT_NUMBER_OF_RECORD',200);
define('NUM_PER_PAGE', 10);

?>