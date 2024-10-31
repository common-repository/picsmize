<?php 
	$pics_api_key  = get_option( 'pics_api_key' );
?>
<div class="Polaris-Page"> 
	<div class="Polaris-Page__Content">
		<div class="Polaris-Layout">
		    <div class="Polaris-Layout__Section">
				<h2 class="Polaris-Heading"><?php _e('Picsmize API Setup','Picsmize') ?></h2>
			</div>
			<div class="Polaris-Layout__Section">
		        <div class="Polaris-Card">
					<div class="Polaris-Card__Section">
						<div class="Polaris-FormLayout">
						  	<div class="Polaris-FormLayout__Item">
							    <div class="">
							      	<div class="Polaris-Labelled__LabelWrapper">
							        	<div class="Polaris-Label"><label id="PolarisTextField8Label" for="PolarisTextField8" class="Polaris-Label__Text"><?php _e('API Key'); ?></label></div>
							      	</div>
							      	<div class="Polaris-Connected">
								        <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
								          	<div class="Polaris-TextField">
								          		<input id="pics_api_key" name="pics_api_key" autocomplete="off" class="Polaris-TextField__Input" type="text" aria-labelledby="PolarisTextField8Label" aria-invalid="false" value="<?php esc_attr_e( $pics_api_key ); ?>">
								          	</div>
								        </div>
								    </div>
								    <div class="Polaris-Labelled__HelpText" id="PolarisTextField8HelpText"><?php _e('Enter your picsmize API key to activate the plugin.'); ?></div>
							    </div>
						  	</div>
						  	<div class="Polaris-FormLayout__Item">
						  		<p class="submit">
						  			<input type="submit" name="submit" id="API-save" class="button button-primary" value="Save Changes">
						  		</p>
						  	</div>
						</div>
					</div>
		        </div>
		    </div>
		</div>
		<div class="Polaris-Layout setup-layout">
			<div class="Polaris-Layout__Section">
				<h2 class="Polaris-Heading"><?php _e('Setup Instructions','Picsmize') ?></h2>
			</div>
			<div class="Polaris-Layout__Section">
				<div class="Polaris-Card">
					<div class="Polaris-Card__Section">
						<div class="Polaris-Card__SectionHeader">
							<h3 aria-label="Reports" class="Polaris-Subheading">1. How to get API key?</h3>
						</div>
						<p>To setup the plugin you must have Picsmize API key to process further, here is the steps how to get API key : </p>
						<ul class="pics-auth-ul">
							<li>Go to <a target="_blank" href="<?php echo esc_attr(PICS_SITE_URL);?>" class="Polaris-Link">Picsmize website<svg viewBox="0 0 20 20" width="18px" height="18px" style="vertical-align: bottom;fill:var(--p-interactive,#2c6ecb)" xmlns="http://www.w3.org/2000/svg"><path d="M11 4a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 11-2 0V6.414l-5.293 5.293a1 1 0 01-1.414-1.414L13.586 5H12a1 1 0 01-1-1zM3 6.5A1.5 1.5 0 014.5 5H8a1 1 0 010 2H5v8h8v-3a1 1 0 112 0v3.5a1.5 1.5 0 01-1.5 1.5h-9A1.5 1.5 0 013 15.5v-9z"></path></svg></a> and click on <a target="_blank" href="<?php echo esc_attr(PICS_SITE_URL);?>/register" class="Polaris-Link">Sign Up<svg viewBox="0 0 20 20" width="18px" height="18px" style="vertical-align: bottom;fill:var(--p-interactive,#2c6ecb)" xmlns="http://www.w3.org/2000/svg"><path d="M11 4a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 11-2 0V6.414l-5.293 5.293a1 1 0 01-1.414-1.414L13.586 5H12a1 1 0 01-1-1zM3 6.5A1.5 1.5 0 014.5 5H8a1 1 0 010 2H5v8h8v-3a1 1 0 112 0v3.5a1.5 1.5 0 01-1.5 1.5h-9A1.5 1.5 0 013 15.5v-9z"></path></svg></a> to create your account.</li>
							<li>
								Complete the verification process and login to your <a target="_blank" href="<?php echo esc_attr(PICS_SITE_URL);?>/login" class="Polaris-Link">Picsmize Account<svg viewBox="0 0 20 20" width="18px" height="18px" style="vertical-align: bottom;fill:var(--p-interactive,#2c6ecb)" xmlns="http://www.w3.org/2000/svg"><path d="M11 4a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 11-2 0V6.414l-5.293 5.293a1 1 0 01-1.414-1.414L13.586 5H12a1 1 0 01-1-1zM3 6.5A1.5 1.5 0 014.5 5H8a1 1 0 010 2H5v8h8v-3a1 1 0 112 0v3.5a1.5 1.5 0 01-1.5 1.5h-9A1.5 1.5 0 013 15.5v-9z"></path></svg></a>
							</li>
							<li>
								Now go to the API settings and create new API key for wordpress.
							</li>
							<li>Copy API key and add to API settings and save.</li>
						</ul>
					</div>
					<div class="Polaris-Card__Section">
						<div class="Polaris-Card__SectionHeader">
							<h3 aria-label="Reports" class="Polaris-Subheading">2. Compress images manually</h3>
						</div>
						<p>In Dashboard, You can see a list of all images available in your store, To manually compress or process the image, click the option (three dots) button and Click compress. <a target="_blank" href="<?php echo esc_attr(PICS_HELP_DIR);?>assets/image/help/wp_manual_compress.png" class="Polaris-Link">View here<svg viewBox="0 0 20 20" width="18px" height="18px" style="vertical-align: bottom;fill:var(--p-interactive,#2c6ecb)" xmlns="http://www.w3.org/2000/svg"><path d="M11 4a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 11-2 0V6.414l-5.293 5.293a1 1 0 01-1.414-1.414L13.586 5H12a1 1 0 01-1-1zM3 6.5A1.5 1.5 0 014.5 5H8a1 1 0 010 2H5v8h8v-3a1 1 0 112 0v3.5a1.5 1.5 0 01-1.5 1.5h-9A1.5 1.5 0 013 15.5v-9z"></path></svg></a></p>
					</div>
					<div class="Polaris-Card__Section">
						<div class="Polaris-Card__SectionHeader">
							<h3 aria-label="Summary" class="Polaris-Subheading">3. Compress images automatically</h3>
						</div>
						<p>To compress the images automatically, you simply need to enable / Turn on the Auto mode option given compress settings from side menu. <a target="_blank" href="<?php echo esc_attr(PICS_HELP_DIR);?>assets/image/help/wp_auto_compress.png" class="Polaris-Link">View here<svg viewBox="0 0 20 20" width="18px" height="18px" style="vertical-align: bottom;fill:var(--p-interactive,#2c6ecb)" xmlns="http://www.w3.org/2000/svg"><path d="M11 4a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 11-2 0V6.414l-5.293 5.293a1 1 0 01-1.414-1.414L13.586 5H12a1 1 0 01-1-1zM3 6.5A1.5 1.5 0 014.5 5H8a1 1 0 010 2H5v8h8v-3a1 1 0 112 0v3.5a1.5 1.5 0 01-1.5 1.5h-9A1.5 1.5 0 013 15.5v-9z"></path></svg></a></p>
					</div>
					<div class="Polaris-Card__Section">
						<div class="Polaris-Card__SectionHeader">
							<h3 aria-label="Summary" class="Polaris-Subheading">4. Setup template before change ALT and rename product images.</h3>
						</div>
						<p>According to template, App will set ALT text and name of product image. <a target="_blank" href="<?php echo esc_attr(PICS_HELP_DIR);?>assets/image/help/wp_rename.png" class="Polaris-Link">View here<svg viewBox="0 0 20 20" width="18px" height="18px" style="vertical-align: bottom;fill:var(--p-interactive,#2c6ecb)" xmlns="http://www.w3.org/2000/svg"><path d="M11 4a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 11-2 0V6.414l-5.293 5.293a1 1 0 01-1.414-1.414L13.586 5H12a1 1 0 01-1-1zM3 6.5A1.5 1.5 0 014.5 5H8a1 1 0 010 2H5v8h8v-3a1 1 0 112 0v3.5a1.5 1.5 0 01-1.5 1.5h-9A1.5 1.5 0 013 15.5v-9z"></path></svg></a></p>
					</div>
					<div class="Polaris-Card__Section">
						<div class="Polaris-Card__SectionHeader">
							<h3 aria-label="Summary" class="Polaris-Subheading">5. Change ALT and rename images automatically.</h3>
						</div>
						<p>To change ALT tags and rename products images automatically,You simply need to turn on the given options on application's dashboard. <a target="_blank" href="<?php echo esc_attr(PICS_HELP_DIR);?>assets/image/help/wp_auto_alt.png" class="Polaris-Link">View here<svg viewBox="0 0 20 20" width="18px" height="18px" style="vertical-align: bottom;fill:var(--p-interactive,#2c6ecb)" fill="var(--p-icon-on-surface,#919eab)" xmlns="http://www.w3.org/2000/svg"><path d="M11 4a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 11-2 0V6.414l-5.293 5.293a1 1 0 01-1.414-1.414L13.586 5H12a1 1 0 01-1-1zM3 6.5A1.5 1.5 0 014.5 5H8a1 1 0 010 2H5v8h8v-3a1 1 0 112 0v3.5a1.5 1.5 0 01-1.5 1.5h-9A1.5 1.5 0 013 15.5v-9z"></path></svg></a></p>
					</div>
					<div class="Polaris-Card__Section">
						<div class="Polaris-Stack">
							<div class="Polaris-Stack__Item">
								<div class="Polaris-ButtonGroup">
									<div class="Polaris-ButtonGroup__Item">
										<a target="_blank" href="https://picsmize.freshdesk.com/support/solutions/folders/82000609001" class="Polaris-Button"><span class="Polaris-Button__Content">
											<span class="Polaris-Button__Text"><?php _e('Learn more','Picsmize') ?></span></span>
										</a>
									</div>
								</div>
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
</script>