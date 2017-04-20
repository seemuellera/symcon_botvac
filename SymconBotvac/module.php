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

		$this->RegisterPropertyString("Sender","SymconBotvac");
		$this->RegisterPropertyString("Username","");
		$this->RegisterPropertyString("Password","");
		$this->RegisterPropertyString("BotvacVendor","");
		$this->RegisterPropertyString("AuthToken","");
 
        }
 
        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();
        }

	/**
	* Generate the Authorization Token and store it
	*
	*/
	public function Authorize() {

		$NeatoClient = new NeatoBotvacClient(false, $this->ReadPropertyString("BotvacVendor") );
                $AuthToken = $NeatoClient->authorize($this->ReadPropertyString("Username"), $this->ReadPropertyString("Password") );
		
		if ($AuthToken) {

			$this->SendDebug("BOTVAC", $AuthToken, 0);

                        $this->RegisterPropertyString("AuthToken", $AuthToken);
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
