<?php function tt250() { ?>
	<!-- tooltip -->
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/tooltip/tooltipster.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.0.min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/tooltip/jquery.tooltipster.min.js"></script>



	<script type="text/javascript">
	$(document).ready(function() {
/* FIXME generate different one on click on wp_is_mobile */
	  $('#test').tooltipster({
	    content: $('<span>This text is in <a href="#">bold</a> <strong>case!</strong></span>'),
			animation: 'fade',
   		delay: 50,
			interactive: true,
			interactiveTolerance: 500,
   		theme: 'edha-theme',
   		touchDevices: false,
   		trigger: 'hover'
	  });
	});
	</script>

<style type="text/css">
	.edha-theme {
	border-radius: 1px;
	border: 2px solid #fff;
	background: #F05133;
	color: #fff;
	}
	.edha-theme a{color:#fff;text-decoration:underline}
	.edha-theme .tooltipster-content {
		font-family: "Helvetica Neue", Helvetica, Arial, "Sans-Serif";
		font-size: 11px;
		line-height: 15px;
		padding: 11px 15px;
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
		background-color: #D8D8D8;
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
	    border-top: 0px solid #ddd;
			width:20%;
			border: 5px solid white;
	}
	/*tbody tr:nth-child(even)  td { background-color: #aaa; }*/
	.ehda_th{
		padding: 11px 18px;
		background-color:#F05133;
		font-weight: 800;
		color: #fff;
		vertical-align: middle;
		}

	@media screen and (max-width: 640px) {
		table {
			overflow-x: auto;
			display: block;
		}
		td { width:100%}
	}
</style>

<?php }
add_action('wp_head', 'tt250');
?>
<?php get_header(); ?>

		<div id="container">
			<div id="content" role="main">

				<h1 class="ehuni_title" style="text-align:center">
					<span>Pipeline of Digital Ideas</span>
				</h1>


<hr>
Dynamic
<hr>
				<?php
				/**
				* FIXME
				call a post type, all posts
				get title for cell title ?
				get content for cell content
				get post meta for tooltip
				get category = row
				get tag = column
				loop through all cells and search for candidates
				=== CACHE THIS ===
				*/
				?>
<?php
//locations

$taxonomy='ehproject_cat';
$array_loc = array();
$array_sub = array();


$term = '17';
$array_loc = get_term_children( $term, $taxonomy );
//print_r( $array_loc );

//subjects
$term = '18';
$array_sub = get_term_children( $term, $taxonomy );
//print_r( $array_sub );
?>
<table>
<tbody>
	<tr>
		<td> x </td>
<?php
foreach ($array_sub as $subjectid) { ?>
		<td>

		<?php $array = get_term_by('id', $subjectid, $taxonomy, 'ARRAY_A'); ?>
		<?php print_r($array[name]); ?>

	</td>
<?php } ?>
</tr>
<?php
foreach ( $array_loc as $locid) { ?>
	<tr>
	<td>

		<?php $array = get_term_by('id', $locid, $taxonomy, 'ARRAY_A'); ?>
		<?php print_r($array[name]); ?>

	</td>
	<?php
 foreach ($array_sub as $subjectid) { ?>
	<td>
<?php	$args = array(
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

		<div class="eh-cell <?php echo $style; ?>" id="<?php echo 'loc' . $locid . 'sub' . $subjectid; ?>">
			<?php the_content(); ?>
		</div>

		<?php } //while
		wp_reset_postdata();
	 } else { ?>
		<div class="eh-cell">
			No posts ( <?php echo ' loc: ' . $locid . ' subject: ' . $subjectid; ?>)
		</div>
<?php	} //if ?>
  </td>
 <?php } //feach array sub ?>
</tr>
<?php } //feach array loc ?>
</tbody>
</table>





<hr>
Static
<hr>






<table>
<tr>
	<td>
		<div id="test">
		HOVER <br> OVER
		</div>
	</td>
	<td class="ehda_th">Plug&Play onto other platforms/ecosystems</td>
	<td class="ehda_th">Big data</td>
	<td class="ehda_th">Hacking the value chain</td>
	<td class="ehda_th">Monetizing EH assets with a new value proposition</td>
</tr>
<tr>
	<td class="ehda_th">NEUR</td>
	<td id="11">AA</td>
	<td>AB</td>
	<td>AC</td>
	<td>AC</td>
</tr>
<tr>
	<td class="ehda_th">DACH</td>
	<td>BA</td>
	<td>BB</td>
	<td>BC</td>
	<td>AC</td>
</tr>
<tr>
	<td class="ehda_th">FR</td>
	<td>CA</td>
	<td>CB</td>
	<td>CC</td>
	<td>AC</td>
</tr>
<tr>
	<td class="ehda_th">AMER</td>
	<td>$query = new WP_Query( 'category_name=amer+plug' );</td>
	<td>



		<?php
		$args = array(
			'post_type' => 'ehproject',
			'tax_query' => array(
			'relation' => 'AND',
				array(
					'taxonomy' => 'ehproject_cat',
					'field'    => 'slug',
					'terms'    => 'amer',
				),
				array(
					'taxonomy' => 'ehproject_cat',
					'field'    => 'slug',
					'terms'    => 'bigdata',
				),
			),
		);
		$query = new WP_Query( $args );
		while ( $query->have_posts() ) {
			$query->the_post(); ?>

			<?php
			$t=get_the_title();
			if ( strpos( $t,'[active]' )===FALSE ) $style="past";
			else $style="ongoing";
			?>

			<div class="eh-cell <?php echo $style; ?>">
				<?php the_content(); ?>
			</div>

			<?php }
			wp_reset_postdata(); ?>



	</td>
	<td>$query = new WP_Query( 'category_name=amer+chain' );</td>
	<td>$query = new WP_Query( 'category_name=amer+assets' );</td>
</tr>
<tr>
	<td class="ehda_th">MMEA</td>
	<td>CA</td>
	<td>CB</td>
	<td>CC</td>
	<td>AC</td>
</tr>
<tr>
	<td class="ehda_th">APAC</td>
	<td>CA</td>
	<td>CB</td>
	<td>CC</td>
	<td>AC</td>
</tr>
<tr>
	<td class="ehda_th">WA</td>
	<td>CA</td>
	<td>CB</td>
	<td>CC</td>
	<td>AC</td>
</tr>
<tr>
	<td class="ehda_th">RIC</td>
	<td>CA</td>
	<td>CB</td>
	<td>CC</td>
	<td>AC</td>
</tr>
<tr>
	<td class="ehda_th">Other (incl. MMCD)</td>
	<td>CA</td>
	<td>CB</td>
	<td>CC</td>
	<td>AC</td>
</tr>
</table>

<?php get_template_part( 'loop', 'page' ); ?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
