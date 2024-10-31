<?php
$postStatus = get_post_statuses(); 
$picsAnalytics = PicsImageFuntion::picsAnalytics();

?>
<div class="Polaris-Page"> 

	<div class="Polaris-Page__Content">
		<div class="Polaris-Layout i1mg-info-blocks">
			<div class="Polaris-Layout__Section Polaris-Layout__Section--fullWidth">
				<p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">
					<span class="Polaris-TextStyle--variationStrong"><?php _e('Dashboard','Picsmize') ?></span>
				</p>
			</div>
			<div class="Polaris-Layout__Section Polaris-Layout__Section--oneFourth">
				<div class="Polaris-Card">
					<div class="Polaris-Card__Header">
						<h2 class="Polaris-Heading"><?php _e('Product','Picsmize') ?></h2>
					</div>
					<div class="Polaris-Card__Section">
						<ul>
							<li class="Polaris-Small-Label"><?php _e('Total','Picsmize') ?> <span id="total_product"><?php echo esc_html($picsAnalytics['products']);?></span></li>
							<li class="Polaris-Small-Label"><?php _e('Compress','Picsmize') ?> <span id="product_optimize"><?php echo esc_html($picsAnalytics['productCompressed']);?></span></li>
							<li class="Polaris-Small-Label"><?php _e('Restore','Picsmize') ?> <span id="product_restore"><?php echo esc_html($picsAnalytics['productRestored']);?></span></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="Polaris-Layout__Section Polaris-Layout__Section--oneFourth">
				<div class="Polaris-Card">
					<div class="Polaris-Card__Header">
						<h2 class="Polaris-Heading"><?php _e('Assets','Picsmize') ?></h2>
					</div>
					<div class="Polaris-Card__Section">
						<ul>
							<li class="Polaris-Small-Label"><?php _e('Total','Picsmize') ?> <span id="total_asset"><?php echo esc_html($picsAnalytics['assets']);?></span></li>
							<li class="Polaris-Small-Label"><?php _e('Compress','Picsmize') ?> <span id="asset_optimize"><?php echo esc_html($picsAnalytics['assetsCompressed']);?></span></li>
							<li class="Polaris-Small-Label"><?php _e('Restore','Picsmize') ?> <span id="asset_restore"><?php echo esc_html($picsAnalytics['assetsRestored']);?></span></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="Polaris-Layout__Section Polaris-Layout__Section--oneHalf">
				<div class="Polaris-Layout i1mg-info-blocks">
					<div class="Polaris-Layout__Section Polaris-Layout__Section--oneFourth">
						<div class="Polaris-Card">
							<div class="Polaris-Card__Header polaris-tphead">
								<h2 class="Polaris-Heading"><?php _e('Image File Rename','Picsmize') ?></h2>
							</div>
							<div class="Polaris-Card__Section">
								<div class="rnm-img-block">
								    <div class="polaris-rslt-txt">
								        <div class="polaris-count-rslt">
								            <span id="total_filerename"><?php echo esc_html($picsAnalytics['renamed']);?></span>
								            /<span class="total_available_rename"><?php echo esc_html($picsAnalytics['total']);?></span>
								        </div>
								        <h4>FILE RENAME</h4>
								    </div>
								</div>
							</div>
						</div>
					</div>
					<div class="Polaris-Layout__Section Polaris-Layout__Section--oneFourth">
						<div class="Polaris-Card">
							<div class="Polaris-Card__Header polaris-tphead">
								<h2 class="Polaris-Heading"><?php _e('Image Alt Tag Change','Picsmize') ?></h2>
							</div>
							<div class="Polaris-Card__Section">
								<div class="rnm-img-block">
								    <div class="polaris-rslt-txt">
								        <div class="polaris-count-rslt">
								            <span id="total_altrename"><?php echo esc_html($picsAnalytics['altChanged']);?></span> 
								            /<span class="total_available_rename"><?php echo esc_html($picsAnalytics['total']);?></span>
								        </div>
								        <h4><?php _e('ALT TAGS CHANGE','Picsmize') ?></h4>
								    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="Polaris-Layout">
		    <div class="Polaris-Layout__Section">
		        <div class="Polaris-Card">
		            <div class="Polaris-ResourceList__ResourceListWrapper">
		                <div class="Polaris-ResourceList__FiltersWrapper">
		                    <div class="Polaris-Filters">
		                        <div class="Polaris-Filters-ConnectedFilterControl__Wrapper">
		                            <div class="Polaris-Filters-ConnectedFilterControl Polaris-Filters-ConnectedFilterControl--right">
		                                <div class="Polaris-Filters-ConnectedFilterControl__CenterContainer">
		                                    <div class="Polaris-Filters-ConnectedFilterControl__Item">
		                                        <div class="Polaris-Labelled--hidden">
		                                            <div class="Polaris-Connected">
		                                                <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
		                                                    <div class="Polaris-TextField">
		                                                        <div class="Polaris-TextField__Prefix">
		                                                            <span class="Polaris-Filters__SearchIcon">
		                                                                <span class="Polaris-Icon">
		                                                                    <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg">
		                                                                        <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8m9.707 4.293l-4.82-4.82A5.968 5.968 0 0 0 14 8 6 6 0 0 0 2 8a6 6 0 0 0 6 6 5.968 5.968 0 0 0 3.473-1.113l4.82 4.82a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414" fill-rule="evenodd"></path>
		                                                                    </svg>
		                                                                </span>
		                                                            </span>
		                                                        </div>
		                                                        <input placeholder="Search by file name" class="Polaris-TextField__Input Polaris-TextField__Input--hasClearButton" id="search-image">
		                                                        <div class="Polaris-TextField__Backdrop"></div>
		                                                    </div>
		                                                </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                </div>
		                                <div class="Polaris-Filters-ConnectedFilterControl__MoreFiltersButtonContainer">
		                                    <div class="Polaris-Filters-ConnectedFilterControl__Item">
		                                        <div class="Polaris-Select">
		                                            <select id="image-content" class="Polaris-Select__Input" aria-invalid="false">
		                                                <option value=""><?php _e('All Images','Picsmize') ?></option>
		                                                <option value="product"><?php _e('Product Images','Picsmize') ?></option>
		                                                <option value="post"><?php _e('Asset Images','Picsmize') ?></option>
		                                            </select>
		                                            <div class="Polaris-Select__Content">
		                                                <span class="Polaris-Select__SelectedOption"><?php _e('All Images','Picsmize') ?></span>
		                                                <span class="Polaris-Select__Icon">
		                                                    <span class="Polaris-Icon">
		                                                        <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false">
		                                                            <path d="M10 16l-4-4h8l-4 4zm0-12l4 4H6l4-4z"></path>
		                                                        </svg>
		                                                    </span>
		                                                </span>
		                                            </div>
		                                            <div class="Polaris-Select__Backdrop"></div>
		                                        </div>
		                                    </div>
		                                </div>
		                                <?php if(!empty($postStatus)){ ?>
		                                <div class="Polaris-Filters-ConnectedFilterControl__MoreFiltersButtonContainer">
		                                    <div class="Polaris-Filters-ConnectedFilterControl__Item">
		                                        <div class="Polaris-Select">
		                                            <select id="image-status" class="Polaris-Select__Input" aria-invalid="false">
		                                                <option value=""><?php _e('All Status','Picsmize') ?></option>
		                                                <?php foreach ($postStatus as $key => $value) { ?>
		                                                <option value="<?php echo esc_attr($key);?>"><?php echo esc_html($value);?></option>
		                                            	<?php } ?>
		                                                
		                                            </select>
		                                            <div class="Polaris-Select__Content">
		                                                <span class="Polaris-Select__SelectedOption"><?php _e('All Status','Picsmize') ?></span>
		                                                <span class="Polaris-Select__Icon">
		                                                    <span class="Polaris-Icon">
		                                                        <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false">
		                                                            <path d="M10 16l-4-4h8l-4 4zm0-12l4 4H6l4-4z"></path>
		                                                        </svg>
		                                                    </span>
		                                                </span>
		                                            </div>
		                                            <div class="Polaris-Select__Backdrop"></div>
		                                        </div>
		                                    </div>
		                                </div>
		                            	<?php } ?>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <div class="Polaris-Card__Section" style="position: relative;">
		                <div class="Polaris-Spinner__Container" id="listing-loader">
		                    <div class="Polaris-Spinner__Content">
		                        <span class="Polaris-Spinner Polaris-Spinner--sizeLarge">
		                            <svg viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg">
		                                <path d="M15.542 1.487A21.507 21.507 0 00.5 22c0 11.874 9.626 21.5 21.5 21.5 9.847 0 18.364-6.675 20.809-16.072a1.5 1.5 0 00-2.904-.756C37.803 34.755 30.473 40.5 22 40.5 11.783 40.5 3.5 32.217 3.5 22c0-8.137 5.3-15.247 12.942-17.65a1.5 1.5 0 10-.9-2.863z"></path>
		                            </svg>
		                        </span>
		                    </div>
		                </div>
		                <input id="csrf" type="hidden" data-name="ci_csrf_token" value="">  
		                <table id="image-listing" class="display dataTable no-footer" role="grid">
	                        <thead>
								<tr>
									<th><?php _e('Date','Picsmize') ?></th>
									<th></th>
									<th><?php _e('File name','Picsmize') ?></th>
									<th><?php _e('File Rename','Picsmize') ?></th>
									<th><?php _e('ALT Change','Picsmize') ?></th>
									<th><?php _e('Status','Picsmize') ?></th>
									<th><?php _e('Action','Picsmize') ?></th>
								</tr>
							</thead>
	                        <tbody>
	                        </tbody>
	                    </table>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
	<div class="Polaris-PositionedOverlay Polaris-Tooltip--measuring action-tooltip">
		<div class="Polaris-Popover" data-polaris-overlay="true">
			<div class="Polaris-Popover__FocusTracker" tabindex="0"></div>
			<div class="Polaris-Popover__Wrapper">
				<div id="Polarispopover10" tabindex="-1" class="Polaris-Popover__Content">
					<div class="Polaris-Popover__Pane Polaris-Scrollable Polaris-Scrollable--vertical" data-polaris-scrollable="true">
						<div class="Polaris-ActionList">
							<div class="Polaris-ActionList__Section--withoutTitle"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal-body-structure" style="display: none">
	<div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical">
		<section class="Polaris-Modal-Section">
			<div class="Polaris-Layout polaris-cst-block">
				<div class="Polaris-Layout__Section">
					<div class="Polaris-Card">
						<div class="Polaris-Card__Header">
							<h2 class="Polaris-Heading"><?php _e('Image type','Picsmize') ?></h2>
						</div>
						<div class="Polaris-Card__Section">
							<h6 class="filter_subscriber">{{IMAGE_TYPE}}</h6>
						</div>
					</div>
				</div>
				<div class="Polaris-Layout__Section">
					<div class="Polaris-Card">
						<div class="Polaris-Card__Header">
							<h2 class="Polaris-Heading"><?php _e('File type','Picsmize') ?></h2>
						</div>
						<div class="Polaris-Card__Section">
							<h6 class="filter_impression">{{FILE_TYPE}}</h6>
						</div>
					</div>
				</div>
				<div class="Polaris-Layout__Section">
					<div class="Polaris-Card">
						<div class="Polaris-Card__Header">
							<h2 class="Polaris-Heading"><?php _e('Original size','Picsmize') ?></h2>
						</div>
						<div class="Polaris-Card__Section">
							<h6 class="filter_click">{{ORIGINAL_SIZE}}</h6>
						</div>
					</div>
				</div>
				<div class="Polaris-Layout__Section">
					<div class="Polaris-Card">
						<div class="Polaris-Card__Header">
							<h2 class="Polaris-Heading"><?php _e('Crushed size','Picsmize') ?></h2>
						</div>
						<div class="Polaris-Card__Section">
							<h6>{{CRUSHED_SIZE}}</h6>
						</div>
					</div>
				</div>
				<div class="Polaris-Layout__Section">
					<div class="Polaris-Card">
						<div class="Polaris-Card__Header">
							<h2 class="Polaris-Heading"><?php _e('Saved','Picsmize') ?></h2>
						</div>
						<div class="Polaris-Card__Section">
							<h6>{{SAVED}}</h6>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="Polaris-Modal-Section image-desc-block">
			<div class="Polaris-Layout">
				<div class="polaris-file-alt Polaris-Layout__Section Polaris-Layout__Section--oneThird">
					<div class="Polaris-Card">
						<div class="Polaris-Card__Header">
							<h2 class="Polaris-Heading"><?php _e('File name','Picsmize') ?></h2>
						</div>
						<div class="Polaris-Card__Section">
							<div class="Polaris-Card__SectionHeader">
								<h3 aria-label="Items" class="Polaris-Subheading"><?php _e('Original file name','Picsmize') ?></h3>
							</div>
							<div class="Polaris-ResourceList__ResourceListWrapper toolTip">
								<ul class="Polaris-ResourceList" aria-live="polite">
									<li class="Polaris-ResourceItem__ListItem">
										<div class="Polaris-ResourceItem__ItemWrapper">
											<div class="Polaris-ResourceItem">
												<div class="Polaris-ResourceItem__Container">
													<div class="Polaris-ResourceItem__Content">
														<div class="img_prop">{{ORIGINAL_FILE_NAME}}</div>
													</div>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
						<div class="Polaris-Card__Section">
							<div class="Polaris-Card__SectionHeader">
								<h3 aria-label="Items" class="Polaris-Subheading"><?php _e('Optimised file name','Picsmize') ?></h3>
							</div>
							<div class="Polaris-ResourceList__ResourceListWrapper toolTip">
								<ul class="Polaris-ResourceList" aria-live="polite">
									<li class="Polaris-ResourceItem__ListItem">
										<div class="Polaris-ResourceItem__ItemWrapper">
											<div class="Polaris-ResourceItem">
												<div class="Polaris-ResourceItem__Container">
													<div class="Polaris-ResourceItem__Content">
														<div class="img_prop">{{OPTIMISED_FILE_NAME}}</div>
													</div>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="polaris-file-alt Polaris-Layout__Section Polaris-Layout__Section--oneThird">
					<div class="Polaris-Card">
						<div class="Polaris-Card__Header">
							<h2 class="Polaris-Heading"><?php _e('ALT Tag','Picsmize') ?></h2>
						</div>
						<div class="Polaris-Card__Section">
							<div class="Polaris-Card__SectionHeader">
								<h3 aria-label="Items" class="Polaris-Subheading"><?php _e('Original Alt tag','Picsmize') ?></h3>
							</div>
							<div class="Polaris-ResourceList__ResourceListWrapper toolTip">
								<ul class="Polaris-ResourceList" aria-live="polite">
									<li class="Polaris-ResourceItem__ListItem">
										<div class="Polaris-ResourceItem__ItemWrapper">
											<div class="Polaris-ResourceItem" data-href="produdcts/343">
												<a aria-describedby="343" aria-label="View details for Black &amp; orange scarf" class="Polaris-ResourceItem__Link" tabindex="0" id="PolarisResourceListItemOverlay7" href="produdcts/343" data-polaris-unstyled="true"></a>
												<div class="Polaris-ResourceItem__Container" id="343">
													<div class="Polaris-ResourceItem__Content">
														<div class="img_prop">{{ORIGINAL_ALT_TAG}}</div>
													</div>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
						<div class="Polaris-Card__Section">
							<div class="Polaris-Card__SectionHeader">
								<h3 aria-label="Items" class="Polaris-Subheading"><?php _e('Optimised alt tag','Picsmize') ?></h3>
							</div>
							<div class="Polaris-ResourceList__ResourceListWrapper toolTip">
								<ul class="Polaris-ResourceList" aria-live="polite">
									<li class="Polaris-ResourceItem__ListItem">
										<div class="Polaris-ResourceItem__ItemWrapper">
											<div class="Polaris-ResourceItem" data-href="produdcts/343">
												<a aria-describedby="343" aria-label="View details for Black &amp; orange scarf" class="Polaris-ResourceItem__Link" tabindex="0" id="PolarisResourceListItemOverlay7" href="produdcts/343" data-polaris-unstyled="true"></a>
												<div class="Polaris-ResourceItem__Container">
													<div class="Polaris-ResourceItem__Conte
													nt">
														<div class="img_prop">{{OPTIMISED_ALT_TAG}}</div>
													</div>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="Polaris-Layout__Section Polaris-Layout__Section--oneThird">
					<div class="Polaris-Card">
						<div class="Polaris-Card__Header">
							<h2 class="Polaris-Heading"><?php _e('History','Picsmize') ?></h2>	
						</div>
						<div class="Polaris-Card__Section">
							<div class="history-wrapper">
								<ul class="history">
									{{HISTORY}}
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section> 
	</div>
