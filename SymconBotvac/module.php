<?php

	// Include the botvac library
	require ('libs/NeatoBotvacClient.php');
	require ('libs/NeatoBotvacRobot.php');

    // Klassendefinition
    class SymconBotvac extends IPSModule {
 
        // Der Konstruktor des Moduls
        // Überschreibt den Standard Kontruktor von IPS
        public function __construct($InstanceID) {
            // Diese Zeile nicht löschen
            parent::__construct($InstanceID);
 
            // Selbsterstellter Code
        }
 
        // Überschreibt die interne IPS_Create($id) Funktion
        public function Create() {
            
		// Diese Zeile nicht löschen.
            	parent::Create();

		// Properties
		$this->RegisterPropertyString("Sender","SymconBotvac");
		$this->RegisterPropertyString("Username","");
		$this->RegisterPropertyString("Password","");
		$this->RegisterPropertyString("BotvacVendor","");

		// Variables
		$this->RegisterVariableString("AuthToken","Web Service Authentication Token");
 
        }
 
        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();
        }


	public function GetConfigurationForm() {

        	
		// Initialize the form
		$form = Array(
            		"elements" => Array(),
			"actions" => Array()
        		);

		// Add the Elements
		$form['elements'][] = Array("type" => "ValidationTextBox", "name" => "Username", "caption" => "Username");
		$form['elements'][] = Array("type" => "PasswordTextBox", "name" => "Password", "caption" => "Password");
		
		$BotvacVendorOptions = Array();
		$BotvacVendorOptions[] = Array("label" => "Neato", "value" => "neato");
		$BotvacVendorOptions[] = Array("label" => "Vorwerk", "value" => "vorwerk");
		$form['elements'][] = Array("type" => "Select", "name" => "BotvacVendor", "caption" => "Select Vendor", "options" => $BotvacVendorOptions);

		return json_encode($form);

	}


	/**
	* Generate the Authorization Token and store it
	*
	*/
	public function Authorize() {

		$NeatoClient = new NeatoBotvacClient(false, $this->ReadPropertyString("BotvacVendor") );
                $AuthToken = $NeatoClient->authorize($this->ReadPropertyString("Username"), $this->ReadPropertyString("Password") );

		if ($AuthToken) {

			SetValue($this->GetIDForIdent("AuthToken"), $AuthToken);

		}
	}
 
        /**
	* Get the list of robots linked to this profile and modifies the Select list to allow the user to select them.
        *
        */
        public function FetchRobotList() {


		$NeatoClient = new NeatoBotvacClient($this->ReadPropertyString("AuthToken"), $this->ReadPropertyString("BotvacVendor") );

		$allRobots = Array();
		
		$allRobots = $NeatoClient->getRobots();	

		$this->SendDebug("BOTVAC", print_r($allRobots), 0);
		
        }
    }
?>
