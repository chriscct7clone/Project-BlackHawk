<?php
/* THIS FILE IS NOT IN USE but could be useful */
function detectSSL()
{
    if (getArrayVal($_SERVER, "https") == "on")
    {
        return true;
    } elseif (getArrayVal($_SERVER, "https") == 1)
    {
        return true;
    } elseif (getArrayVal($_SERVER, "SERVER_PORT") == 443)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function getMyUrl()
{
    if (isset($_SERVER['REQUEST_URI']) && !empty($_SERVER['REQUEST_URI'])){
        $requri = $_SERVER['REQUEST_URI'];
    }
    else {
        // assume IIS
        $requri = $_SERVER['SCRIPT_NAME'];
        if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
            $requri .= '?' . $_SERVER['QUERY_STRING'];
        }
    }
    $host = $_SERVER['HTTP_HOST'];
    $pos1 = strrpos($requri, "/");
    $requri = substr($requri, 0, $pos1 + 1);
    if (detectSSL())
    {
        $host = "https://" . $host;
    }
    else
    {
        $host = "http://" . $host;
    }
    $url = $host . $requri;

    return $url;
}
function delete_directory($dirname)
{
    if (is_dir($dirname))
    {
        $dir_handle = opendir($dirname);
    }
    if (!$dir_handle)
    {
        return false;
    }
    while ($file = readdir($dir_handle))
    {
        if ($file != "." && $file != "..")
        {
            if (!is_dir($dirname . "/" . $file))
            {
                unlink($dirname . "/" . $file);
            }
            else
            {
                delete_directory($dirname . '/' . $file);
            }
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}

?>