<?php ob_start();  ?>

<h2 id="faq-top"><?php _e('Frequently Asked Question', 'df') ?></h2>
<div class="smart_all_accordion accod_parent">
    <ul class="faq-labels">
        <?php foreach($cat as $item) { ?>
        <li><a class="<?php echo $data['theme']; ?>" href="#<?php echo str_replace(' ', '_', trim($item->slug)) ?>"><?php echo $item->name ?></a></li>
        <?php } ?>
    </ul>
<?php
    foreach($cat as $item) {
        
        $args = array(
            'post_type' => 'faq',
            'faq_categories' => $item->slug,
            'posts_per_page' => -1
        );
        $posts = get_posts($args);
?>
<h2 class="faq-cat-title" id="<?php echo str_replace(' ', '_', trim($item->slug)) ?>"><?php echo $item->name; ?></h2>
    <?php foreach($posts as $post) { ?>
    <div class="smartItems">
        <h3 class="accordion_title"><?php echo $post->post_title; ?></h3>
        <div class="smartItemsDetails">
            <?php echo $post->post_content; ?>
        </div>
    </div>
    <?php } ?>
        <?php
    }
?>
</div>
<?php $html .= ob_get_clean();