<?php

// NOTE: the core client fetches download.php?xml=1 every so often;
// don't break this!!!

require_once("docutil.php");
require_once("versions.inc");
require_once("download_util.inc");
require_once("../html/inc/translation.inc");

$apps = array(
    array('classic.jpg', 180, 143),
    array('cpdn_200.jpg', 200, 147),
    array('eah_200.png', 200, 150),
    array('rosetta_at_home.jpg', 200, 150),
    array('qah.200x150.png', 200, 150),
);

function show_pictures() {
    global $apps;
    shuffle($apps);
    $a0 = $apps[0];
    $a1 = $apps[1];
    $f0 = $a0[0];
    $f1 = $a1[0];
    echo "
        <div style=\"max-height: 300px\">
        <img src=\"images/mgrwork.png\" alt=\"BOINC manager\"><br>
        <div style=\"position:relative; top:-80px; left:30px\">
            <img src=\"images/$f0\" alt=\"BOINC project\"><br>
        </div>
        <div style=\"position:relative; top:-160px; left:70px\">
            <img src=\"images/$f1\" alt=\"BOINC project\"><br>
        </div>
        </div>
    ";
}

function show_download($client_info, $pname) {
    echo "
        <table cellpadding=10><tr><td valign=top>
        ".tra("BOINC is a program that lets you donate your idle computer time to science projects like SETI@home, Climateprediction.net, Rosetta@home, World Community Grid, and many others.")
        ."  "
        .tra("After installing BOINC on your computer, you can connect it to as many of these projects as you like.")
        ."<p>"
        .tra("You may run this software on a computer only if you own the computer or have the permission of its owner.").
        "<p>"
    ;
    if ($pname == 'android') {
        echo "<b>"
            .tra("We recommend that you download BOINC from the Google Play Store or Amazon Appstore, not from here.")
            ." </b>
        ";
    }
    if ($pname) {
        download_link($client_info, $pname, true);
    } else {
        list_start();
        list_heading_array(array(
            'Computer type',
            'BOINC version ',
            'Click to download'
        ));
        download_link($client_info, 'win');
        download_link($client_info, 'winx64');
        download_link($client_info, 'mac');
        download_link($client_info, 'macppc');
        download_link($client_info, 'linux');
        download_link($client_info, 'linuxx64');
        download_link($client_info, 'linuxcompat');
        download_link($client_info, 'android');
        list_end();
        echo "Linux users: BOINC is available as a package for many Linux distributions.  It is available for Linux/ARM as a package for Debian and Ubuntu for ARM, and Raspbian (for Raspberry Pi).";
    }
    if ($pname != 'android') {
        echo "
            <br>
            After downloading BOINC you must <b>install</b> it:
            typically this means double-clicking on the file icon
            when the download is finished.
        ";
    }
    echo "
        <p>
        <center>
        <a href=\"wiki/System_requirements\"><span class=nobr>".tra("System requirements")."</span></a>
        &middot; <a href=\"wiki/Release_Notes\"><span class=nobr>".tra("Release notes")."</span></a>
        &middot; <a href=\"wiki/BOINC_Help\"><span class=nobr>".tra("Help")."</span></a>
        &middot; <a href=download_all.php><span class=nobr>".tra("All versions")."</span></a>
        &middot; <a href=\"trac/wiki/VersionHistory\">".tra("Version history")."</a>
        &middot; <a href=http://boinc.berkeley.edu/wiki/GPU_computing>".tra("GPU computing")."</a>
        </center>
        </td>
        <td valign=top>
    ";
    show_pictures();
    echo "
        </td>
        </tr></table>
    ";
}

if (get_str2('xml')) {
    $args = strstr($_SERVER['REQUEST_URI'], '?');
    Header("Location: download_all.php$args");
    exit();
}

$client_info = $_SERVER['HTTP_USER_AGENT'];

page_head(tra("BOINC: compute for science"));

if (get_str2('all_platforms')) {
    show_download($client_info, null);
} else {
    show_download($client_info, client_info_to_platform($client_info));
}

page_tail(true);

?>