</div>

<div class="Polaris-Modal-Dialog__Container Polaris-Image-Modal">
	<div class="Polaris-Modal-Dialog__Modal Polaris-Modal-Dialog--sizeLarge">
		<div class="Polaris-Modal-Header">
			<div class="Polaris-Modal-Header__Title">
				<h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall"><?php _e('Image Details','Picsmize') ?></h2>
			</div>
			<button class="Polaris-Modal-CloseButton" aria-label="Close">
				<span class="Polaris-Icon Polaris-Icon--colorBase"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path d="M11.414 10l6.293-6.293a1 1 0 1 0-1.414-1.414L10 8.586 3.707 2.293a1 1 0 0 0-1.414 1.414L8.586 10l-6.293 6.293a1 1 0 1 0 1.414 1.414L10 11.414l6.293 6.293A.998.998 0 0 0 18 17a.999.999 0 0 0-.293-.707L11.414 10z"></path></svg></span>
			</button>
		</div>
		<div class="Polaris-Modal__BodyWrapper">
			<div class="Polaris-Spinner__Container Spinner_Show" id="model-loader">
				<div class="Polaris-Spinner__Content">
					<span class="Polaris-Spinner Polaris-Spinner--colorTeal Polaris-Spinner--sizeLarge">
						<svg viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg">
							<path d="M15.542 1.487A21.507 21.507 0 00.5 22c0 11.874 9.626 21.5 21.5 21.5 9.847 0 18.364-6.675 20.809-16.072a1.5 1.5 0 00-2.904-.756C37.803 34.755 30.473 40.5 22 40.5 11.783 40.5 3.5 32.217 3.5 22c0-8.137 5.3-15.247 12.942-17.65a1.5 1.5 0 10-.9-2.863z"></path>
						</svg>
					</span>
				</div>
			</div>
		</div>
		<div class="Polaris-Modal-Footer">
			<div class="Polaris-Modal-Footer__FooterContent">
				<div class="Polaris-Stack Polaris-Stack--alignmentCenter">
					<div class="Polaris-Stack__Item Polaris-Stack__Item--fill"></div>
					<div class="Polaris-Stack__Item">
						<div class="Polaris-ButtonGroup">
							<div class="Polaris-ButtonGroup__Item">
								<button class="Polaris-Button Polaris-Button--primary Close" type="button">
									<span class="Polaris-Button__Content">
										<span class="Polaris-Button__Text"><?php _e('Close','Picsmize'); ?></span>
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

