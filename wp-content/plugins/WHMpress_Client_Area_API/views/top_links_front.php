<?php

/* 0 - home
 * 10 - store
 * 20 - Announcements
 * 30 - Knowledgebase
 * 40 - Network status
 * 50 - Contact us
 * 70 - Account
 * * Login
 * * register
 * * forget password
 */

$WCAP_Menu = $this->get_front_menu_array();

$menu_settings = (get_option("wcapfield_hide_whmcs_menu_sections_front") == '') ? [] :
    get_option("wcapfield_hide_whmcs_menu_sections_front");


if (!isset($_GET['wcap'])) {
    $_GET['wcap'] = "dashboard";
}


?>

<!--<script>
	//var WCAP_SESSION = <?php /*//echo json_encode( $_SESSION ) */ ?>;
</script>-->

<div id="wcap_loading"><?php esc_html_e( "Loading...", "whcom" ) ?></div>

<nav id="primary_nav_wrap">
    <ul class="wcap_navbar_left">
        <?php
        wcap_print_menu($menu_settings, $WCAP_Menu, "left");
        ?>
    </ul>


    <ul class="wcap_navbar_right">
        <?php
        wcap_print_menu($menu_settings, $WCAP_Menu, "right");
        ?>
    </ul>

</nav>
<div style="clear:both"></div>

    <?php

    function print_menu_front($menu_settings, $WCAP_Menu, $show)
    {


        foreach ($WCAP_Menu as $menu_key => $menu_array) {

            if ($show == "left") { //show all except 70
                if ($menu_key == '70') {
                    continue;
                }
            }

            if ($show == 'right') { //show only 70
                if ($menu_key != '70') {
                    continue;
                }
            }

            // if an entry is hidden, continue to next entry, dont showit
            if ($menu_settings[$menu_key]['hide'] == 'hide') {
                continue;
            }

            // set active menu
            $active_li = false;
            if (isset($menu_array['sub']) && is_array($menu_array['sub'])) {
                foreach ($menu_array['sub'] as $sub_menu_array) {
                    if (isset($sub_menu_array["page"]) && $sub_menu_array["page"] == $_GET['wcap']) {
                        $active_li = true;
                        break;
                    }
                }
            } else {
                if ($menu_array["page"] == @$_GET['wcap']) {
                    $active_li = true;
                }
            }
            ?>


            <?php //display menu
            ?>
            <li class="<?php echo $active_li ? "current-menu-item" : "" ?>">
                <a class="<?php echo $menu_array['class'] ?>"
                    <?php
                    if (!empty ($menu_settings[$menu_key]['url_override']) && !($menu_settings[$menu_key]['url_override']) == "") {//if custom link, no need of data-page attribute
                        ?>
                        href="<?php echo $menu_settings[$menu_key]['url_override']; ?>"
                        <?php
                    } else //no URL provided
                    {
                        ?>
                        data-page="<?php echo isset($menu_array["page"]) ? $menu_array["page"] : "" ?>"
                        href="<?php echo isset($menu_array["href"]) ? $menu_array["href"] : "#" ?>"
                        <?php
                    }

                    ?>
                   id="<?php echo isset($menu_array["id"]) ? $menu_array["id"] : "" ?>">
                    <?php echo $menu_array["label"] ?>
                    <?php echo (isset($menu_array['sub']) && is_array($menu_array['sub'])) ? ' <i class="whcom_icon_down-open"></i>' : ''; ?>
                </a>

                <?php if (isset($menu_array['sub']) && is_array($menu_array['sub'])) {
                    $sub_menu_index=0;
                    ?>
                    <ul>

                        <?php foreach ($menu_array['sub'] as $sub_menu_array) {
                            // if an entry is hidden, continue to next entry, dont showit
                            if ($menu_settings[$menu_key]['sub'][$sub_menu_index]['hide'] == 'hide') {
                                $sub_menu_index++;
                                continue;
                            }

                            if ($sub_menu_array["label"] == "LINE") {
                                echo '<li class="separator"></li>';
                            } else { ?>
                                <li class="<?php echo $sub_menu_array["page"] == $_GET['wcap'] ? 'current-menu-item' : ""; ?>">
                                    <a class="<?php echo $sub_menu_array['class'] ?>"
                                        <?php
                                        if (!empty ($menu_settings[$menu_key]['sub'][$sub_menu_index]['url_override'])
                                            && trim($menu_settings[$menu_key]['sub'][$sub_menu_index]['url_override'])!="")
                                        {//if custom link, no need of data-page attribute
                                            ?>
                                            href="<?php echo $menu_settings[$menu_key]['sub'][$sub_menu_index]['url_override']; ?>"
                                            <?php
                                        } else //no URL provided
                                        {
                                            ?>
                                            data-page="<?php echo isset($sub_menu_array["page"]) ? $sub_menu_array["page"] : "" ?>"
                                            href="<?php echo isset($sub_menu_array["href"]) ? $sub_menu_array["href"] : "#" ?>"
                                            <?php
                                        }
                                        ?>
                                       id = "<?php echo isset($sub_menu_array["id"]) ? $sub_menu_array["id"] : "" ?>" >
                                        <?php echo $sub_menu_array["label"] ?>
                                    </a>
                                </li>
                            <?php }
                            $sub_menu_index++;
                        } ?>
                    </ul>

                <?php } ?>
            </li>
        <?php }
    }

    ?>

