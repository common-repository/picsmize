<?php
$compressionType = picsCompressStyle();
$isAutoCompress = get_option('Pics_autoCompress');
if(!$isAutoCompress) $isAutoCompress = 0;
$compressionMode = 2;
?>
<div class="Polaris-Page">
	<div class="Polaris-Page__Content">
		<div class="Polaris-Layout">
			<div class="Polaris-Layout__AnnotatedSection">
				<div class="Polaris-Layout__AnnotationWrapper">
					<div class="Polaris-Layout__Annotation">
						<div class="Polaris-TextContainer">
							<h2 class="Polaris-Heading"><?php _e('Compression','Picsmize') ?></h2>
							<div class="Polaris-Layout__AnnotationDescription">
								<p>Select Default compression settings. All new images will be compressed with selected compression.</p>
							</div>
						</div>
					</div>
					<div class="Polaris-Layout__AnnotationContent">
						<div class="Polaris-Card">
							<div class="Polaris-Card__Section">
								<div class="Polaris-Layout">
									<div class="Polaris-Layout__Section polaris-radio-box Polaris-Layout__Section--oneThird">
										<div class="Polaris-Card">
											<input value="1" type="radio" name="compression_type" id="cmp-radio-1" <?php echo ($compressionType == '1') ? 'checked' : '' ?> >
											<label for="cmp-radio-1">
												<span class="chckbx-icon"></span>
												<h6 class="Polaris-Heading"><?php _e('Lossless','Picsmize') ?></h6>
											</label>
										</div>
									</div>
									<div class="Polaris-Layout__Section polaris-radio-box Polaris-Layout__Section--oneThird">
										<div class="Polaris-Card">
											<input value="2" type="radio" name="compression_type" id="cmp-radio-2" <?php echo $compressionType == '2' ? 'checked' : '' ?>>
											<label for="cmp-radio-2">
												<span class="chckbx-icon"></span>
												<h6 class="Polaris-Heading"><?php _e('Balanced','Picsmize') ?></h6>
											</label>
										</div>
									</div>

									<div class="Polaris-Layout__Section polaris-radio-box Polaris-Layout__Section--oneThird">
										<div class="Polaris-Card">
											<input value="3" type="radio" name="compression_type" id="cmp-radio-3" <?php echo $compressionType == '3' ? 'checked' : '' ?>>
											<label for="cmp-radio-3">
												<span class="chckbx-icon"></span>
												<h6 class="Polaris-Heading"><?php _e('Lossy','Picsmize') ?></h6>
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="Polaris-Layout__AnnotatedSection">
				<div class="Polaris-Layout__AnnotationWrapper">
					<div class="Polaris-Layout__Annotation">
						<div class="Polaris-TextContainer">
							<h2 class="Polaris-Heading"><?php _e('Auto Compression Mode','Picsmize') ?></h2>
							<div class="Polaris-Layout__AnnotationDescription">
								<p>This option will check for new image and will compress it automatically.</p>
							</div>
				      	</div>
				  	</div>

				  	<div class="Polaris-Layout__AnnotationContent">
					  	<div class="Polaris-Card">
					  		<div class="Polaris-Card__Section">
					  			<div>
					  				<label class="Polaris-Choice" for="automatic">
					  					<span class="Polaris-Choice__Control">
					  						<span class="Polaris-Checkbox">
					  							<input name="compression_mode" id="automatic"  type="checkbox" class="Polaris-Checkbox__Input" aria-invalid="false" role="checkbox" aria-checked="false" value="1" <?php echo esc_attr($isAutoCompress == '1' ? 'checked' : '') ?>>
					  							<span class="Polaris-Checkbox__Backdrop"></span>
					  							<span class="Polaris-Checkbox__Icon">
					  								<span class="Polaris-Icon">
					  									<span class="Polaris-VisuallyHidden"></span>
					  									<svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path d="m8.315 13.859-3.182-3.417a.506.506 0 0 1 0-.684l.643-.683a.437.437 0 0 1 .642 0l2.22 2.393 4.942-5.327a.436.436 0 0 1 .643 0l.643.684a.504.504 0 0 1 0 .683l-5.91 6.35a.437.437 0 0 1-.642 0"></path></svg></span></span></span></span>
					  									<span class="Polaris-Choice__Label">Compress all new image automatically.</span></label>
									<div id="PolarisPortalsContainer"></div>
								</div>
					  		</div>
					  	</div>
				  	</div>
				</div>
			</div>
			<div class="Polaris-Layout__AnnotatedSection">
				<div class="Polaris-Stack Polaris-Stack--spacingTight Polaris-Stack--distributionTrailing">
					<div class="Polaris-Stack__Item">
						<button class="Polaris-Button Polaris-Button--primary" type="button" id="settings-save" jpeg='<?php echo esc_attr($jpegQuality) ?>' png='<?php echo esc_attr($pngQuality) ?>' gif='<?php echo esc_attr($gifQuality) ?>'><span class="Polaris-Button__Content"><span class="Polaris-Button__Text"><?php _e('Save','Picsmize') ?></span></span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var PicsAjax = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>