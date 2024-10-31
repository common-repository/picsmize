<?php
$imageDetails = PicsmizeCommon::getSinglePost();
$isAutoAltChange = get_option('Pics_autoALT');
if(!$isAutoAltChange) $isAutoAltChange = 0;
$rules = PicsALTRules();
$isSetup = 0;
if(!empty($rules)) $isSetup = 1;

$tagArray = [];
foreach ($rules as  $value) {
	$tagArray[] = $value['value'];
}

$propertyKeys = array('post_title' => 'Post Title','slug' => 'Slug','post_id' => 'ID','category' => 'First Category Name','excerpt' => 'Post excerpt','author' =>'Author','product_title' => 'Product Title','sku' => 'Product SKU','variant_title' => 'Variant Title');
$isFileRename = true;
?>

<div class="Polaris-Page">
	<div class="Polaris-Page__Content">
		<div class="Polaris-Layout">
			<div class="Polaris-Layout__AnnotatedSection">
				<div class="Polaris-Layout__AnnotationWrapper">
					<div class="Polaris-Layout__Annotation">
						<div class="Polaris-TextContainer">
							<h2 class="Polaris-Heading"><?php _e('Product properties','Picsmize') ?></h2>
							<div class="Polaris-Layout__AnnotationDescription">
								<p>Select the product property according to the new alt tag of image as you want to change.</p>
							</div>
						</div>
					</div>
					<div class="Polaris-Layout__AnnotationContent" id="Property-Section">
						<div class="Polaris-Card">
							<div class="Polaris-Card__Section">
								<div class="Polaris-ButtonGroup">
									<?php
									foreach ($propertyKeys as $key => $title) {
										if(!in_array($key, $tagArray)) {?>
											<div class="Polaris-ButtonGroup__Item">
												<button class="Polaris-Button Polaris-Button--outline Polaris-Button--textAlignRight Polaris-Button--fullWidth Property-Button" type="button" front-title="<?php echo esc_attr($title);?>" title="<?php echo esc_attr($title);?>" value="<?php echo esc_attr($key);?>">
													<span class="Polaris-Button__Icon"><div class=""><span class="Polaris-Icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M17 9h-6V3a1 1 0 00-2 0v6H3a1 1 0 000 2h6v6a1 1 0 102 0v-6h6a1 1 0 000-2z" fill="#5C5F62"/></svg></span></div></span><span class="Polaris-Button__Content"><span class="Polaris-Button__Text"><?php echo esc_attr($title);?></span></span>
												</button>
											</div>
										<?php } 
									} ?>
									
								</div>
								<div class="Polaris-Stack" style="padding-top: 0.8rem"> 
									<div class="Polaris-Stack__Item" id="custom-property">
										<span class="Polaris-Badge"><?php _e('Add Custom','Picsmize') ?></span>
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
							<h2 class="Polaris-Heading"><?php _e('Added Product Properties','Picsmize') ?></h2>
							<div class="Polaris-Layout__AnnotationDescription">
								<p>The ALT tag of the image will be based on the given information.</p>
							</div>
						</div>
					</div>
					<div class="Polaris-Layout__AnnotationContent" id="Added-Property-Section">
						<div class="Polaris-Card">
							<div class="Polaris-Card__Section">
								<div class="Polaris-ButtonGroup" id="draggable"> 
									<?php if(count($rules) > 0 && !empty($rules)) {
										foreach ($rules as $value) { ?>
											<div class="Polaris-ButtonGroup__Item">
												<div style="color: var(--p-action-primary);">
													<button front-title='<?php echo esc_attr($value['type'] == 'custom' ? $value['value'] : $value['title'])?>' title='<?php echo esc_attr($value['type'] == 'custom' ? $value['value'] : picsmizeLang(str_replace(' ', '_', $value['title']))); ?>' value='<?php echo esc_attr($value['value']); ?>' class="Polaris-Button Polaris-Button--outline Polaris-Button--monochrome Added-Property-Button <?php echo esc_attr($value['type'] == 'custom' ? 'customTag' : ''); ?>" type="button">
														<span class="Polaris-Button__Icon">
															<div class="button-action">
																<span class="Polaris-Icon remove <?php echo esc_attr($value['type'] == 'custom' ? 'custom' : ''); ?>"><svg class="minus" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M11.414 10l4.293-4.293a.999.999 0 10-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 10-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 101.414 1.414L10 11.414l4.293 4.293a.997.997 0 001.414 0 .999.999 0 000-1.414L11.414 10z" fill="rgb(0, 128, 96)"/></svg>
																</span>
																<span class="Polaris-Icon drag"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 4c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
																</span>
																<span class="Polaris-Icon check"><svg class="plus" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7 18a.997.997 0 01-.707-.293l-6-6a1 1 0 011.414-1.414l5.236 5.236 11.298-13.18a1 1 0 011.518 1.3l-12 14a1.001 1.001 0 01-.721.35H7" fill="rgb(0, 128, 96)"/></svg>
																</span>
															</div>
														</span>
														<span class="Polaris-Button__Content">
															<?php if($value['type'] != 'custom'){ ?>
																<span class="Polaris-Button__Text"><?php _e(str_replace(' ', '_', $value['title']),'Picsmize') ?></span>
															<?php }else{ ?>
																<span class="Polaris-Button__Text"><?php echo esc_html($value['value']); ?></span>
															<?php } ?>
														</span>
													</button>
												</div>
											</div>
										<?php	}
									}else{ ?>
										<div class="Polaris-Card__Header">
											<h2 class="Polaris-Heading">No property added. Choose any product property from above section</h2>
										</div>
									<?php } ?>

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
							<h2 class="Polaris-Heading"><?php _e('Auto ALT Change Mode','Picsmize') ?></h2>
							<div class="Polaris-Layout__AnnotationDescription">
								<p>This option will check for new image and will add ALT text automatically as per settings.</p>
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
					  							<input name="alt_mode" id="automatic"  type="checkbox" class="Polaris-Checkbox__Input" aria-invalid="false" role="checkbox" aria-checked="false" value="1" <?php echo esc_html($isAutoAltChange == '1' ? 'checked' : ''); ?>>
					  							<span class="Polaris-Checkbox__Backdrop"></span>
					  							<span class="Polaris-Checkbox__Icon">
					  								<span class="Polaris-Icon">
					  									<span class="Polaris-VisuallyHidden"></span>
					  									<svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path d="m8.315 13.859-3.182-3.417a.506.506 0 0 1 0-.684l.643-.683a.437.437 0 0 1 .642 0l2.22 2.393 4.942-5.327a.436.436 0 0 1 .643 0l.643.684a.504.504 0 0 1 0 .683l-5.91 6.35a.437.437 0 0 1-.642 0"></path></svg></span></span></span></span>
					  									<span class="Polaris-Choice__Label">Change ALT text for all new images automatically.</span></label>
									<div id="PolarisPortalsContainer"></div>
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
							<h2 class="Polaris-Heading"><?php _e('Preview for new ALT tag','Picsmize') ?></h2>
						</div>
					</div>
					<div class="Polaris-Layout__AnnotationContent">
						<div class="Polaris-Card" style="position: relative;">
							<div class="Polaris-Spinner__Container" id="preview-loader">
								<div class="Polaris-Spinner__Content">
									<span class="Polaris-Spinner Polaris-Spinner--colorTeal Polaris-Spinner--sizeLarge">
										<svg viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg">
											<path d="M15.542 1.487A21.507 21.507 0 00.5 22c0 11.874 9.626 21.5 21.5 21.5 9.847 0 18.364-6.675 20.809-16.072a1.5 1.5 0 00-2.904-.756C37.803 34.755 30.473 40.5 22 40.5 11.783 40.5 3.5 32.217 3.5 22c0-8.137 5.3-15.247 12.942-17.65a1.5 1.5 0 10-.9-2.863z"></path>
										</svg>
									</span>
								</div>
							</div>
							<?php if(!empty($imageDetails)){ ?>
							<div class="Polaris-Card__Section">
								<div class="Polaris-Card__SectionHeader">
									<h3 aria-label="Reports" class="Polaris-Subheading"><?php _e('Post Title','Picsmize') ?> : </h3>
								</div>
								<p id="Product-Title"><?php echo esc_html($imageDetails['post_title']); ?></p>
							</div>
							<div class="Polaris-Card__Section">
								<div class="Polaris-Card__SectionHeader">
									<h3 aria-label="Summary" class="Polaris-Subheading">NEW ALT TAG OF IMAGE WILL LOOK LIKE THIS :</h3>
								</div>
								<p id="New-Image-Name" class=""></p>
							</div>
							<div class="Polaris-Card__Section">
								<div class="Polaris-Card__SectionHeader">
									<h3 aria-label="Summary" class="Polaris-Subheading">CURRENT ALT TAG OF THE IMAGE :</h3>
								</div>
								<p id="Image-Name"><?php echo esc_html($imageDetails['image_name']); ?></p>
							</div>
							<div class="Polaris-Card__Footer" style="justify-content: center;">
								<div class="Polaris-ButtonGroup Polaris-ButtonGroup--segmented">
									<div class="Polaris-ButtonGroup__Item">
										<button id="previousBtn" class="Polaris-Button Polaris-Button--outline Polaris-Button--disabled Polaris-Button--iconOnly" type="button" disabled>
											<span class="Polaris-Button__Content">
												<span class="Polaris-Button__Icon">
													<span class="Polaris-Icon">
														<svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path d="M12 16a.997.997 0 0 1-.707-.293l-5-5a.999.999 0 0 1 0-1.414l5-5a.999.999 0 1 1 1.414 1.414L8.414 10l4.293 4.293A.999.999 0 0 1 12 16z"></path>
														</svg>
													</span>
												</span>
											</span>
										</button>
									</div>
									<div class="Polaris-ButtonGroup__Item">
										<button id="nextBtn" data-token='1' class="Polaris-Button Polaris-Button--outline Polaris-Button--iconOnly" type="button">
											<span class="Polaris-Button__Content">
												<span class="Polaris-Button__Icon">
													<span class="Polaris-Icon">
														<svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path d="M8 16a.999.999 0 0 1-.707-1.707L11.586 10 7.293 5.707a.999.999 0 1 1 1.414-1.414l5 5a.999.999 0 0 1 0 1.414l-5 5A.997.997 0 0 1 8 16z"></path>
														</svg>
													</span>
												</span>
											</span>
										</button>
									</div>
								</div>
							</div>
							<?php }else{ ?>
								<div class="Polaris-Card__Section">
									<div class="Polaris-Card__SectionHeader">
										<h3 aria-label="Reports" class="Polaris-Subheading">Add one post to see preview.</h3>
									</div>
									
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	<div class="Polaris-PageActions">
		<div class="Polaris-Stack Polaris-Stack--spacingTight Polaris-Stack--distributionTrailing">
			
			<div class="Polaris-Stack__Item">
				<button class="Polaris-Button Polaris-Button--primary" type="button" id="alt-settings-save">
					<span class="Polaris-Button__Content">
						<span class="Polaris-Button__Text"><?php _e('Save','Picsmize') ?></span>
					</span>
				</button>
			</div>
		</div>
	</div>
</div>

<div class="Polaris-Modal-Dialog__Container Custom-Tag-Modal" style="display: none;">
	<div class="Polaris-Modal-Dialog__Modal">
		<div class="Polaris-Modal-Header">
			<div class="Polaris-Modal-Header__Title">
				<h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall"><?php _e('Add Custom','Picsmize') ?></h2>
			</div>
			<button class="Polaris-Modal-CloseButton" aria-label="Close">
				<span class="Polaris-Icon Polaris-Icon--colorBase"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path d="M11.414 10l6.293-6.293a1 1 0 1 0-1.414-1.414L10 8.586 3.707 2.293a1 1 0 0 0-1.414 1.414L8.586 10l-6.293 6.293a1 1 0 1 0 1.414 1.414L10 11.414l6.293 6.293A.998.998 0 0 0 18 17a.999.999 0 0 0-.293-.707L11.414 10z"></path></svg></span>
			</button>
		</div>
		<div class="Polaris-Modal__BodyWrapper">
			<div class="Polaris-Modal__Body">
				<section class="Polaris-Modal-Section">
					<div class="Polaris-Stack Polaris-Stack--vertical">
						<div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
							<div class="Polaris-Connected">
								<div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
									<div class="Polaris-TextField Polaris-TextField--hasValue"><input class="Polaris-TextField__Input" id="custom-property-input" maxlength="30">
										<div class="Polaris-TextField__CharacterCount">0/30</div>
										<div class="Polaris-TextField__Backdrop"></div>
									</div>
								</div>
							</div>
							<div class="Polaris-Labelled__HelpText">Only alphanumeric, hyphen and underscore are allowed</div>
						</div>
					</div>
				</section>
			</div>
		</div>
		<div class="Polaris-Modal-Footer">
			<div class="Polaris-Modal-Footer__FooterContent">
				<div class="Polaris-Stack Polaris-Stack--alignmentCenter">
					<div class="Polaris-Stack__Item Polaris-Stack__Item--fill"></div>
					<div class="Polaris-Stack__Item">
						<div class="Polaris-ButtonGroup">
							<div class="Polaris-ButtonGroup__Item">
								<button id="add-custom" class="Polaris-Button Polaris-Button--primary" type="button">
									<span class="Polaris-Button__Content">
										<span class="Polaris-Button__Text"><?php _e('Add','Picsmize') ?></span>
									</span>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
var PicsAjax = '<?php echo admin_url('admin-ajax.php'); ?>';
var imageDetails = JSON.parse('<?php echo json_encode($imageDetails) ?>');
var propertyTags = JSON.parse('<?php echo json_encode($rules) ?>');
var isSetup = '<?php echo esc_attr($isSetup) ?>';
var NoPropertyDescription = 'No property added. Choose any post property from above section';
var AtleastOnePro = 'Please select any post property to see image name preview';
var AtleastOneProMsg = 'Please add atleast one post property';
</script>