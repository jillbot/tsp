<?php
global $mkd_options;

//init variables
$uncovering_footer					= false;
$footer_classes_array				= array();
$footer_classes						= '';
$footer_border_columns				= 'yes';
$footer_top_border_color            = '';
$footer_top_border_in_grid          = '';
$footer_bottom_border_color         = '';
$footer_bottom_border_bottom_color  = '';
$footer_bottom_border_in_grid       = '';

extract(mkd_get_footer_variables());

?>

<?php get_template_part('content-bottom-area'); ?>

    </div> <!-- close div.content_inner -->
</div>  <!-- close div.content -->

<?php
if(isset($mkd_options['paspartu']) && $mkd_options['paspartu'] == 'yes'){?>
        <?php if(isset($mkd_options['vertical_area']) && $mkd_options['vertical_area'] =='yes' && isset($mkd_options['vertical_menu_inside_paspartu']) && $mkd_options['vertical_menu_inside_paspartu'] == 'no') { ?>
			</div> <!-- paspartu_middle_inner close div -->
		<?php } ?>
		</div> <!-- paspartu_inner close div -->
    </div> <!-- paspartu_outer close div -->
<?php
}
?>

<?php get_template_part('social-sidebar'); ?>

<footer <?php mkd_class_attribute($footer_classes); ?>>
	<div class="footer_inner clearfix">
		<?php
		$footer_in_grid = true;
		if(isset($mkd_options['footer_in_grid'])){
			if ($mkd_options['footer_in_grid'] != "yes") {
				$footer_in_grid = false;
			}
		}
		$display_footer_top = true;
		if (isset($mkd_options['show_footer_top'])) {
			if ($mkd_options['show_footer_top'] == "no") $display_footer_top = false;
		}

		$footer_top_columns = 4;
		if (isset($mkd_options['footer_top_columns'])) {
			$footer_top_columns = $mkd_options['footer_top_columns'];
		}

        $footer_bottom_columns = 3;
		if (isset($mkd_options['footer_bottom_columns'])) {
            $footer_bottom_columns = $mkd_options['footer_bottom_columns'];
		}

		if($display_footer_top) {
			if($footer_top_border_color != ''){ ?>
				<?php if($footer_top_border_in_grid != '') { ?>
					<div class="footer_ingrid_border_holder_outer">
				<?php } ?>
						<div class="footer_top_border_holder <?php echo esc_attr($footer_top_border_in_grid); ?>" <?php mkd_inline_style($footer_top_border_color); ?>></div>
				<?php if($footer_top_border_in_grid != '') { ?>
					</div>
				<?php } ?>
			<?php } ?>
			<div class="footer_top_holder">
				<div class="footer_top<?php if(!$footer_in_grid) {echo " footer_top_full";} ?>">
					<?php if($footer_in_grid){ ?>
					<div class="container">
						<div class="container_inner">
							<?php } ?>
							<?php switch ($footer_top_columns) {
								case 6:
									?>
									<div class="two_columns_50_50 clearfix">
										<div class="mkd_column column1">
											<div class="column_inner">
												<?php dynamic_sidebar( 'footer_column_1' ); ?>
											</div>
										</div>
										<div class="mkd_column column2">
											<div class="column_inner">
												<div class="two_columns_50_50 clearfix">
													<div class="mkd_column column1">
														<div class="column_inner">
															<?php dynamic_sidebar( 'footer_column_2' ); ?>
														</div>
													</div>
													<div class="mkd_column column2">
														<div class="column_inner">
															<?php dynamic_sidebar( 'footer_column_3' ); ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php
									break;
								case 5:
									?>
									<div class="two_columns_50_50 clearfix">
										<div class="mkd_column column1">
											<div class="column_inner">
												<div class="two_columns_50_50 clearfix">
													<div class="mkd_column column1">
														<div class="column_inner">
															<?php dynamic_sidebar( 'footer_column_1' ); ?>
														</div>
													</div>
													<div class="mkd_column column2">
														<div class="column_inner">
															<?php dynamic_sidebar( 'footer_column_2' ); ?>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="mkd_column column2">
											<div class="column_inner">
												<?php dynamic_sidebar( 'footer_column_3' ); ?>
											</div>
										</div>
									</div>
									<?php
									break;
								case 4:
									?>
									<div class="four_columns clearfix">
										<div class="mkd_column column1">
											<div class="column_inner">
												<?php dynamic_sidebar( 'footer_column_1' ); ?>
											</div>
										</div>
										<div class="mkd_column column2">
											<div class="column_inner">
												<?php dynamic_sidebar( 'footer_column_2' ); ?>
											</div>
										</div>
										<div class="mkd_column column3">
											<div class="column_inner">
												<?php dynamic_sidebar( 'footer_column_3' ); ?>
											</div>
										</div>
										<div class="mkd_column column4">
											<div class="column_inner">
												<?php dynamic_sidebar( 'footer_column_4' ); ?>
											</div>
										</div>
									</div>
									<?php
									break;
								case 3:
									?>
									<div class="three_columns clearfix">
										<div class="mkd_column column1">
											<div class="column_inner">
												<?php dynamic_sidebar( 'footer_column_1' ); ?>
											</div>
										</div>
										<div class="mkd_column column2">
											<div class="column_inner">
												<?php dynamic_sidebar( 'footer_column_2' ); ?>
											</div>
										</div>
										<div class="mkd_column column3">
											<div class="column_inner">
												<?php dynamic_sidebar( 'footer_column_3' ); ?>
											</div>
										</div>
									</div>
									<?php
									break;
								case 2:
									?>
									<div class="two_columns_50_50 clearfix">
										<div class="mkd_column column1">
											<div class="column_inner">
												<?php dynamic_sidebar( 'footer_column_1' ); ?>
											</div>
										</div>
										<div class="mkd_column column2">
											<div class="column_inner">
												<?php dynamic_sidebar( 'footer_column_2' ); ?>
											</div>
										</div>
									</div>
									<?php
									break;
								case 1:
									dynamic_sidebar( 'footer_column_1' );
									break;
							}
							?>
							<?php if($footer_in_grid){ ?>
						</div>
					</div>
				<?php } ?>
				</div>
			</div>
		<?php } ?>
		<?php
		$display_footer_text = false;
		if (isset($mkd_options['footer_text'])) {
			if ($mkd_options['footer_text'] == "yes") $display_footer_text = true;
		}
		if($display_footer_text): ?>
            <?php if($footer_bottom_border_color != ''){ ?>
				<?php if($footer_bottom_border_in_grid != '') { ?>
					<div class="footer_ingrid_border_holder_outer">
				<?php } ?>
                		<div class="footer_bottom_border_holder <?php echo esc_attr($footer_bottom_border_in_grid); ?>" <?php mkd_inline_style($footer_bottom_border_color); ?>></div>
				<?php if($footer_bottom_border_in_grid != '') { ?>
					</div>
				<?php } ?>
            <?php } ?>
			<div class="footer_bottom_holder">
                <div class="footer_bottom_holder_inner">
                    <?php if($footer_in_grid){ ?>
                    <div class="container">
                        <div class="container_inner">
                            <?php } ?>

                            <?php switch ($footer_bottom_columns) {
                                case 3:
                                    ?>
                                    <div class="three_columns clearfix">
                                        <div class="mkd_column column1">
                                            <div class="column_inner">
                                                <?php dynamic_sidebar( 'footer_bottom_left' ); ?>
                                            </div>
                                        </div>
                                        <div class="mkd_column column2">
                                            <div class="column_inner">
                                                <?php dynamic_sidebar( 'footer_text' ); ?>
                                            </div>
                                        </div>
                                        <div class="mkd_column column3">
                                            <div class="column_inner">
                                                <?php dynamic_sidebar( 'footer_bottom_right' ); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    break;
                                case 2:
                                    ?>
                                    <div class="two_columns_50_50 clearfix">
                                        <div class="mkd_column column1">
                                            <div class="column_inner">
                                                <?php dynamic_sidebar( 'footer_bottom_left' ); ?>
                                            </div>
                                        </div>
                                        <div class="mkd_column column2">
                                            <div class="column_inner">
                                                <?php dynamic_sidebar( 'footer_bottom_right' ); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    break;
                                case 1:
                                    ?>
                                    <div class="column_inner">
                                        <?php dynamic_sidebar( 'footer_text' ); ?>
                                    </div>
                                    <?php
                                    break;
                            }
                            ?>
                            <?php if($footer_in_grid){ ?>
                        </div>
                    </div>
                <?php } ?>
                </div>
			</div>
            <?php if($footer_bottom_border_bottom_color != ''){ ?>
				<div class="footer_bottom_border_bottom_holder <?php echo esc_attr($footer_top_border_in_grid); ?>" <?php mkd_inline_style($footer_bottom_border_bottom_color); ?>></div>
			<?php } ?>
		<?php endif; ?>


	</div>
</footer>
</div> <!-- close div.wrapper_inner  -->
</div> <!-- close div.wrapper -->
<?php wp_footer(); ?>

<!-- Quantcast Tag -->
<script type="text/javascript">
var _qevents = _qevents || [];

(function() {
var elem = document.createElement('script');
elem.src = (document.location.protocol == "https:" ? "https://secure" : "http://edge") + ".quantserve.com/quant.js";
elem.async = true;
elem.type = "text/javascript";
var scpt = document.getElementsByTagName('script')[0];
scpt.parentNode.insertBefore(elem, scpt);
})();

_qevents.push({
qacct:"p-fzSrutFNTn8sC"
});
</script>

<noscript>
<div style="display:none;">
<img src="//pixel.quantserve.com/pixel/p-fzSrutFNTn8sC.gif" border="0" height="1" width="1" alt="Quantcast"/>
</div>
</noscript>
<!-- End Quantcast tag -->
</body>
</html>