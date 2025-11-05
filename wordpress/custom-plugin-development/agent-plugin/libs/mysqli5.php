<?php
#====================================================================================================
#	File Name	:	mysql5.php
#----------------------------------------------------------------------------------------------------

// Return Record type
define("MYSQLI_FETCH_ALL", 		'Fetch_All');
define("MYSQLI_FETCH_SINGLE", 	'Fetch_Single');
define("MYSQLI_FETCH_OBJECT", 	'Fetch_Object');
define("MYSQLI_FETCH_ARRAY", 	'Fetch_Array');

class DB_rowset {
	
  /* public: configuration parameters */
  var $Auto_Free     = 0;     ## Set to 1 for automatic mysqli_free_result()
  var $Debug         = 0;     ## Set to 1 for debugging messages.
  var $Halt_On_Error = "yes"; ## "yes" (halt with message), "no" (ignore errors quietly), "report" (ignore errror, but spit a warning)

  var $Debug_info    = array();  ## Store all queries

  /* public: result array and current row number */
  var $Record   = array();
  var $Row		= 0;
  var $TotalRow	= 0;

  /* public: current error number and error text */
  var $Errno    = 0;
  var $Error    = "";

  /* private: link and query handles */
  var $Link_ID  = 0;
  var $Query_ID = 0;

  /* public: constructor */
  function __construct(&$result, &$connection, $Query='') {
	$this->Link_ID 		=& $connection;
    $this->Query_ID 	=& $result;
    $this->TotalRow 	= $this->num_rows();
  }

  function query_id() {
    return $this->Query_ID;
  }

  /* public: discard the query result */
  function free() {
      @mysqli_free_result($this->Query_ID);
      $this->Query_ID = 0;
  }

  /* public: fetch result set */
  function fetch_object($fetch=MYSQLI_FETCH_ALL, $key='') {

	# Store records
	$records = array();

	# Fetch records
	if($fetch == MYSQLI_FETCH_ALL)
	{
		while ($data = mysqli_fetch_object($this->Query_ID)) 
		{
			if(empty($key))
				array_push($records, $data);
			else
				$records[$data[$key]] = $data;
		}
		
		return $records;
	}
	elseif($fetch == MYSQLI_FETCH_SINGLE)
	{
		return mysqli_fetch_object($this->Query_ID);
	}
	return false;
  }

  /* public: fetch records in array */
  function fetch_array($result_type=MYSQLI_ASSOC, $key='') {

	# Store records
	$records = array();

	# Fetch records
	if($result_type == MYSQLI_NUM)
	{
		while ($data = mysqli_fetch_array($this->Query_ID, MYSQLI_NUM)) 
		{
			if(empty($key))
				array_push($records, $data);
			else
				$records[$data[$key]] = $data;
				
		}
	}
	elseif($result_type == MYSQLI_ASSOC)
	{
		while ($data = mysqli_fetch_array($this->Query_ID, MYSQLI_ASSOC)) 
		{
			if(empty($key))
				array_push($records, $data);
			else
				$records[$data[$key]] = $data;
		}
	}
	elseif($result_type == MYSQLI_FETCH_SINGLE)
	{
		return mysqli_fetch_array($this->Query_ID, MYSQLI_ASSOC); 
	}
	else
	{
		while ($data = mysqli_fetch_array($this->Query_ID))
		{
			if(empty($key))
				array_push($records, $data);
			else
				$records[$data[$key]] = $data;
		}
	}
	return $records;
  }

  /* public: walk result set */
  function next_record() {
	if (!$this->Query_ID) {
      $this->halt("next_record called with no query pending.");
      return 0;
    }

    $this->Record = @mysqli_fetch_array($this->Query_ID, MYSQLI_ASSOC);
	if ($this->Record)
	    $this->Row   += 1;
    $this->Errno  = mysqli_errno($this->Link_ID);
    $this->Error  = mysqli_error($this->Link_ID);

    $stat = is_array($this->Record);
    if (!$stat && $this->Auto_Free) {
      $this->free();
    }

	return $stat;
  }

  /* public: position in result set */
  function seek($pos = 0) {
    $status = @mysqli_data_seek($this->Query_ID, $pos);
    if ($status)
      $this->Row = $pos;
    else {
      $this->halt("seek($pos) failed: result has ".$this->num_rows()." rows.");

      /* half assed attempt to save the day,
       * but do not consider this documented or even
       * desireable behaviour.
       */
      @mysqli_data_seek($this->Query_ID, $this->num_rows());
      $this->Row = $this->num_rows();
      return 0;
    }

    return 1;
  }

