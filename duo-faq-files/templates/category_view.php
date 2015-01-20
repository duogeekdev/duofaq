<?php ob_start(); ?>

<h2><?php _e('Frequently Asked Question on', 'df'); ?> <?php echo $cat->name; ?></h2>
<?php
    $args = array(
        'post_type' => 'faq',
        'faq_categories' => $cat->slug,
        'posts_per_page' => -1
    );
    $posts = get_posts($args);
?>
<div class="smart_accordion accod_parent">
    <?php foreach($posts as $post) { ?>
    <div class="smartItems">
        <h3 class="accordion_title"><?php echo $post->post_title; ?></h3>
        <div class="smartItemsDetails">
            <?php echo $post->post_content; ?>
        </div>
    </div>
    <?php } ?>
</div>s
<?php $html .= ob_get_clean();