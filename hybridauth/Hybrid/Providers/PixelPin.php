<?php
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html 
*/

/**
 * Hybrid_Providers_PixelPin provider adapter based on OAuth2 protocol
 * 
 * http://hybridauth.sourceforge.net/userguide/IDProvider_info_PixelPin.html
 */
class Hybrid_Providers_PixelPin extends Hybrid_Provider_Model_OAuth2
{
	public $scope = "openid profile email phone address";

	/**
	* IDp wrappers initializer 
	*/
	function initialize() 
	{
		parent::initialize();

		// Provider apis end-points
		$this->api->api_base_url  = "https://test.pixelpin.co.uk/connect/";
		$this->api->authorize_url = "https://test.pixelpin.co.uk/connect/authorize";
		$this->api->token_url     = "https://test.pixelpin.co.uk/connect/token"; 

		$this->api->sign_token_name = "access_token";
	}

	/**
	* load the user profile from the IDp api client
	*/
	function getUserProfile()
	{
		$data = $this->api->api( "userinfo", "POST" ); 

		if ( ! isset( $data->sub ) ){
			throw new Exception( "User profile request failed! {$this->providerId} returned an invalid response.", 6 );
		}

		$this->user->profile->identifier    	= $data->sub;
		$this->user->profile->firstName     	= $data->given_name;
		$this->user->profile->lastName      	= $data->family_name;
		$this->user->profile->nickname			= $data->nickname;

		$gender = (isset($data->gender) ? $data->gender : false);
		if ($gender === false){
			$this->user->profile->gender 		= 'Unavailable';
		}
		else
		{
			$this->user->profile->gender 		= $data->gender;
		}

		$birthdate = (isset($data->birthdate) ? $data->birthdate : false);
		if ($birthdate === false)
		{
			$this->user->profile->birthdate 	= 'Unavailable';	
		}
		else
		{
			$this->user->profile->birthdate		= $data->birthdate;

		}

		$phone_number = (isset($data->phone_number) ? $data->phone_number : false);
		if ($phone_number === false){
			$this->user->profile->phoneNumber 	= 'Unavailable';
		}
		else
		{
			$this->user->profile->phoneNumber	= $phone_number;
		}

		$this->user->profile->displayName   	= $data->given_name;
		$this->user->profile->email         	= $data->email;
	    $this->user->profile->emailVerified 	= $data->email;

	    $address = (isset($data->address) ? $data->address : false);
	    if ($address === false){
	        $this->user->profile->address    	= 'Unavailable';
		    $this->user->profile->country       = 'Unavailable';
		    $this->user->profile->region        = 'Unavailable';
		    $this->user->profile->city          = 'Unavailable';
		    $this->user->profile->zip           = 'Unavailable';
	    }
	    else
	    {
		    $address = $data->address;

		    $decodeAddress = json_decode($address);

			$streetAddress2 = $decodeAddress->{"street_address"};
			$townCity2 = $decodeAddress->{"locality"};
			$region2 = $decodeAddress->{"region"};
			$postalCode2 = $decodeAddress->{"postal_code"};
			$country2 = $decodeAddress->{"country"};

			$streetAddress = (string)$streetAddress2;
			$townCity = (string)$townCity2;
			$region = (string)$region2;
			$postalCode = (string)$postalCode2;
			$country = (string)$country2;

		    $this->user->profile->address    	= $streetAddress;
		    $this->user->profile->country       = $country;
		    $this->user->profile->region        = $region;
		    $this->user->profile->city          = $townCity;
		    $this->user->profile->zip           = $postalCode;
	    }

		return $this->user->profile;
	}
}
