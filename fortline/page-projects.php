<?php
/**
 * Template Name: Projects
 */
get_header(); ?>

<!-- ===== PAGE HERO (video banner) ===== -->
<section class="page-hero" id="hero">
<video autoplay muted loop playsinline>
<source src="<?php echo get_template_directory_uri(); ?>/images/Backgroundf.mp4" type="video/mp4">
</video>
<div class="ph-inner fade-in">
<div class="ph-label" data-i18n="proj.label">Our Work</div>
<h1 data-i18n="proj.title">Selected Projects</h1>
<p data-i18n="proj.subtitle">From private safe rooms to institutional protected spaces and community-scale programs  -  planned, licensed and built end to end.</p>
</div>
</section>

<section class="fl-proj" id="projects">
<div class="container">
<div class="fl-proj-grid fade-in">
<?php
$fortline_projects = array(
    array('img' => 'proj03.jpg', 'cap' => 'Residential-Tower MAMADs'),
    array('img' => 'proj01.jpg', 'cap' => 'Mobile Protected Structures'),
    array('img' => 'proj09.jpg', 'cap' => 'Safe-Room Reinforcement'),
    array('img' => 'proj08.jpg', 'cap' => 'Cast-Concrete Safe Rooms'),
    array('img' => 'proj05.jpg', 'cap' => 'Completed Safe Rooms'),
    array('img' => 'proj07.jpg', 'cap' => 'Institutional Protected Spaces'),
);
$proj_i = 0;
foreach ($fortline_projects as $pr): $proj_i++; ?>
  <div class="fl-proj-card">
    <img src="<?php echo get_template_directory_uri(); ?>/images/projects/<?php echo $pr['img']; ?>" alt="<?php echo esc_attr($pr['cap']); ?>" loading="lazy">
    <div class="fl-proj-cap"><h4 data-i18n="proj.cap<?php echo $proj_i; ?>"><?php echo esc_html($pr['cap']); ?></h4></div>
  </div>
<?php endforeach; ?>
</div>
</div>
</section>



<?php get_footer(); ?>
