<?php

/*
 * CKFinder Configuration File
 * https://ckeditor.com/docs/ckfinder/ckfinder3-php/
 */

/*============================ PHP Error Reporting ====================================*/

// Production:
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', 0);

// Development:
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/*============================ General Settings =======================================*/

$config = array();

/*============================ Enable PHP Connector HERE ==============================*/

// GANTI return false MENJADI return true ATAU SESSION VALIDASI
$config['authentication'] = function () {
    session_start();
    // Contoh: hanya izinkan jika user login & level admin
    return isset($_SESSION['login']) && ($_SESSION['level'] == 1);
    // Untuk development BISA DIGANTI:
    // return true;
};

/*============================ License Key ============================================*/

$config['licenseName'] = '';
$config['licenseKey']  = '';

/*============================ CKFinder Internal Directory ============================*/

$config['privateDir'] = array(
    'backend' => 'default',
    'tags'   => '.ckfinder/tags',
    'logs'   => '.ckfinder/logs',
    'cache'  => '.ckfinder/cache',
    'thumbs' => '.ckfinder/cache/thumbs',
);

/*============================ Images and Thumbnails ==================================*/

$config['images'] = array(
    'maxWidth'  => 1600,
    'maxHeight' => 1200,
    'quality'   => 80,
    'sizes' => array(
        'small'  => array('width' => 480, 'height' => 320, 'quality' => 80),
        'medium' => array('width' => 600, 'height' => 480, 'quality' => 80),
        'large'  => array('width' => 800, 'height' => 600, 'quality' => 80)
    )
);

/*=================================== Backends ========================================*/

$config['backends'][] = array(
    'name'         => 'default',
    'adapter'      => 'local',
    'baseUrl'      => '/ckfinder/userfiles/',
    // Uncomment & atur jika butuh root absolut:
    // 'root'         => __DIR__ . '/userfiles/',
    'chmodFiles'   => 0777,
    'chmodFolders' => 0755,
    'filesystemEncoding' => 'UTF-8',
);

/*================================ Resource Types =====================================*/

$config['defaultResourceTypes'] = '';

$config['resourceTypes'][] = array(
    'name'              => 'Files',
    'directory'         => 'files',
    'maxSize'           => 0,
    'allowedExtensions' => '7z,aiff,asf,avi,bmp,csv,doc,docx,fla,flv,gif,gz,gzip,jpeg,jpg,mid,mov,mp3,mp4,mpc,mpeg,mpg,ods,odt,pdf,png,ppt,pptx,qt,ram,rar,rm,rmi,rmvb,rtf,sdc,swf,sxc,sxw,tar,tgz,tif,tiff,txt,vsd,wav,webp,wma,wmv,xls,xlsx,zip',
    'deniedExtensions'  => '',
    'backend'           => 'default'
);

$config['resourceTypes'][] = array(
    'name'              => 'Images',
    'directory'         => 'images',
    'maxSize'           => 0,
    'allowedExtensions' => 'bmp,gif,jpeg,jpg,png,webp',
    'deniedExtensions'  => '',
    'backend'           => 'default'
);

/*================================ Access Control =====================================*/

$config['roleSessionVar'] = 'CKFinder_UserRole';

$config['accessControl'][] = array(
    'role'                => '*',
    'resourceType'        => '*',
    'folder'              => '/',

    'FOLDER_VIEW'         => true,
    'FOLDER_CREATE'       => true,
    'FOLDER_RENAME'       => true,
    'FOLDER_DELETE'       => true,

    'FILE_VIEW'           => true,
    'FILE_CREATE'         => true,
    'FILE_RENAME'         => true,
    'FILE_DELETE'         => true,

    'IMAGE_RESIZE'        => true,
    'IMAGE_RESIZE_CUSTOM' => true
);

/*================================ Other Settings =====================================*/

$config['overwriteOnUpload'] = false;
$config['checkDoubleExtension'] = true;
$config['disallowUnsafeCharacters'] = false;
$config['secureImageUploads'] = true;
$config['checkSizeAfterScaling'] = true;
$config['htmlExtensions'] = array('html', 'htm', 'xml', 'js');
$config['hideFolders'] = array('.*', 'CVS', '__thumbs');
$config['hideFiles'] = array('.*');
$config['forceAscii'] = false;
$config['xSendfile'] = false;

$config['debug'] = false;

/*==================================== Plugins ========================================*/

$config['pluginsDirectory'] = __DIR__ . '/plugins';
$config['plugins'] = array();

/*================================ Cache settings =====================================*/

$config['cache'] = array(
    'imagePreview' => 24 * 3600,
    'thumbnails'   => 24 * 3600 * 365,
    'proxyCommand' => 0
);

/*============================ Temp Directory settings ================================*/

$config['tempDirectory'] = sys_get_temp_dir();

/*============================ Session Cause Performance Issues =======================*/

$config['sessionWriteClose'] = true;

/*================================= CSRF protection ===================================*/

$config['csrfProtection'] = true;

/*===================================== Headers =======================================*/

$config['headers'] = array();

/*============================== End of Configuration =================================*/

return $config;