<div class="Polaris-Modal-Dialog__Container Polaris-Image-Preview-Modal">
	<div class="Polaris-Modal-Dialog__Modal Polaris-Modal-Dialog--sizeLarge">
		<div class="Polaris-Modal-Header">
			<div class="Polaris-Modal-Header__Title">
				<h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall"></h2>
			</div>
			<button class="Polaris-Modal-CloseButton">
				<span class="Polaris-Icon Polaris-Icon--colorBase">
					<svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" >
						<path d="M11.414 10l6.293-6.293a1 1 0 1 0-1.414-1.414L10 8.586 3.707 2.293a1 1 0 0 0-1.414 1.414L8.586 10l-6.293 6.293a1 1 0 1 0 1.414 1.414L10 11.414l6.293 6.293A.998.998 0 0 0 18 17a.999.999 0 0 0-.293-.707L11.414 10z"></path>
					</svg>
				</span>
			</button>
		</div>
		<div class="Polaris-Modal__BodyWrapper">
			<div class="Polaris-Spinner__Container Spinner_Show">
				<div class="Polaris-Spinner__Content">
					<span class="Polaris-Spinner Polaris-Spinner--colorTeal Polaris-Spinner--sizeLarge">
						<svg viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg">
							<path d="M15.542 1.487A21.507 21.507 0 00.5 22c0 11.874 9.626 21.5 21.5 21.5 9.847 0 18.364-6.675 20.809-16.072a1.5 1.5 0 00-2.904-.756C37.803 34.755 30.473 40.5 22 40.5 11.783 40.5 3.5 32.217 3.5 22c0-8.137 5.3-15.247 12.942-17.65a1.5 1.5 0 10-.9-2.863z"></path>
						</svg>
					</span>
				</div>
			</div>
			<div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical">
				<section class="Polaris-Modal-Section">
					<img src="">
					<div class="img-comp-container">
						<div class="img-comp-slider"> 
							<div class="divider">
								<div class="handle"></div>
							</div>
						</div>
						<div class="img-comp-responsive">
							<div class="img-comp-img">
								<img src="" style="width:auto;height:100%;max-width:initial;">
							</div>
							<div class="img-comp-img img-comp-overlay" id="img-comp-overlay">
								<img src="" style="width:auto;height:100%;max-width:initial;">
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var PicsAjax = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>