  function num_rows() {
    return @mysqli_num_rows($this->Query_ID);
  }

  function rewind_rowset() {
	$this->Row   = 0;
    return $this->seek(0);
  }

  function num_fields() {
    return @mysqli_num_fields($this->Query_ID);
  }

  /* public: shorthand notation */
  function nf() {
    return $this->num_rows();
  }

  function np() {
    print $this->num_rows();
  }

  function f($Name) {
    if (isset($this->Record[$Name])) {
      return $this->Record[$Name];
    }
  }

  function fieldName($id) {
    if (isset($this->Query_ID)) {
      return @mysqli_field_name($this->Query_ID, $id);
    }
  }

  function p($Name) {
    if (isset($this->Record[$Name])) {
      print $this->Record[$Name];
    }
  }

  /* private: error handling */
  function Halt_On_Error($flg) {
	  $this->Halt_On_Error = $flg;
  } 
  
  function halt($msg) {
    $this->Error = @mysqli_error($this->Link_ID);
    $this->Errno = @mysqli_errno($this->Link_ID);
    if ($this->Halt_On_Error == "no")
      return;

    $this->haltmsg($msg);

    if ($this->Halt_On_Error != "report")
      die("Session halted.");
  }

  function haltmsg($msg) {
    printf("</td></tr></table><b>Database error:</b> %s<br>\n", $msg);
    printf("<b>MySQL Error</b>: %s (%s)<br>\n",
      $this->Errno,
      $this->Error);
  }

}

class DB_Sql {

  /* public: connection parameters */
  var $Host     = "";
  var $Database = "";
  var $User     = "";
  var $Password = "";
  var $Persistency = false;

  /* public: configuration parameters */
  var $Debug         = 1;     ## Set to 1 for debugging messages.
  var $Halt_On_Error = "yes"; ## "yes" (halt with message), "no" (ignore errors quietly), "report" (ignore errror, but spit a warning)

  var $Debug_info    = array();  ## Store all queries

  /* public: current error number and error text */
  var $Errno    = 0;
  var $Error    = "";

  /* public: this is an api revision, not a CVS revision. */
  var $type     = "mysql";
  var $revision = "2.0";

  /* private: link and query handles */
  var $Link_ID  = 0;
  
  function __construct($Link_ID) {
	$this->Link_ID = $Link_ID;
  }  
  /* public: constructor */
  function DB_Sql2($Host, $Database, $User, $Password, $Persistency = true) {

	$this->Host 		= $Host;
    $this->Database 	= $Database;
	$this->User			= $User;
	$this->Password		= $Password;
	$this->Persistency	= $Persistency;

    /* establish connection, select database */
    if ( $this->Link_ID == 0 ) {

      if($this->Persistency) {

		$this->Link_ID = @mysqli_pconnect($this->Host, $this->User, $this->Password);

        if (!$this->Link_ID) {
	        $this->halt("pconnect($Host, $User, \$Password) failed.");
	    	return 0;
	    }
      }
      else
      {
		$this->Link_ID = @mysqli_connect($this->Host, $this->User, $this->Password);
		
        if (!$this->Link_ID) {
	        $this->halt("connect($Host, $User, \$Password) failed.");
	    	return 0;
	    }
      }

      if (!@mysqli_select_db($this->Link_ID, $Database)) {
        $this->halt("cannot use database ".$Database);
        return 0;
      }
    }

    return $this->Link_ID;
  }

  /* public: reselect the database */
  function reset_database() {
	  
      if (!@mysqli_select_db($this->Link_ID, $this->Database)) {
        $this->halt("cannot use database ".$this->Database);
        return 0;
      }
  }

  /* public: reconnect the database server */
  function reconnect() {

      if($this->Persistency) {

		$this->Link_ID = @mysqli_pconnect($this->Host, $this->User, $this->Password);

        if (!$this->Link_ID) {
	        $this->halt("pconnect($Host, $User, \$Password) failed.");
	    	return 0;
	    }
      }
      else
      {
		$this->Link_ID = @mysqli_connect($this->Host, $this->User, $this->Password);

        if (!$this->Link_ID) {
	        $this->halt("connect($Host, $User, \$Password) failed.");
	    	return 0;
	    }
      }
	  
	  return $this->Link_ID;
  }

  /* public: some trivial reporting */
  function link_id() {
    return $this->Link_ID;
  }

  /* public: some trivial reporting */
  function query_debug() {
    return $this->Debug_info;
  }

  function database_name() {
    return $this->Database;
  }

