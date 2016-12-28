<?php
/**
* @copyright	Copyright (C) 2009 - 2015 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		PayPlans
* @subpackage	Quick registration 
* @contact 		support+payplans@readybytes.in


*/
if(defined('_JEXEC')===false) die();


$plan_id = JRequest::getVar('plan_id');

/*$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('*');
$query->from($db->quoteName('#__payplans_planaddons'));
//$query->where($db->quoteName('plans') . ' in '. $plan_id);
$db->setQuery($query);		
$addon_result = $db->loadObjectList();*/

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('*');
$query->from($db->quoteName('#__payplans_planaddons'));
//$query->where($db->quoteName('plans') . ' in '. $plan_id);
$db->setQuery($query);		
$addon_result = $db->loadObjectList();
$addon_result_new=array();
if(isset($addon_result) && count($addon_result) >0){
	foreach ($addon_result as $key => $value) {
		$onlyvalues = str_replace(array('[',']','"'), "", $value->plans);
		$explode= explode(',', $onlyvalues);
		
		if (in_array($plan_id, $explode)) {
		    $addon_result_new[] = $value;
		}
	}
}

if(isset($addon_result_new)){

foreach ($addon_result_new as $key => $value) {
	
	if($value->planaddons_id == 1 || $value->planaddons_id == 2) {
		$default_province_limit = $value->default_quantity;
	}
	if($value->planaddons_id == 3) {
		
		$extra_province_qty = $value->default_quantity;
	}
	if($value->planaddons_id == 4 || $value->planaddons_id == 5 || $value->planaddons_id == 6) {
		$default_photo_limit = $value->default_quantity;
	}
	if($value->planaddons_id == 7) {
		$extended_photo_limit = $value->default_quantity;
	}
	if($value->planaddons_id == 9 || $value->planaddons_id == 10 || $value->planaddons_id == 11) {
		$default_wdata_limit = $value->default_quantity;
	}
	if($value->planaddons_id == 12) {
		$extended_wdata_limit = $value->default_quantity;
	}
	if($value->planaddons_id == 16 || $value->planaddons_id == 17) {
		$default_species_limit = $value->default_quantity;
	}	
}
}
$final_province_limit = $default_province_limit;
//$final_province_limit = $default_province_limit + $extra_province_qty;
//$final_photo_limit = $default_photo_limit + $extended_photo_limit;
$final_photo_limit = $default_photo_limit;
$final_wdata_limit = $default_wdata_limit + $extended_wdata_limit;


?>
<script src="<?php echo PayplansHelperUtils::pathFS2URL(dirname(__FILE__).DS.'registration.js');?>" type="text/javascript"></script>

