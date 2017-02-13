<?php
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html 
*/

/**
 * Hybrid_User_Profile object represents the current logged in user profile. 
 * The list of fields available in the normalized user profile structure used by HybridAuth.  
 *
 * The Hybrid_User_Profile object is populated with as much information about the user as 
 * HybridAuth was able to pull from the given API or authentication provider.
 * 
 * http://hybridauth.sourceforge.net/userguide/Profile_Data_User_Profile.html
 */
class Hybrid_User_Profile
{
	/* The Unique user's ID on the connected provider */
	public $identifier = NULL;

	/* User dispalyName provided by the IDp or a concatenation of first and last name. */
	public $displayName = NULL;

	/* User's first name */
	public $firstName = NULL;

	/* User's last name */
	public $lastName = NULL;

	/*User's nickname */
	public $nickname = NULL;

	/* male or female */
	public $gender = NULL;

	/*User's birthdate*/
	public $birthdate = Null;

	/* User email. Note: not all of IDp garant access to the user email */
	public $email = NULL;
	
	/* Verified user email. Note: not all of IDp garant access to verified user email */
	public $emailVerified = NULL;

	/* phone number */
	public $phoneNumber = NULL;

	/* complete user address */
	public $address = NULL;

	/* user country */
	public $country = NULL;

	/* region */
	public $region = NULL;

	/** city */
	public $city = NULL;

	/* Postal code  */
	public $zip = NULL;
}
