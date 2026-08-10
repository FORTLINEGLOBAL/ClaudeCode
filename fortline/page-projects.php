<?php
/**
 * Template Name: Projects
 */
get_header(); ?>

<section class="fl-proj" id="projects">
<div class="container">
<div class="section-label fade-in" style="text-align:center;color:var(--gold-bright)" data-i18n="proj.label">Our Work</div>
<div class="section-title fade-in" style="text-align:center" data-i18n="proj.title">Selected Projects</div>
<p class="fade-in" style="color:var(--text-light);max-width:700px;margin:0.5rem auto 0;font-size:0.95rem;text-align:center;line-height:1.7" data-i18n="proj.subtitle">From private safe rooms to institutional protected spaces and community-scale programs  -  planned, licensed and built end to end.</p>
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
