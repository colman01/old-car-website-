<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
  <title><?=$title?></title>
  <link rel="stylesheet"    type="text/css"     href="layout/main.css" />
  <link rel="shortcut icon" type="image/x-icon" href="layout/images/bluecar_32x32.ico" />
</head>

<body>
<!-- header begin -->
  <div id="logo">&nbsp;</div>
  <div class="headerline">&nbsp;</div>

<!-- menu begin -->
  <div id="menu" align="center">
    <table cellpadding="0" cellspacing="0" border="0"><tr>

      <td valign="top">
        <a href=                        ".?<?=$SID?>">Home</a>
        <a href=         "carad_browse.php?<?=$SID?>">Browse used cars</a>
        <a href=    "carad_submit_form.php?<?=$SID?>">Advertise Car Online</a>
        <a href=    "carad_search_form.php?<?=$SID?>">Search Used Car</a>
        <a href=                  "mmm.php?<?=$SID?>">Monthly motor market</a>
        <a href=    "sell_service_form.php?<?=$SID?>">Have us sell your car</a>
      </td>

      <td valign="top">
<?php if ($SID) { ?>
        <a href=         "account_home.php?<?=$SID?>">My Car Ads</a>
        <a href= "account_details_view.php?<?=$SID?>">Account Details</a>
        <a href="account_logout_action.php?<?=$SID?>">Logout</a>
<?php } else { ?>
        <a href="account_register_form.php?<?=$SID?>">Register</a>
        <a href=   "account_login_form.php?<?=$SID?>">Login</a>
<?php } ?>
      </td>

<?php if ($SID && $_SESSION['account_id'] == 1) { ?>
      <td valign="top">
        <a href="update_links_form.php?<?=$SID?>">Update Links</a>
      </td>
<?php } ?>

    </tr></table>
  </div>
<!-- menu end -->

<!-- header end -->

<!-- content begin -->
  <div id="content">
    <table cellpadding="0" cellspacing="0"><tr>
      <td valign="top">
      <div id="con"><div class="padd">
      &nbsp;<br />

<!-- end of file pagebegin.php -->
