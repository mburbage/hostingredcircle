<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar( "addons", true );

$args     = [
    "catid" => $_POST['catid'],
];
$response = wcap_get_knowledgebase_articles( $args );

?>

<div class="wcap_services ">
    <div class="whcom_row">
        <?php if ( $show_sidebar ) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <?php wcap_render_support_panel(); ?>
            </div>
        <?php } ?>
        <div class="<?php echo ( $show_sidebar ) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
            <div class="whcom_page_heading">
                <span><?php esc_html_e( "Knowledgebase", "whcom" ) ?></span>
            </div>

            <?php if ( $response["status"] != "OK" ) { ?>
                <div class="whcom_alert whcom_alert_danger whcom_text_center">
                    <?php echo $response["message"] ?>
                </div>
            <?php } ?>

            <?php //main content ?>
            <?php if ( $response["status"] == "OK" ) { ?>
                <?php

                $curr_whmcs_lang           = whcom_get_whmcs_relevant_language();
                $all_kb_articles           = $response["data"];
                $lang_kb_articles          = [];
                $already_added_kb_articles = [];
                foreach ( $all_kb_articles as $all_kb_article ) {
                    if ( $all_kb_article['parentid'] > 0 ) {
                        $already_added_kb_articles[] = $all_kb_article['id'];
                        if ( strtolower( $all_kb_article['language'] ) == strtolower( $curr_whmcs_lang ) ) {
                            $lang_kb_articles[ $all_kb_article['parentid'] ] = $all_kb_article;
                        }
                    }
                } ?>


                <h3><?php esc_html_e( "Articles", "whcom" ) ?></h3>
                <div class="whcom_margin_bottom_30">

                    <?php foreach ( $all_kb_articles as $key => $article ) { ?>
                        <?php
                        if ( $article['hidden'] != 1 && ! in_array( $article['id'], $already_added_kb_articles ) ) {
                            $article_id = $article['id'];
                            $already_added_kb_articles[] = $article_id;
                            if ( ! empty( $lang_kb_articles[ $article_id ] ) ) {
                                $article = $lang_kb_articles[ $article_id ];
                            } ?>
                            <div class="whcom_margin_bottom_15">
                                <div class="whcom_margin_bottom_10">
                                    <i class="whcom_icon_list"></i> <strong><?php echo $article["title"] ?></strong>
                                </div>
                                <?php echo $article["article"] ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>


        </div>
    </div>
</div>