<div id="auto-register">
	<fieldset class="form-vertical">
		<legend><?php echo XiText::_('COM_PAYPLANS_PLAN_AUTO_REGISTERATION');?></legend>
	
	<?php if($this->params->get('show_fullname', 0)) :?>
		<div class="control-group">
  			<div class="control-label">
    			<?php echo XiText::_('COM_PAYPLANS_PLAN_REGISTERATION_FULLNAME');?>
  			</div>
  			<div class="controls">
    			<input type="text" size="20" id="payplansUserFullname" name="payplansUserFullname" class="placeholder required"  />
  			</div>	
		</div>
	<?php endif;?>
		<div class="control-group">
			<div class="control-label">
				<?php echo XiText::_('COM_PAYPLANS_PLAN_REGISTERATION_USERNAME');?>
			</div>
			<div class="controls">
				<input type="text" size="20" id="payplansRegisterAutoUsername" name="payplansRegisterAutoUsername" class="placeholder required"
						pattern="(\w+[\.\@\-\w]*\w*){2,}"
						data-validation-pattern-message="<?php echo XiText::sprintf('JLIB_DATABASE_ERROR_VALID_AZ09', 2); ?>" 
				/>
				<span class="payplansRegisterAutoUsername">
					<span class="badge badge-success hide"><i class="icon-ok-sign icon-white"></i></span>
					<span class="badge badge-warning"><i class="icon-remove-sign icon-white"></i></span>
					<span class="badge badge-info hide"><i class=" icon-refresh icon-white"></i></span>
				</span>
				<div class="text-warning pp-gap-bottom05" id="err-payplansRegisterAutoUsername"></div>
			</div>	
		</div>
		<div class="control-group">
			<div class="control-label">
				<?php echo XiText::_('COM_PAYPLANS_PLAN_REGISTERATION_EMAIL');?>		
			</div>
			<div class="controls">
				<input type="text" size="20" id="payplansRegisterAutoEmail" name="payplansRegisterAutoEmail" class="placeholder required" />
				<span class="payplansRegisterAutoEmail">
					<span class="badge badge-success hide"><i class="icon-ok-sign icon-white"></i></span>
					<span class="badge badge-warning"><i class="icon-remove-sign icon-white"></i></span>
					<span class="badge badge-info hide"><i class=" icon-refresh icon-white"></i></span>
				</span>
				<div class="text-warning pp-gap-bottom05" id="err-payplansRegisterAutoEmail"></div>
			</div>
		</div>
		
		<div class="control-group">
			<div class="control-label">
				<?php echo XiText::_('COM_PAYPLANS_PLAN_REGISTERATION_PASSWORD');?>		
			</div>
			<div class="controls">
				<input type="password" size="20" id="payplansRegisterAutoPassword" name="payplansRegisterAutoPassword" class="required" />
				<span class="payplansRegisterAutoPassword">
					<span class="badge badge-success hide"><i class="icon-ok-sign icon-white"></i></span>
					<span class="badge badge-warning"><i class="icon-remove-sign icon-white"></i></span>
					<span class="badge badge-info hide"><i class=" icon-refresh icon-white"></i></span>
				</span>	
				<div class="text-warning pp-gap-bottom05" id="err-payplansRegisterAutoPassword"></div>
			</div>
		</div>
		
		<?php //if($this->params->get('show_confirmpassword', 0)) :?>
		<div class="control-group">
			<div class="control-label">
				<?php echo XiText::_('COM_PAYPLANS_PLAN_REGISTERATION_CONFIRMPASSWORD');?>		
			</div>
			<div class="controls">
				<input type="password" size="20" id="payplansRegisterAutoConfirmPassword" name="payplansRegisterAutoConfirmPassword" 
				data-validation-match-match="payplansRegisterAutoPassword" data-validation-match-message="<?php echo XiText::_('COM_PAYPLANS_PLAN_REGISTERATION_CONFIRMPASSWORD_VALIDATION_MESSAGE');?>"/>
				<span class="payplansRegisterAutoConfirmPassword">
					<span class="badge badge-success hide"><i class="icon-ok-sign icon-white"></i></span>
					<span class="badge badge-warning"><i class="icon-remove-sign icon-white"></i></span>
					<span class="badge badge-info hide"><i class=" icon-refresh icon-white"></i></span>
				</span>	
				<div class="text-warning pp-gap-bottom05" id="payplansRegisterAutoConfirmPassword"></div>
			</div>
		</div>
		<?php //endif;?>
		<div class="control-group">
			<div class="control-label">
				Country:&nbsp;*
			</div>
			<div class="controls">
				<select name="payplansRegisterAutoCountry" id="jform_profile_country" aria-invalid="false" class="required">
					<option value="canada">Canada</option>
					<option value="united_states">United States</option>
				</select>
				<span class="payplansRegisterAutoCountry">
					<span class="badge badge-success hide"><i class="icon-ok-sign icon-white"></i></span>
					<span class="badge badge-warning"><i class="icon-remove-sign icon-white"></i></span>
					<span class="badge badge-info hide"><i class=" icon-refresh icon-white"></i></span>
				</span>

				<div class="text-warning pp-gap-bottom05" id="err-payplansRegisterAutoCountry"></div>
			</div>
		</div>
		  <div class="control-group">
			<div class="control-label">
					Province/state:&nbsp;*							
					<span><?php echo '[<b>'.$final_province_limit.'</b> allowed]'; ?></span>
			</div>
			<div class="controls">
				<!-- <select name="payplansRegisterAutoState" id="jform_profile_region" aria-invalid="false" class="required">
					
				</select> -->
				<div class="span4 state_dropdown controls">
							
		            <select name="province[]" id="provience_box" aria-invalid="false" class="required">
		            	<option value="">Province</option>            	
		            </select>						
				</div>
				<span class="provience_box">
					<span class="badge badge-success hide"><i class="icon-ok-sign icon-white"></i></span>
					<span class="badge badge-warning"><i class="icon-remove-sign icon-white"></i></span>
					<span class="badge badge-info hide"><i class=" icon-refresh icon-white"></i></span>
				</span>
				<div class="text-warning pp-gap-bottom05" id="err-payplansRegisterAutoState"></div>
			</div>
		</div> 
		<div class="control-group">
						<?php
						
						if($default_species_limit != 0) { ?>
							<div class="control-label">
								<span><?php echo JTEXT::_('COM_PAYPLANS_PLAN_SELECT_SPECIES_LABEL2'); ?></span>
								<span><?php echo '[<b>'.$default_species_limit.'</b> allowed]'; ?></span>
					            
							</div>
							<div class="controls species_dropdown">
							
					            <select name="species[]" id="species_box">
					            	<option value="">Species</option>
					            </select>
							</div>
						<?php } else { ?>
								<div class="control-label">
									<span><?php echo JTEXT::_('COM_PAYPLANS_PLAN_SELECT_SPECIES_LABEL2'); ?>:&nbsp;*</span>
								</div>
								<div class="controls">
									<b><?php echo JTEXT::_('COM_PAYPLANS_PLAN_SELECT_LIMIT_VALUE'); ?></b>
								</div>
								
						<?php } ?>
					</div>
		<!-- <div class="span12">
						<div class="span4">
							<b>Province/state:&nbsp;*							
							<span><?php echo '[<b>'.$final_province_limit.'</b> allowed]'; ?></span></b>
						</div>
						<div class="span4 state_dropdown">
							
				            <select name="province[]" id="provience_box">
				            	<option value="">Province</option>            	
				            </select>						
						</div>
					</div> -->
		<!-- <div class="control-group">
			<div class="control-label">
					Capcha:&nbsp;*
			</div>
			<div class="controls">
				<?php
		        	if($this->params->get('show_captcha', 0)){
						JPluginHelper::importPlugin('captcha');
						$dispatcher = JDispatcher::getInstance();
						$dispatcher->trigger('onInit','payplans_dynamic_recaptcha');
						$displayCaptcha = $dispatcher->trigger('onDisplay',array('payplans_dynamic_recaptcha', 'payplans_dynamic_recaptcha','payplans_dynamic_recaptcha'));
						echo array_shift($displayCaptcha);	
			       } ?>
			</div>
		</div> -->
		
		<div class="control-group check-cls">
		<div class="controls">
				<input type="checkbox" id="payplansRegisterAutoTerm" name="payplansRegisterAutoTerm" class="required" value="1" />
				
				<div class="text-warning pp-gap-bottom05" id="err-payplansRegisterAutoTerm"></div>
			</div>
			<div class="control-label">
					<label class="required" for="jform_terms" id="jform_terms-lbl">
					<?php echo XiText::_('COM_USERS_TERMS_LABEL')?><span class="star">&nbsp;*</span>
					</label>
			</div>
			
		</div>
		<div class="control-group check-cls">
		<div class="controls">
						<input type="checkbox" id="payplansRegisterAutoPrivacy" name="payplansRegisterAutoPrivacy" class="required" value="1" />
						<div class="text-warning pp-gap-bottom05" id="err-payplansRegisterAutoPrivacy"></div>
						</div>
					<div class="control-label">
					<label class="required" for="jform_privacy" id="jform_privacy-lbl">
						<?php echo XiText::_('COM_USERS_PRIVACY_LABEL')?><span class="star">&nbsp;*</span></label>										</div>
					
				</div>

		<div class="control-group register-button">
			<div class="offset8">
				<button type="submit" class="btn" id="payplansRegisterAuto" name="payplansRegisterAuto">&nbsp;<?php echo XiText::_('COM_PAYPLANS_PLAN_REGISTER_AUTO')?></button>
			</div>
		</div>
	</fieldset>
