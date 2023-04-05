<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Copyright (C) 2020 Francisco Gálvez Prada                 *
 * This file is part of the project BackupMail               *
 * Contribute on https://github.com/Iguannaweb/backupmail    *
 *                                                           *
 * BACKUPMAIL                                                * 
 * This is a simple solution to backup all your mails.       *
 * It will organize your mails by account, year, month and   *
 * it will create a separate eml file for every mail.        *
 * It will download the attachments too.                     *
 * Contact: info@iguannaweb.com                              *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
if(!defined('INCLUDE_CHECK')) die('No puedes acceder directamente');
?>
<?php 

//Clear strings
function clear($input)
{
    global $link;
    if(get_magic_quotes_gpc())
    {
        //Remove slashes that were used to escape characters in post.
        $input = stripslashes($input);
    }
    //Remove ALL HTML tags to prevent XSS and abuse of the system.
    $input = @strip_tags($input);
    //Escape the string for insertion into a MySQL query, and return it.
    return mysqli_real_escape_string($link,$input);
}

	
/*
DATA ARRAY EXAMPLE
	$form_data = array(
    'first_name' => $first_name,
    'last_name' => $last_name,
    'email' => $email,
    'address1' => $address1,
    'address2' => $address2,
    'address3' => $address3,
    'postcode' => $postcode,
    'tel' => $tel,
    'mobile' => $mobile,
    'website' => $website,
    'contact_method' => $contact_method,
    'subject' => $subject,
    'message' => $message,
    'how_you_found_us' => $how_you_found_us,
    'time' => time()
);

USING FUNCTIONS
DBSelect('my_table', $select, "WHERE fecha = '$fecha'");
DBInsert('my_table', $form_data);
DBUpdate('my_table', $form_data, "WHERE id = '$id'");
DBDelete('my_table', "WHERE id = '$id'");	
*/

/*SELECT*/
function DBSelect($table_name, $select='*', $where_clause='', $order_clause='',$limit_clause='')
{
	require($_SERVER["DOCUMENT_ROOT"].'/igw_includes/config/dbc.php');

    // check for optional where clause
    $whereSQL = '';
    if(!empty($where_clause))
    {
        // check to see if the 'where' keyword exists
        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
        {
            // not found, add key word
            $whereSQL = " WHERE ".$where_clause;
        } else
        {
            $whereSQL = " ".trim($where_clause);
        }
    }
    // start the actual SQL statement
    $sql = "SELECT ".$select." FROM ".$table_name." ";

    // append the where statement
    $sql .= $whereSQL.' '.$order_clause.' '.$limit_clause;

    // run and return the query result
    return mysqli_query($link,$sql);
    
}

/*INSERT*/
function DBInsert($table_name, $form_data)
{
	require($_SERVER["DOCUMENT_ROOT"].'/igw_includes/config/dbc.php');
    // retrieve the keys of the array (column titles)
    $fields = array_keys($form_data);

    // build the query
    $sql = "INSERT INTO ".$table_name."
    (`".implode('`,`', $fields)."`)
    VALUES('".implode("','", $form_data)."')";

    // run and return the query result resource
    return mysqli_query($link,$sql);
}

/*UPDATE*/
// again where clause is left optional
function DBUpdate($table_name, $form_data, $where_clause='')
{
	require($_SERVER["DOCUMENT_ROOT"].'/igw_includes/config/dbc.php');

    // check for optional where clause
    $whereSQL = '';
    if(!empty($where_clause))
    {
        // check to see if the 'where' keyword exists
        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
        {
            // not found, add key word
            $whereSQL = " WHERE ".$where_clause;
        } else
        {
            $whereSQL = " ".trim($where_clause);
        }
    }
    // start the actual SQL statement
    $sql = "UPDATE ".$table_name." SET ";

    // loop and build the column /
    $sets = array();
    foreach($form_data as $column => $value)
    {
         $sets[] = "`".$column."` = '".$value."'";
    }
    $sql .= implode(', ', $sets);

    // append the where statement
    $sql .= $whereSQL;

    // run and return the query result
    return mysqli_query($link,$sql);
}

/*DELETE*/
// the where clause is left optional incase the user wants to delete every row!
function DBDelete($table_name, $where_clause='')
{
	require($_SERVER["DOCUMENT_ROOT"].'/igw_includes/config/dbc.php');

    // check for optional where clause
    $whereSQL = '';
    if(!empty($where_clause))
    {
        // check to see if the 'where' keyword exists
        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
        {
            // not found, add keyword
            $whereSQL = " WHERE ".$where_clause;
        } else
        {
            $whereSQL = " ".trim($where_clause);
        }
    }
    // build the query
    $sql = "DELETE FROM ".$table_name.$whereSQL;

    // run and return the query result resource
    return mysqli_query($link,$sql);
}

function get_tags($UDATE){
		if($_GET["t"]==0){ $filter="AND et.ID_TAG NOT IN (1,3,2)"; }
		$etiquetas = DBSelect('igw_emails_tags et, igw_tags t', '*'," WHERE et.ID_TAG=t.ID_TAG AND et.ID_MAIL='".$UDATE."' ".$filter."",'','');
		
		while($et = mysqli_fetch_array($etiquetas)){
			echo '<div data-actiontag="'.$et["ID_TAG"].'" style="cursor: pointer;" data-idmail="'.$UDATE.'" class="btn btn-'.$et["TAG_COLOR"].' btn-xs"><i class="fa'.$et["ICON_S"].' fa-'.$et["TAG_ICON"].'" style="display: inline;"></i>'.$et["TAG"].'</div> ';
		}
		
	}