  /* public: perform a query */
  function &query($Query_String, $is_unbuffered=false, $reconnect=true) {

    /* No empty queries, please, since PHP4 chokes on them. */
    if ($Query_String == "")
      /* The empty query string is passed on from the constructor,
       * when calling the class without a query, e.g. in situations
       * like these: '$db = new DB_Sql_Subclass;'
       */
      return false;

    if ($this->Debug) {
		# Store start time
		$t_start = 0;
		list($usec, $sec) = explode(" ", microtime());
		$t_start = ((float)$usec + (float)$sec); 
	}

	if($is_unbuffered)
		$result = @mysqli_unbuffered_query($Query_String, $this->Link_ID);
	else
		$result = @mysqli_query($this->Link_ID, $Query_String);

    if ($this->Debug) {
		# Check end time
		$t_end 	= 0;
		list($usec, $sec) = explode(" ", microtime());
		$t_end = ((float)$usec + (float)$sec); 

		$this->Debug_info[] = array('Query'		=>	$Query_String,
									'Time'		=>	microtime(),
									'ExecTime'	=>	($t_end - $t_start),
									'QueryTime'	=>	date('Y-M-d H:i:s'),
									);
	}

    $this->Errno = mysqli_errno($this->Link_ID);
    $this->Error = mysqli_error($this->Link_ID);
	
	if($this->Errno == '2006' && $reconnect)
	{
		echo 'Reconnecting DB';
		$this->reconnect();
		$this->reset_database();
		return $this->query($Query_String, $is_unbuffered, $reconnect=false);
	}	
    elseif (!$result) {
      $this->halt("Invalid SQL: ". $Query_String);
    }

	if($result === true){
		return $result;
	}
	else
	{
		# return rowset
		#-----------------
		$rowset = new DB_rowset($result, $this->Link_ID);
		return $rowset;
	}
  }

  function sql_inserted_id(){
  	if($this->Link_ID)
  	{
  		$result = @mysqli_insert_id($this->Link_ID);
  		return $result;
  	}
  	else
  	{
  		return false;
  	}
  }

  /* public: evaluate the result (size, width) */
  function affected_rows() {
    return @mysqli_affected_rows($this->Link_ID);
  }

  /* public: table locking */
  function lock($table, $mode = "write") {
    $query = "lock tables ";
    if (is_array($table)) {
      while (list($key,$value) = each($table)) {
        if (!is_int($key)) {
		  // texts key are "read", "read local", "write", "low priority write"
          $query .= "$value $key, ";
        } else {
          $query .= "$value $mode, ";
        }
      }
      $query = substr($query,0,-2);
    } else {
      $query .= "$table $mode";
    }
    $res = $this->query($query);
	if (!$res) {
      $this->halt("lock() failed.");
      return 0;
    }
    return $res;
  }

  function unlock() {
    $res = $this->query("unlock tables");
    if (!$res) {
      $this->halt("unlock() failed.");
    }
    return $res;
  }


  /* public: find available table names */
  function table_names() {
    $this->reconnect();
    $h = @mysqli_query($this->Link_ID, "show tables");
    $i = 0;
    while ($info = @mysqli_fetch_row($h)) {
      $return[$i]["table_name"]      = $info[0];
      $return[$i]["tablespace_name"] = $this->Database;
      $return[$i]["database"]        = $this->Database;
      $i++;
    }

    @mysqli_free_result($h);
    return $return;
  }

  /* public: Drop Table */
  function drop_table($table_name) {
    return $this->query("drop table ". $table_name);
  }

  /* public: Drop Database */
  function drop_database() {
    return $this->query("drop database ". $this->Database);
  }

  /* publid: Close connection */
  function db_close()
  {
	if($this->Link_ID)
	{
		$result = @mysqli_close($this->Link_ID);
		return $result;
	}
	else
	{
		return false;
	}
  }

  /* private: error handling */
  function Halt_On_Error($flg) {
	  $this->Halt_On_Error = $flg;
  } 
  
  function halt($msg) {
    $this->Error = @mysqli_error($this->Link_ID);
    $this->Errno = @mysqli_errno($this->Link_ID);
    if ($this->Halt_On_Error == "no")
      return false;

    $this->haltmsg($msg);

    if ($this->Halt_On_Error != "report")
      die("Session halted.");
  }

  function haltmsg($msg) {
    printf("<b>Database error:</b> %s<br>\n", $msg);
    printf("<b>MySQL Error</b>: %s (%s)<br>\n",
      $this->Errno,
      $this->Error);
  }

  function sql_error($link_id = 0)
  {
	$result["message"] = @mysqli_error($this->Link_ID);
	$result["code"] = @mysqli_errno($this->Link_ID);

	return $result;
  }

}

?>