</div>




  
  
  
  <link rel="stylesheet" href="/media/jui/css/chosen.css" type="text/css" />

 
  <script src="/media/jui/js/chosen.jquery.min.js" type="text/javascript"></script>
  
  
	
</head>

<script type="text/javascript">
	
	var plan_id = '<?php echo $plan_id ?>';
	var provience_limit = '<?php echo $final_province_limit; ?>';
	var species_limit = '<?php echo $default_species_limit; ?>';
	var photo_upload_limit = '<?php echo $final_photo_limit ?>';
	var country = 'united_states';
	var state_dropdown_response;
	var state_dropdown = '';
	var current_price;
	var extra_charge;
	var final_price;
	jQuery(function(){
		


		jQuery("#provience_limit").text(provience_limit);

		user_country = jQuery('#jform_profile_country').val();
		getProvinceList(user_country);
		
		jQuery("#jform_profile_country").change(function(){

			getProvinceList(this.value);
		});

		jQuery.ajax({
	        url: 'index.php?option=com_payplans&view=plan&task=getFishSpeciesList',
	        type: 'POST',
	        success: function (species_dropdown_response) {
	        	

	        	species_list = JSON.parse(species_dropdown_response);
	        	species_length = species_list.length;
	        	species_dropdown = '<select name="species[]" class="species_picklist" multiple>';
	        	var counter2 = 0;
	        	while(counter2 < species_length) {
	
					species_dropdown += '<option value="'+species_list[counter2]['fd_fish_name']+'">'+species_list[counter2]['fd_fish_name']+
	                '</option>';
	        		counter2++;
	        	}	
				species_dropdown += '</select>';

	        	jQuery(".species_dropdown").html(species_dropdown);
	        	jQuery(".species_picklist").chosen({max_selected_options:species_limit});
	        	jQuery("#species_limit").text(species_limit);
	        }
	    });
	});


	function getProvinceList(user_country) {

		jQuery.ajax({
            url: 'index.php?option=com_geo_map&task=geomaps.ajaxGetAllProvince&country='+user_country,
            type: 'POST',
            dataType: "json",
            success: function (state_dropdown_response) {
				state_dropdown = '<select name="province[]" class="state_picklist" multiple id="provience_box">';
	        	state_dropdown += '<option value="">Select Proviences</option>';
                jQuery.each(state_dropdown_response, function( index, value ) {
                    state_dropdown += '<option value="'+value["state_name"]+'">'+value["state_name"]+
                    '</option>';

                });
				
				state_dropdown += '</select>';
				
	        	jQuery(".state_dropdown").html(state_dropdown);	        	
	        	//jQuery(".state_picklist").chosen({max_selected_options:provience_limit});
	        	jQuery(".state_picklist").chosen({max_selected_options:provience_limit});
	        }
        });        
	}
	
</script>


<?php 