function get_star($UDATE){
		$etiquetas = mysqli_fetch_array(DBSelect('igw_emails_tags et, igw_tags t', '*'," WHERE et.ID_TAG=t.ID_TAG AND et.ID_MAIL='".$UDATE."' AND et.ID_TAG=1",'LIMIT 0,1',''));
		//echo '<pre>';print_r($etiquetas);echo '</pre>';
		if($etiquetas["ID_TAG"]==1){
		return '<a href="index.php?a=unstar&u='.$UDATE.'"><i class="fa fa-star mr-2 text-warning"></i></a>';
		}else{
		return '<a href="index.php?a=star&u='.$UDATE.'"><i class="far fa-star mr-2 text-gray"></i></a>';
		}
		
		
	}

function get_task($UDATE){
		$etiquetas = mysqli_fetch_array(DBSelect('igw_emails_tags et, igw_tags t', '*'," WHERE et.ID_TAG=t.ID_TAG AND et.ID_MAIL='".$UDATE."' AND et.ID_TAG=3",'LIMIT 0,1',''));
		//echo '<pre>';print_r($etiquetas);echo '</pre>';
		if($etiquetas["ID_TAG"]==3){
		return '<a href="index.php?a=untag&t='.$etiquetas["ID_TAG"].'&u='.$UDATE.'"><i class="fa fa-tasks mr-2 text-warning"></i></a>';
		}else{
		return '0';
		}
		
		
	}
	
	function get_spam($UDATE){
		$etiquetas = mysqli_fetch_array(DBSelect('igw_emails_tags et, igw_tags t', '*'," WHERE et.ID_TAG=t.ID_TAG AND et.ID_MAIL='".$UDATE."' AND et.ID_TAG=2",'LIMIT 0,1',''));
		//echo '<pre>';print_r($etiquetas);echo '</pre>';
		if($etiquetas["ID_TAG"]==2){
		return '1';
		}else{
		return '0';
		}
		
		
	}

	
function get_tag_count($id_tag){
		$etiquetas_count = mysqli_fetch_array(DBSelect('igw_emails_tags', 'COUNT(*) AS total'," WHERE ID_TAG='".$id_tag."'  ",'',''));
		
		return (int)$etiquetas_count["total"];
		
	}

/*Otras funciones*/
function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}

function listFolderFiles($dir){
    $ffs = scandir($dir);

    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);

    // prevent empty ordered elements
    if (count($ffs) < 1)
        return;
	$prof=0;
    echo '<ul>';
    foreach($ffs as $ff){
	    if(strstr($ff,'MSG_ID_')==true){
		    $idff=str_replace(array('MSG_ID_','.eml'), '',$ff);
	    }
       	if(is_dir($dir.'/'.$ff)) { echo '<li class="jstree-open">'; }else{ echo '<li data-jstree=\'{"icon":"/igw_template/assets/img/envelope.png"}\'>'; }
        if(is_dir($dir.'/'.$ff)) { echo $ff; }else{ echo '<a href="#'.$idff.'">'.$ff.'</a>'; }
        if(is_dir($dir.'/'.$ff)) { listFolderFiles($dir.'/'.$ff); }
        echo '</li>';
    }
    echo '</ul>';
}
function checkEmail($str)
{
	return preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $str);
}



function randomKey($number) {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $number; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}


function showdateformat($date){
	$datetime=strtotime($date);
	
	return date('d-m-Y',$datetime);
	
}

function showdateformatback($date){
	$datetime=strtotime($date);
	
	return date('Y-m-d',$datetime);
	
}

function showdateformat_complete($date){
	$datetime=strtotime($date);
	
	return date('d-m-Y H:i',$datetime);
	
}


/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source https://gravatar.com/site/implement/images/php/
 */
function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

function generateRandomString($length = 3) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function stripAccents($stripAccents){
  return strtr($stripAccents,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
}

function new_password_generator($hash,$encode,$cost,$echo=0){
	
	$options = [
	    'cost' => $cost,
	];
	if($echo==0){
		return password_hash($hash,$encode, $options);
	}else{
		echo password_hash($hash,$encode, $options);
	}
	
	
}

function get_stats(){
  $stats_query = DBSelect('igw_emails', 'FILE,UDATE',"",'','');
  $count_stats=array();
  
  /*
  1 - Correos
  2 - Por años
  3 - Por meses
  */
  while($row=mysqli_fetch_array($stats_query)){
    $bloques = explode("/",str_replace('./',"",$row['FILE']));
    
    for($i=0; $i<count($bloques); $i++){
      if(strstr($bloques[$i], "MSG_ID")){
        
      }elseif(strstr($bloques[$i], "mailbackup")){
        
      }else{
        $count_stats[$i]["".$bloques[$i].""]++;
        if($i>=2){ $count_stats[$i]["".$bloques[$i-1]."-".$bloques[$i].""]++; }
        
      }
    }
    $count_stats[4]["".date("H",$row['UDATE']).""]++;
    $count_stats[4]["".$bloques[2]."-".date("H",$row['UDATE']).""]++;

    
  }
  return $count_stats; 
}


?>