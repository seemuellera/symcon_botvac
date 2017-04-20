<?

	// Include the botvac library
	require ("../lib/NeatoBotvacClient.php");
	require ("../lib/NeatoBotvacRobot.php");

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
	* Get the list of robots linked to this profile and modifies the Select list to allow the user to select them.
        *
        */
        public function FetchRobotList() {

		if ($this->ReadPropertyString("AuthToken") == "") {

			$NeatoClient = new NeatoBotvacClient(false, $this->ReadPropertyString("BotvacVendor") );
			$AuthToken = $NeatoClient->authorize($this->ReadPropertyString("Username"), $this->ReadPropertyString("Password") );
			$this->RegisterPropertyString("AuthToken", $AuthToken);
		}
		else {

			$NeatoClient = new NeatoBotvacClient($this->ReadPropertyString("AuthToken"), $this->ReadPropertyString("BotvacVendor") );
		}	

		$allRobots = Array();
		
		$allRobots = $NeatoClient->getRobots();	

		$this->SendDebug("BOTVAC", print_r($allRobots), 0);
		
        }
    }
?>
