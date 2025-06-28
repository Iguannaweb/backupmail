<?php
define('INCLUDE_CHECK','true');
include('igw_includes/login/session.php');
include('igw_includes/config/dbc.php');
include('igw_includes/config/mail.config.php');
include('igw_includes/functions/functions.php');
include('igw_includes/login/login.php');
include('igw_includes/login/extra_parameters.php');

if(isset($_SESSION['id']) && isset($activo['activo']) && ($activo['activo']==1) && ($activo['tipo']=="ADM")){
    $domain = '';
    if(isset($_GET['domain'])){
        $domain = strtolower(preg_replace('/[^a-z0-9.-]/i','', $_GET['domain']));
    }
    if($domain !== ''){
        $file = 'igw_includes/config/allowed_image_urls.json';
        if(file_exists($file)){
            $domains = json_decode(file_get_contents($file), true);
            if(!is_array($domains)){
                $domains = array();
            }
        }else{
            $domains = array();
        }
        if(!in_array($domain, $domains)){
            $domains[] = $domain;
            file_put_contents($file, json_encode(array_values($domains), JSON_PRETTY_PRINT));
        }
    }
    if(isset($_SERVER['HTTP_REFERER'])){
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }else{
        header('Location: index.php');
    }
    die();
}else{
    header('Location: index.php');
    die();
}
?>
