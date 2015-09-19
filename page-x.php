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
	<!-- tooltip -->
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/tooltip/tooltipster.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.0.min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/tooltip/jquery.tooltipster.min.js"></script>
  <!-- FIXME -->
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
								touchDevices: false,
								trigger: 'hover'
							});
						});
						";

						 } //while
					wp_reset_postdata();
				} else {
					/**
										 echo 'dont generate anything';
					*/
					} //if
			 } //feach array sub
	 	} //feach array loc
  ?>
	</script><!-- generated jquery end -->
<style type="text/css">
	.edha-theme {
	border-radius: 1px;
	border: 2px solid #fff;
	background: #F05133;
	color: #fff;
	}
	.edha-theme-past{
	border-radius: 1px;
	border: 2px solid #fff;
	background: #ECA699;
	color: #fff;
  }
 .edha-theme a, .edha-theme-past a{color:#fff;text-decoration:underline}
 .edha-theme .tooltipster-content, .edha-theme-past .tooltipster-content {
		font-family: "Helvetica Neue", Helvetica, Arial, "Sans-Serif";
		font-size: 11px;
		line-height: 15px;
		padding: 11px 15px;
		max-width: 350px;
	}
	.ed-cell{}
	.ongoing{
		background-color: #aaa;
    padding: 10px;
    font-size: 11px;
    color: white;
		border-bottom: 1px solid white;
    border-top: 1px solid white;
		}
	.past{
		background-color: #CACACA;
    padding: 10px;
    font-size: 11px;
    color: white;
		border-bottom: 1px solid white;
    border-top: 1px solid white;
	}
	table {
	    border-collapse: collapse;
	    border-spacing: 0;
	    border: 5px solid #fff;
	}
	td,th {
  /*FIXME */ width:20%;
			border-left: 7px solid white;
			border-top: 6px solid white;	}
	/*tbody tr:nth-child(even)  td { background-color: #aaa; }*/
	.ehda_th{
		padding: 11px 18px;
		background-color:#F05133;
		font-weight: 800;
		color: #fff;
		vertical-align: middle;
		border: 1px solid white
		}

	@media screen and (max-width: 640px) {
		table {
			overflow-x: auto;
			display: block;
		}
		td { width:100%}
	}
</style>
<?php } // end function for wp head

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
/**
* FIXME
another set on mobiles
*/

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
			<td class="ehda_th">
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
			<td>
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
								<div class="eh-cell">
									&nbsp;
								</div>
			<?php	} //if ?>
  		</td>
 		<?php } //feach array sub ?>
		</tr>
	<?php } //feach array loc ?>
	</tbody>
</table>

<div style="visibility:hidden">
	<?php get_template_part( 'loop', 'page' ); ?>
</div>
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
