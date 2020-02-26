<?php
/**
 * survey_view.php along with index.php allow us to view surveys
 * 
* @package SurveySez
 * @author weiyan rui <yan17asn@gmail.com>
 * @version 1.0 2020/02/20
 * @link http://www.example.com/
 * @license https://www.apache.org/licenses/LICENSE-2.0
 * @see index.php
 * @todo none
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
 
# check variable of item passed in - if invalid data, forcibly redirect back to demo_list.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{//send user back to a safe place
	myRedirect(VIRTUAL_PATH . "surveys/index.php");
}

//sql statement to select individual item
//$sql = "select Title,Description,DateAdded from winter2020_surveys where SurveyID = " . $myID;
//---end config area --------------------------------------------------

$foundRecord = FALSE; # Will change to true, if record found!
   
# connection comes first in mysqli (improved) function
$mySurvey = new Survey($myID);

dumpDie($mySurvey);
/*
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

if(mysqli_num_rows($result) > 0)
{#records exist - process
	   $foundRecord = TRUE;	
	   while ($row = mysqli_fetch_assoc($result))
	   {
			$Title = dbOut($row['Title']);
			$Description = dbOut($row['Description']);
			$DateAdded = dbOut($row['DateAdded']);
		}
}

@mysqli_free_result($result); # We're done with the data!
*/

if($foundRecord)
{#only load data if record found
	$config->titleTag = $Title . "survey"; #overwrite PageTitle with survey info!
}
# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php

//echo'<h1 align="center">' . $Title . '</h1>';

//' . xxx . '

if($foundRecord)
{#records exist - show survey!

	echo'
	   <h1 align="center">' . $Title . '</h1>
		<h3>' . $Title . '</h3>
		<p>' . $Description . '</p>
		<p>Date Added: ' . $DateAdded . '</p>
	';
}else{//no such survey!
    echo '<h2 align="center">There is no such survey</h2>';
    echo '<div align="center"><a href="' . VIRTUAL_PATH . 'surveys/index.php">Surveys</a></div>';
}

get_footer(); #defaults to theme footer or footer_inc.php

class Survey{
	public $SurveyID = 0;
	public $Title = '';
	public $Description = '';
	public $DateAdded = '';
	public $Question = array();

    public function __construct($id){
		$this->SurveyID = (int)$id;
		
		$sql = "select Title,Description,DateAdded from winter2020_surveys where SurveyID = " . $this->SurveyID;

		$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

        if(mysqli_num_rows($result) > 0)
        {#records exist - process
	        $foundRecord = TRUE;	
	        while ($row = mysqli_fetch_assoc($result))
	        {
			    $this->Title = dbOut($row['Title']);
			    $this->Description = dbOut($row['Description']);
			    $this->DateAdded = dbOut($row['DateAdded']);
		    }
        }

		@mysqli_free_result($result); # We're done with the data!
		
		
	$sql = "select QuestionID,Question,Description from winter2020_questions where SurveyID = " . $this->SurveyID;

		$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

        if(mysqli_num_rows($result) > 0)
        {#records exist - process	
	        while ($row = mysqli_fetch_assoc($result))
	        {
				$this->Questions[] = new Question(dbOut($row['QuestionID']), dbOut($row['Question']), dbOut($row['Description']));
			    //$this->Title = dbOut($row['Title']);
			    //$this->Description = dbOut($row['Description']);
			    //$this->DateAdded = dbOut($row['DateAdded']);
		    }
        }

        @mysqli_free_result($result); # We're done with the data!
	}//end of Survey constructor
}//end of survey class

class Question{
	public $QuestionID = 0;
	public $Question = '';
	public $Description = '';
	
	public function __construct($QuestionID,$Question,$Description){
		$this->QuestionID = $QuestionID;
		$this->Question = $Question;
		$this->Description = $Description;


	}//end of Question constructor

}//end of Question class

