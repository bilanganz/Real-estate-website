<?php
/*
	Authors : Lisa Legawa, Gabriel Nathan Legawa, Ngoc Diep Nguyen
	Date	: 27 September 2019
	WEB3201 - OVO - register.php
*/

$file = "aup.php";
$date = "12/11/2019";
$description = "register webpage for group 08 webd3201 project";
$title = "Welcome to OVO Real Estate Listing";

require_once 'header.php';

if(isset($_SESSION['unauthorized_access'])){
	echo $_SESSION['unauthorized_access'];
	unset($_SESSION['unauthorized_access']);
}


?>
<pre>
Acceptable Use Policy
Please read this acceptable use policy carefully before using OVO website operated by Group08
Services provided by us may only be used for lawful purposes. You agree to comply with all applicable laws, rules, and regulations in connection with your use of the services. Any material or conduct that in our judgment violates this policy in any manner may result in suspension or termination of the services or removal of the user’s account with or without notice.
Prohibited use

You may not use the services to publish content or engage in activity that is illegal under applicable law, that is harmful to others, or that would subject us to liability, including, without limitation, in connection with any of the following, each of which is prohibited under this AUP:
1. Phishing or engaging in identity theft
2. Distributing computer viruses, worms, trojan horses or other malicious code
3. Distributing pornography or adult related content or offering any escort services
4. Promoting or facilitating violence or terrorist activities
5. Infringing the intellectual property or other proprietary rights of others

Enforcement
Your services may be suspended or terminated with or without notice upon any violation of this policy. Any violations may result in the immediate suspension or termination of your account.

Reporting violations
To report a violation of this policy, please contact us.

We reserve the right to change this policy at any given time, of which you will be promptly updated. If you want to make sure that you are up to date with the latest changes, we advise you to frequently visit this page.
</pre>
<?php
	require_once 'footer.php';
?>