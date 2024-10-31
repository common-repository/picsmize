<div class="Polaris-Page"> 
	<div class="Polaris-Page__Content">
		<div class="Polaris-Layout">
			<div class="Polaris-Layout__Section Polaris-Layout__Section--oneHalf">
				<div class="Polaris-Card polaris-file-drop">
					<div class="Polaris-Card__Section">
						<label for="Polaris-File-Input">
							<div class="Polaris-DropZone Polaris-DropZone--hasOutline Polaris-DropZone--sizeExtraLarge">
								<div class="Polaris-DropZone__Overlay">
									<div class="Polaris-Stack Polaris-Stack--vertical Polaris-Stack--spacingTight">
										<div class="Polaris-Stack__Item">
											<span class="Polaris-Icon Polaris-Icon--colorPrimary Polaris-Icon--applyColor">
												<svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false">
													<path d="M2 2h1V0H1.5A1.5 1.5 0 0 0 0 1.5V3h2V2zm3 0h3V0H5v2zm8 0h-3V0h3v2zM0 5v3h2V5H0zm0 5v3h2v-3H0zm18-5h-2v3h2V5zM5 18h3v-2H5v2zm-5-1a1 1 0 0 0 1 1h2v-2H2v-1H0v2zM16 3V2h-1V0h1.5A1.5 1.5 0 0 1 18 1.5V3h-2z"></path>
													<path d="M10.814 14H5.5A1.5 1.5 0 0 1 4 12.5v-7A1.5 1.5 0 0 1 5.5 4h7A1.5 1.5 0 0 1 14 5.5v5.314l5.512 2.506a.832.832 0 0 1 .028 1.501l-2.898 1.45a.832.832 0 0 0-.372.371l-1.449 2.898a.832.832 0 0 1-1.501-.028L10.814 14zm-.909-2l-.828-1.821c-.318-.7.402-1.42 1.102-1.102L12 9.905V6H6v6h3.905z"></path>
												</svg>
											</span>
										</div>
										<div class="Polaris-Stack__Item">
											<p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall"><?php _e('Drop Message','Picsmize'); ?></p>
										</div>
									</div>
								</div>
								<div class="Polaris-DropZone__Container" style="position: relative;">
									<div class="Polaris-Spinner__Container" id="DropZone-loader">
										<div class="Polaris-Spinner__Content">
											<span class="Polaris-Spinner Polaris-Spinner--colorTeal Polaris-Spinner--sizeLarge">
												<svg viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg">
													<path d="M15.542 1.487A21.507 21.507 0 00.5 22c0 11.874 9.626 21.5 21.5 21.5 9.847 0 18.364-6.675 20.809-16.072a1.5 1.5 0 00-2.904-.756C37.803 34.755 30.473 40.5 22 40.5 11.783 40.5 3.5 32.217 3.5 22c0-8.137 5.3-15.247 12.942-17.65a1.5 1.5 0 10-.9-2.863z"></path>
												</svg>
											</span>
											<h2 class="Polaris-Spinner__Title"><?php _e('Upload Image','Picsmize'); ?></h2>
										</div>
									</div>
									<div class="Polaris-DropZone-FileUpload">
										<div class="Polaris-Stack Polaris-Stack--vertical Polaris-DropZone-NoFileUpload">
											<div class="Polaris-Stack__Item">
												<img width="35" src="data:image/svg+xml,%3csvg fill='none' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill-rule='evenodd' clip-rule='evenodd' d='M20 10a10 10 0 11-20 0 10 10 0 0120 0zM5.3 8.3l4-4a1 1 0 011.4 0l4 4a1 1 0 01-1.4 1.4L11 7.4V15a1 1 0 11-2 0V7.4L6.7 9.7a1 1 0 01-1.4-1.4z' fill='%235C5F62'/%3e%3c/svg%3e" alt="">
											</div>
											<div class="Polaris-Stack__Item">
												<div class="Polaris-DropZone-FileUpload__Button"><?php _e('Add Image','Picsmize'); ?></div>
											</div>
											<div class="Polaris-Stack__Item">
												<span class="Polaris-TextStyle--variationSubdued">
													<?php _e('or drop image to upload','Picsmize'); ?>
												</span>
											</div>
										</div>
										<div class="upload-pre-images"></div>
									</div>
								</div>
								
								<span class="Polaris-VisuallyHidden">
									<input accept="image/*" id="Polaris-File-Input" type="file" multiple="" autocomplete="off">
								</span>
								
							</div>
						</label>
						<div class="Polaris-Stack Polaris-Stack--alignmentCenter">
							<div class="Polaris-Stack__Item Polaris-Stack__Item--fill"></div>
							<div class="Polaris-Stack__Item">
								<div class="Polaris-ButtonGroup hide">
									<div class="Polaris-ButtonGroup__Item">
										<button class="Polaris-Button" type="button" id="manully_remove_all">
											<span class="Polaris-Button__Content">
												<span class="Polaris-Button__Text"><?php _e('Remove All','Picsmize'); ?></span>
											</span>
										</button>
									</div>
									<div class="Polaris-ButtonGroup__Item">
										<button class="Polaris-Button Polaris-Button--primary" type="button" id="manully_upload_all">
											<span class="Polaris-Button__Content">
												<span class="Polaris-Button__Text"><?php _e('Upload All','Picsmize'); ?></span>
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
		<div class="Polaris-Layout">
			<div class="Polaris-Layout__Section">
				<div  class="Polaris-Card">
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
		                                                <option value=""><?php _e('All Images','Picsmize'); ?></option>
														<option value="3"><?php _e('Compressed','Picsmize'); ?></option>
														<option value="0"><?php _e('Uncompressed','Picsmize'); ?></option>
														<option value="5"><?php _e('Failed','Picsmize'); ?></option>
		                                            </select>
		                                            <div class="Polaris-Select__Content">
		                                                <span class="Polaris-Select__SelectedOption"><?php _e('All Images','Picsmize'); ?></span>
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
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="Polaris-Card__Section" style="position: relative;"> 
						<div class="Polaris-Spinner__Container" id="listing-loader">
							<div class="Polaris-Spinner__Content">
								<span class="Polaris-Spinner Polaris-Spinner--sizeLarge">
									<svg viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg"><path d="M15.542 1.487A21.507 21.507 0 00.5 22c0 11.874 9.626 21.5 21.5 21.5 9.847 0 18.364-6.675 20.809-16.072a1.5 1.5 0 00-2.904-.756C37.803 34.755 30.473 40.5 22 40.5 11.783 40.5 3.5 32.217 3.5 22c0-8.137 5.3-15.247 12.942-17.65a1.5 1.5 0 10-.9-2.863z"></path></svg>
								</span>
							</div>
						</div>
						<input id="csrf" type="hidden" data-name='' value="">  
						<table id="image-listing" class="display dataTable no-footer">
							<thead>
								<tr>
									<th><?php _e('Date','Picsmize'); ?></th>
									<th></th>
									<th><?php _e('File_name','Picsmize'); ?></th>
									<th><?php _e('Status','Picsmize'); ?></th>
									<th><?php _e('Action','Picsmize'); ?></th>
								</tr>
							</thead>
						</table>
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

<script>
	var PicsAjax = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>