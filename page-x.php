<?php

function getSubcats( $parent ) {
	$subcats = array();
	$taxonomy='ehproject_cat';
	$subcats = get_term_children( $parent, $taxonomy );
	return $subcats;
}

function getCellIDs( $array_loc, $array_sub ) {

	$cellids=array();
		foreach ($array_loc as $locid) {
			foreach ($array_sub as $subjectid) {
			$id = 'loc' . $locid . 'sub' . $subjectid;
			array_push($cellids, $id);
	 		}
		}
	return $cellids;
}
function tt250() { ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- tooltip -->
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/tooltip/tooltipster.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.0.min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/tooltip/jquery.tooltipster.min.js"></script>
	<!-- generated jquery start -->
	<script type="text/javascript">
	<?php
	global $post;
	$array_loc = array();
	 $array_sub = array();
	  $taxonomy = 'ehproject_cat';
	$array_loc = getSubcats( '17');
	 $array_sub = getSubcats( '18');
		foreach ( $array_loc as $locid) {
	   foreach ($array_sub as $subjectid) {
			$tooltip_args = array(
				'post_type' => 'ehproject',
				'tax_query' => array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'ehproject_cat',
						'field'    => 'term_id',
						'terms'    => $subjectid,
					),
					array(
						'taxonomy' => 'ehproject_cat',
						'field'    => 'term_id',
						'terms'    => $locid,
						),
					),
				);
				$tquery = new WP_Query( $tooltip_args );
				if ( $tquery->have_posts() ) {
					while ( $tquery->have_posts() ) {
						$tquery->the_post();
						$tooltip_id = 'cell' . $post->ID; // the div ID
						$tooltip_content = addslashes( rwmb_meta( 'rw_content' ) );
						 $tooltip_content = preg_replace('~>\s+<~', '><', $tooltip_content);
							if ( wp_is_mobile() ) {
								$tdshow = 'true';
								$trig = 'click';
							} else {
								$tdshow = 'false';
								$trig = 'hover';
							}
						$t=get_the_title();
						if ( strpos( $t,'[active]' )===FALSE ) $tooltip_style="-past";
						else $tooltip_style = "";

						echo "
						$(document).ready(function() {
							$('#" . $tooltip_id . "').tooltipster({
								content: $('<span>" . $tooltip_content . "</span>'),
								animation: 'fade',
								delay: 50,
								interactive: true,
								interactiveTolerance: 500,
								theme: 'edha-theme" . $tooltip_style . "',
								touchDevices: " . $tdshow . ",
								trigger: '" . $trig . "'
							});
						});
						";

						 } //while
					wp_reset_postdata();
				 } //if
			 } //feach array sub
	 	} //feach array loc
  ?>
	</script><!-- generated jquery end -->
<style type="text/css">
.edha-theme{border-radius:1px;border:2px solid #fff;background:#F05133;color:#fff}
.edha-theme-past{border-radius:1px;border:2px solid #fff;background:#ECA699;color:#fff}
.edha-theme a,.edha-theme-past a{color:#fff;text-decoration:underline}
.edha-theme .tooltipster-content,.edha-theme-past .tooltipster-content{font-family:"Helvetica Neue",Helvetica,Arial,"Sans-Serif";font-size:11px;line-height:15px;padding:11px 15px;max-width:350px}
.ongoing,.past{/*margin-bottom:15px;*/padding:10px;font-size:11px;color:#fff;border-bottom:1px solid #fff;border-top:1px solid #fff}
.ongoing{background-color:#aaa;}
.past{background-color:#CACACA;}
table{border-collapse:collapse;border-spacing:0;border:5px solid #fff}
td,th{width:auto;border-left:7px solid #fff;border-top:6px solid #fff}
.ehda_th{padding:11px 18px;background-color:#F05133;font-weight:800;color:#fff;vertical-align:middle;border:1px solid #fff}

/* Phones */
@media(max-width: 770px) {
#firstrow,.void{display:none!important}
.wrapper{width:100%!important}

table{overflow-x:auto;display:block}
tr{display:block}
.ehda_th, td{width:auto;display:block!important;border:0}

td[data-title]:before {
      content: attr(data-title);
			background-color: #5A5A5A;
			color: #fff;
	    display: table-cell;
	    border: 1px solid white;
	    padding: 10px;
	    width: 75px;
    	vertical-align: middle;
}
.past,.ongoing{display: table-cell;border-left: 1px solid #fff;}
}


</style>

<?php

} // ========= end function for wp head

add_action('wp_head', 'tt250');
get_header();

?>

<!-- Main Content -->
		<div id="container">
			<div id="content" role="main">

				<h1 class="ehuni_title" style="text-align:center">
					<span>Pipeline of Digital Ideas</span>
				</h1>

<?php
$array_loc = array();
 $array_sub = array();
  $taxonomy = 'ehproject_cat';
$array_loc = getSubcats( '17');
 $array_sub = getSubcats( '18');
  $cellids = getCellIDs( $array_loc, $array_sub );
?>

<table>
	<tbody>
		<tr>
			<td></td>
		<?php foreach ($array_sub as $subjectid) { ?>
			<td class="ehda_th" id="firstrow">
				<?php $array = get_term_by('id', $subjectid, $taxonomy, 'ARRAY_A'); ?>
				<?php print_r($array[name]); ?>
			</td>
			<?php } ?>
		</tr>
	<?php foreach ( $array_loc as $locid) { ?>
		<tr>
			<td class="ehda_th">
				<?php $array = get_term_by('id', $locid, $taxonomy, 'ARRAY_A'); ?>
				<?php print_r($array[name]); ?>
			</td>
	<?php foreach ($array_sub as $subjectid) { ?>
			<td data-title="<?php $array = get_term_by('id', $subjectid, $taxonomy, 'ARRAY_A');
			print_r($array[name]); ?>">
			<?php
			$args = array(
			'post_type' => 'ehproject',
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'ehproject_cat',
					'field'    => 'term_id',
					'terms'    => $subjectid,
				),
				array(
					'taxonomy' => 'ehproject_cat',
					'field'    => 'term_id',
					'terms'    => $locid,
					),
				),
			);
			$query = new WP_Query( $args );
			if ( $query->have_posts() ) {
				 while ( $query->have_posts() ) {
				  $query->the_post(); ?>

						<?php		$t=get_the_title();
							if ( strpos( $t,'[active]' )===FALSE ) $style="past";
							else $style="ongoing";
						?>

								<div class="eh-cell <?php echo $style; ?>" id="<?php echo 'cell' . $post->ID; ?>">
									<?php the_content(); ?>
								</div>

					<?php } //while
				wp_reset_postdata();
	 		} else { ?>
								<div class="eh-cell void">
									&nbsp;
								</div>
			<?php	} //if ?>
  		</td>
 		<?php } //feach array sub ?>
		</tr>
	<?php } //feach array loc ?>
	</tbody>
</table>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
