<?php
/**
 * 404 Template
 */
get_header();
?>
<div style="text-align: center; padding: 100px 20px;">
    <h1>404 - Page Not Found</h1>
    <p>Sorry, the page you are looking for does not exist.</p>
    <a href="<?php echo esc_url(home_url('/')); ?>">Back to Home</a>
</div>
<?php get_footer(); ?>
