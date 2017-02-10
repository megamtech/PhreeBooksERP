<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright(c) 2008-2015 PhreeSoft      (www.PhreeSoft.com)       |
// +-----------------------------------------------------------------+
// | This program is free software: you can redistribute it and/or   |
// | modify it under the terms of the GNU General Public License as  |
// | published by the Free Software Foundation, either version 3 of  |
// | the License, or any later version.                              |
// |                                                                 |
// | This program is distributed in the hope that it will be useful, |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of  |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the   |
// | GNU General Public License for more details.                    |
// +-----------------------------------------------------------------+
//  Path: /modules/inventory/pages/main/template_tab_gen.php
//
?>
<div title="<?php echo TEXT_GENERAL;?>" id="tab_general">

  <div class="easyui-window" id="inv_image" title="<?php echo $basis->cInfo->inventory->sku; ?>" data-options="modal:true,closed:true" >
    <?php if (isset($basis->cInfo->inventory->image_with_path) && $basis->cInfo->inventory->image_with_path) {
    	echo html_image(DIR_WS_MY_FILES . $_SESSION['user']->company . '/inventory/images/' . $basis->cInfo->inventory->image_with_path, '', 600) . chr(10);
    } else {
    	echo TEXT_NO_IMAGE;
    }
    ?>
    <div>
	  <h2><?php echo TEXT_SKU . ': ' . $basis->cInfo->inventory->sku; ?></h2>
	  <p><?php echo '<br />' . $basis->cInfo->inventory->description_sales; ?></p>
    </div>
  </div>

  <table class="ui-widget" style="border-style:none;width:100%">
    <tr><td>
    <table class="ui-widget" style="border-style:none;width:100%">
     <tbody class="ui-widget-content">
     <tr>
	  <td align="right"><?php echo TEXT_SKU; ?></td>
	  <td>
		<?php echo html_input_field('sku', $basis->cInfo->inventory->sku, 'readonly="readonly" size="' . (MAX_INVENTORY_SKU_LENGTH + 1) . '" maxlength="' . MAX_INVENTORY_SKU_LENGTH . '"', false); ?>
		<?php echo TEXT_INACTIVE; ?>
		<?php echo html_checkbox_field('inactive', '1', $basis->cInfo->inventory->inactive); ?>
	  </td>
	  <td align="right"><?php if(isset($basis->cInfo->inventory->quantity_on_hand)) echo TEXT_QUANTITY_ON_HAND; ?></td>
	  <td><?php if(isset($basis->cInfo->inventory->quantity_on_hand)) echo html_input_field('quantity_on_hand', $basis->currencies->precise($basis->cInfo->inventory->quantity_on_hand), 'disabled="disabled" size="6" maxlength="5" style="text-align:right"', false); ?></td>
	  <td rowspan="5" align="center">
		<?php if (isset($basis->cInfo->inventory->image_with_path) && $basis->cInfo->inventory->image_with_path) { // show image if it is defined
			echo html_image(DIR_WS_MY_FILES . $_SESSION['user']->company . '/inventory/images/' . $basis->cInfo->inventory->image_with_path, $basis->cInfo->inventory->image_with_path, '', '100', 'onclick="showImage()"');
		} else echo '&nbsp;'; ?>
	  </td>
	</tr>
	<tr>
	  <td align="right"><?php echo TEXT_SHORT_DESCRIPTION; ?></td>
	  <td>
	  	<?php echo html_input_field('description_short', $basis->cInfo->inventory->description_short, 'size="33" maxlength="32"', false); ?>
		<?php if ($basis->cInfo->inventory->id) echo '&nbsp;' . html_icon('categories/preferences-system.png', TEXT_WHERE_USED, 'small', 'onclick="ajaxWhereUsed()"') . chr(10); ?>
	  </td>
	  <td align="right"><?php if(isset($basis->cInfo->inventory->quantity_on_order)) echo TEXT_QUANTITY_ON_PURCHASE_ORDER; ?></td>
	  <td><?php if(isset($basis->cInfo->inventory->quantity_on_order)) echo html_input_field('quantity_on_order', $basis->currencies->precise($basis->cInfo->inventory->quantity_on_order), 'disabled="disabled" size="6" maxlength="5" style="text-align:right"', false); ?></td>
	</tr>
	<tr>
	  <td align="right"><?php if(isset($basis->cInfo->inventory->minimum_stock_level)) echo TEXT_MINIMUM_STOCK_LEVEL; ?></td>
	  <td><?php if(isset($basis->cInfo->inventory->minimum_stock_level)) echo html_input_field('minimum_stock_level', $basis->currencies->precise($basis->cInfo->inventory->minimum_stock_level), 'size="6" maxlength="5" style="text-align:right"', false); ?></td>
	  <td align="right"><?php if(isset($basis->cInfo->inventory->quantity_on_allocation)) echo TEXT_QUANTITY_ON_ALLOCATION; ?></td>
	  <td><?php if(isset($basis->cInfo->inventory->quantity_on_allocation)) echo html_input_field('quantity_on_allocation', $basis->currencies->precise($basis->cInfo->inventory->quantity_on_allocation), 'disabled="disabled" size="6" maxlength="5" style="text-align:right"', false); ?></td>
	</tr>
	<tr>
	  <td align="right"><?php if(isset($basis->cInfo->inventory->reorder_quantity)) echo TEXT_REORDER_QUANTITY; ?></td>
	  <td><?php if(isset($basis->cInfo->inventory->reorder_quantity)) echo html_input_field('reorder_quantity', $basis->currencies->precise($basis->cInfo->inventory->reorder_quantity), 'size="6" maxlength="5" style="text-align:right"', false); ?></td>
	  <td align="right"><?php if(isset($basis->cInfo->inventory->quantity_on_sales_order)) echo TEXT_QUANTITY_ON_SALES_ORDER; ?></td>
	  <td><?php if(isset($basis->cInfo->inventory->quantity_on_sales_order)) echo html_input_field('quantity_on_sales_order', $basis->currencies->precise($basis->cInfo->inventory->quantity_on_sales_order), 'disabled="disabled" size="6" maxlength="5" style="text-align:right"', false); ?></td>
	</tr>
	<tr>
	  <td align="right"><?php if(isset($basis->cInfo->inventory->lead_time)) echo TEXT_LEAD_TIME_DAYS; ?></td>
	  <td><?php if(isset($basis->cInfo->inventory->lead_time)) echo html_input_field('lead_time', $basis->cInfo->inventory->lead_time, 'size="6" maxlength="5" style="text-align:right"', false); ?></td>
	  <td align="right"><?php if(isset($basis->cInfo->inventory->item_weight)) echo TEXT_ITEM_WEIGHT; ?></td>
	  <td><?php if(isset($basis->cInfo->inventory->item_weight)) echo html_input_field('item_weight', $basis->currencies->precise($basis->cInfo->inventory->item_weight), 'size="11" maxlength="9" style="text-align:right"', false); ?></td>
	</tr>
	</tbody>
	</table>
	<?php if(in_array('sell',$basis->cInfo->inventory->posible_transactions)){?>
    <table class="ui-widget" style="border-style:none;width:100%">
 	 <thead class="ui-widget-header">
	  <tr><th colspan="5"><?php echo TEXT_CUSTOMER_DETAILS; ?></th></tr>
	 </thead>
	 <tbody class="ui-widget-content">
	<tr>
	  <td valign="top" align="right"><?php if(isset($basis->cInfo->inventory->description_sales)) echo TEXT_SALES_DESCRIPTION; ?></td>
	  <td colspan="5"><?php if(isset($basis->cInfo->inventory->description_sales)) echo html_textarea_field('description_sales', 75, 2, $basis->cInfo->inventory->description_sales, '', $reinsert_value = true); ?></td>
	</tr>
	<tr>
	  <td align="right"><?php if(isset($basis->cInfo->inventory->full_price_with_tax)) echo TEXT_FULL_PRICE_WITH_TAX; ?> </td>
	  <td><?php if(isset($basis->cInfo->inventory->full_price_with_tax)) echo html_input_field('full_price_with_tax', $basis->currencies->precise($basis->cInfo->inventory->full_price_with_tax), 'onchange="update_full_price_incl_tax(true, false, true);" size="15" maxlength="20" style="text-align:right" ', false);
	  if (isset($basis->cInfo->inventory->full_price_with_tax) && ENABLE_MULTI_CURRENCY) echo ' (' . DEFAULT_CURRENCY . ')';
	  if(isset($basis->cInfo->inventory->full_price_with_tax)) echo '   <i>'.$basis->cInfo->inventory->full_price_with_tax.'</i>';
	  ?>
	  </td>
	</tr>
	<tr>
	  <td align="right"><?php if(isset($basis->cInfo->inventory->full_price)) echo TEXT_FULL_PRICE; ?></td>
	  <td>
	  	<?php if(isset($basis->cInfo->inventory->full_price)) echo html_input_field('full_price', $basis->currencies->precise($basis->cInfo->inventory->full_price), 'onchange="update_full_price_incl_tax(true, true, false);" size="15" maxlength="20" style="text-align:right"', false);
			if (isset($basis->cInfo->inventory->full_price) && ENABLE_MULTI_CURRENCY) echo ' (' . DEFAULT_CURRENCY . ')';
			if (isset($basis->cInfo->inventory->full_price)) echo '   <i>'.$basis->currencies->precise($basis->cInfo->inventory->full_price).'</i>';
		    if(isset($basis->cInfo->inventory->price_sheet)) echo '&nbsp;' . html_icon('mimetypes/x-office-spreadsheet.png', TEXT_CUSTOMER_PRICE_SHEETS, 'small', $params = 'onclick="priceMgr(' . $basis->cInfo->inventory->id . ', 0, 0, \'c\')"') . chr(10); ?>
	  </td>
	  <td align="right"><?php if(isset($basis->cInfo->inventory->item_taxable)) echo TEXT_DEFAULT_SALES_TAX; ?></td>
	  <td colspan="2"><?php if(isset($basis->cInfo->inventory->item_taxable)) echo html_pull_down_menu('item_taxable', $tax_rates, $basis->cInfo->inventory->item_taxable,'onchange="update_full_price_incl_tax(true, true, false);"'); ?></td>
	</tr>
	<tr>
	  <td align="right"><?php if(isset($basis->cInfo->inventory->product_margin)) echo TEXT_MARGIN; ?></td>
	  <td><?php if(isset($basis->cInfo->inventory->product_margin)) echo html_input_field('product_margin', $basis->currencies->precise($basis->cInfo->inventory->product_margin), 'onchange="product_margin_change();" size="15" maxlength="5" style="text-align:right" ', false);
	  if (isset($basis->cInfo->inventory->product_margin)) echo '   <i>'.$basis->currencies->precise($basis->cInfo->inventory->product_margin).'</i>'; ?>
	  </td>
	  <td align="right"><?php if(isset($basis->cInfo->inventory->price_sheet)) echo TEXT_DEFAULT_PRICE_SHEET; ?></td>
	  <td><?php if(isset($basis->cInfo->inventory->price_sheet)) echo html_pull_down_menu('price_sheet', get_price_sheet_data('c'), $basis->cInfo->inventory->price_sheet); ?></td>
	</tr>
	</tbody>
	</table>
	<?php }
	if (\core\classes\user::security_level(SECURITY_ID_PURCHASE_INVENTORY) > 0 && in_array('purchase',$basis->cInfo->inventory->posible_transactions)) { ?>
		<table id="purdg" class="easyui-datagrid" title="<?php echo TEXT_PURCHASE_DETAILS;?>"  style="border-collapse:collapse;width:100%;">
			<thead>
	       		<tr>
	       			<th data-options="field:'vendor_id',				sortable:true, align:'left',formatter:function(value,row){ return row.primary_name; },editor:{
                            type:'combobox',
                            options:{
                                valueField:'contactid',
                                textField:'primary_name',
                                method:'get',
                                url:'index.php?action=GetAllContacts',
                                required:true,
                                limitToList: true,
                                loader: customloader,
                                queryParams: {
                                	contact_show_inactive: true,
                                	type: 'v',
                                	sort: 'primary_name',
									dataType: 'json',
							        contentType: 'application/json',
							        async: false,
								},
                            }
                        }">				<?php echo TEXT_PREFERRED_VENDOR;?></th>
	       			<th data-options="field:'description_purchase',		sortable:true, align:'right',editor:'textbox'">	<?php echo TEXT_PURCHASE_DESCRIPTION?></th>
		           	<th data-options="field:'item_cost',				sortable:true, align:'right',editor:{type:'numberbox',options:{precision:1}}, formatter: function(value,row,index){ return formatCurrency(value)}"><?php echo TEXT_ITEM_COST?></th>
		           	<th data-options="field:'purch_package_quantity',	sortable:true, align:'right',editor:'numberbox', formatter: function(value,row,index){ return formatQty(value)}"><?php echo TEXT_PACKAGE_QUANTITY?></th>
		           	<th data-options="field:'purch_taxable',			sortable:true, align:'right',formatter:function(value,row){ return row.description_short; },editor:{
                            type:'combobox',
                            options:{
                                valueField:'id',
                                textField:'text',
                                method:'get',
                                url:'index.php?action=GetTaxRates',
                                required:true,
                                limitToList: true,
                                loader: customloader,
                                queryParams: {
                                	type: 'v',
									dataType: 'json',
							        contentType: 'application/json',
							        async: false,
								},
                            }
                        }">				<?php echo TEXT_DEFAULT_PURCHASE_TAX?></th>
		           	<th data-options="field:'price_sheet_v',			sortable:true, editor:{
                            type:'combobox',
                            options:{
                                valueField:'id',
                                textField:'name',
                                method:'get',
                                url:'index.php?action=GetAllPriceSheets',
                                required:true,
                                limitToList: true,
                                loader: customloader,
                                queryParams: {
                                	type: 'v',
                                	sort: 'sheet_name',
									dataType: 'json',
							        contentType: 'application/json',
							        async: false,
								},
                            }
                        }">			<?php echo TEXT_DEFAULT_PRICE_SHEET?></th>
		        </tr>
		     </thead>
		</table>
		<div id="PurchaseToolbar" >
	        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()"><?php echo TEXT_ADD?></a>
   		    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()"><?php echo TEXT_REMOVE?></a>
	        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="accept()"><?php echo TEXT_ACCEPT?></a>
       		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="reject()"><?php echo TEXT_REJECT?></a>
       		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true" onclick="getChanges()"><?php echo TEXT_GETCHANGES?></a>
        </div>
	<?php } ?>
    <table class="ui-widget" style="border-style:none;width:100%">
 	 <thead class="ui-widget-header">
	  <tr><th colspan="5"><?php echo TEXT_DETAILS; ?></th></tr>
	 </thead>
	 <tbody class="ui-widget-content">
	<tr>
	  <td align="right"><?php echo TEXT_INVENTORY_TYPES; ?></td>
	  <td><?php echo html_hidden_field('inventory_type', $basis->cInfo->inventory->inventory_type);
		echo html_input_field('inv_type_desc', $basis->cInfo->inventory->title, 'readonly="readonly"', false); ?> </td>
		<td></td>
	  <td colspan="2"><?php if(isset($basis->cInfo->inventory->image_with_path)) echo html_checkbox_field('remove_image', '1', $basis->cInfo->inventory->remove_image) . ' ' . TEXT_REMOVE . ': ' . $basis->cInfo->inventory->image_with_path; ?></td>
	</tr>
	<tr>
	  <td align="right"><?php if(isset($basis->cInfo->inventory->upc_code)) echo TEXT_UPC_CODE; ?></td>
	  <td><?php if(isset($basis->cInfo->inventory->upc_code)) echo html_input_field('upc_code', $basis->cInfo->inventory->upc_code, 'size="16" maxlength="13" style="text-align:right"', false); ?></td>
	  <td align="right"><?php if(isset($basis->cInfo->inventory->image_with_path)) echo TEXT_SELECT_IMAGE; ?></td>
	  <td colspan="2"><?php if(isset($basis->cInfo->inventory->image_with_path)) echo html_file_field('inventory_image'); ?></td>
	</tr>
	<tr>
	  <td align="right"><?php  if(!empty($basis->cInfo->inventory->posible_cost_methodes)) echo TEXT_COST_METHOD; ?></td>
	  <td>
		<?php foreach ($basis->cInfo->cost_methods as $key => $value) if (in_array($key, $basis->cInfo->inventory->posible_cost_methodes)) $cost_pulldown_array[] = array('id' => $key, 'text' => $value); ?>
		<?php if(!empty($basis->cInfo->inventory->posible_cost_methodes)) echo html_pull_down_menu('cost_method', $cost_pulldown_array, $basis->cInfo->inventory->cost_method, ($basis->cInfo->inventory->last_journal_date == '0000-00-00 00:00:00' || is_null($basis->cInfo->inventory->last_journal_date) ? '' : 'disabled="disabled"')); ?>
	    <?php if(isset($basis->cInfo->inventory->serialize)) echo ' ' . TEXT_SERIALIZE_ITEM ; ?>
	  </td>
	  <td align="right"><?php if(isset($basis->cInfo->inventory->image_with_path)) echo TEXT_RELATIVE_IMAGE_PATH; ?></td>
	  <td colspan="2"><?php if(isset($basis->cInfo->inventory->image_with_path)) echo html_hidden_field('image_with_path', $basis->cInfo->inventory->image_with_path);
		if(isset($basis->cInfo->inventory->image_with_path)) echo html_input_field('inventory_path', substr($basis->cInfo->inventory->image_with_path, 0, strrpos($basis->cInfo->inventory->image_with_path, '/'))); ?>
	  </td>
	</tr>
	<tr>
	  <td align="right"><?php if(isset($basis->cInfo->inventory->account_sales_income)) echo TEXT_SALES_INCOME_ACCOUNT; ?></td>
	  <td><?php if(isset($basis->cInfo->inventory->account_sales_income)) echo html_pull_down_menu('account_sales_income', $gl_array_list, $basis->cInfo->inventory->account_sales_income); ?></td>
	  <td rowspan="5" colspan="2">
	  <!--  *********************** Attachments  ************************************* -->
		   <fieldset>
		   <legend><?php echo TEXT_ATTACHMENTS; ?></legend>
 	   		<table class="ui-widget" style="border-collapse:collapse;margin-left:auto;margin-right:auto;">
		    <thead class="ui-widget-header">
		     <tr><th colspan="3"><?php echo TEXT_ATTACHMENTS; ?></th></tr>
		    </thead>
		    <tbody class="ui-widget-content">
		     <tr><td colspan="3"><?php echo TEXT_SELECT_FILE_TO_ATTACH . ' ' . html_file_field('file_name'); ?></td></tr>
		     <tr  class="ui-widget-header">
		      <th><?php echo html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small'); ?></th>
		      <th><?php echo TEXT_FILE_NAME; ?></th>
		      <th><?php echo TEXT_ACTION; ?></th>
		     </tr>
			<?php
				if (sizeof($basis->cInfo->inventory->attachments) > 0) {
				  foreach ($basis->cInfo->inventory->attachments as $key => $value) {
				    echo '<tr>';
				    echo ' <td>' . html_checkbox_field('rm_attach_'.$key, '1', false) . '</td>' . chr(10);
				    echo ' <td>' . $value . '</td>' . chr(10);
				    echo ' <td>' . html_button_field('dn_attach_'.$key, TEXT_DOWNLOAD, 'onclick="submitSeq(' . $key . ', \'download\', true)"') . '</td>';
				    echo '</tr>' . chr(10);
				  }
				} else {
				  echo '<tr><td colspan="3">' . TEXT_NO_DOCUMENTS_HAVE_BEEN_FOUND . '</td></tr>';
				} ?>
		     </tbody>
		   </table>
		  </fieldset>
	</tr>
	<tr>
	  <td align="right"><?php if(isset($basis->cInfo->inventory->account_inventory_wage)) echo INV_ENTRY_ACCT_INV; ?></td>
	  <td><?php if(isset($basis->cInfo->inventory->account_inventory_wage)) echo html_pull_down_menu('account_inventory_wage', $gl_array_list, $basis->cInfo->inventory->account_inventory_wage); ?></td>
	</tr>
	<tr>
	  <td align="right"><?php if(isset($basis->cInfo->inventory->account_cost_of_sales)) echo TEXT_COST_OF_SALES_ACCOUNT; ?></td>
	  <td><?php if(isset($basis->cInfo->inventory->account_cost_of_sales)) echo html_pull_down_menu('account_cost_of_sales', $gl_array_list, $basis->cInfo->inventory->account_cost_of_sales); ?></td>
	</tr>
	<tr></tr>
	<tr></tr>
	<tr></tr>
   </tbody>
   </table>

<?php if ( $basis->cInfo->inventory->qty_table) { ?>
  </td>
  <td valign="top">
  <?php echo $basis->cInfo->inventory->qty_table ?>
<?php } ?>
  </td></tr>
 </tbody>
 </table>
</div>

<script type="text/javascript">
$('#purdg').datagrid({
	url: "index.php?action=getPurchasedetails",
	queryParams: {
		sku: '<?php echo $basis->cInfo->inventory->sku;?>',
		dataType: 'json',
        contentType: 'application/json',
        async: false
	},
	onBeforeLoad:function(){
		console.log('loading of the purchase details datagrid');
	},
	onLoadSuccess:function(data){
		console.log('the loading of the purchase details datagrid was succesfull');
		$.messager.progress('close');
	},
	onLoadError: function(){
		console.error('the loading of the purchase details datagrid resulted in a error');
		$.messager.progress('close');
		$.messager.alert('<?php echo TEXT_ERROR?>','Load error for table purchase details');
	},
	onDblClickRow: function(index , row){
		console.log('a row in the purchase details datagrids was double clicked');
	},
	onCollapseRow: function(index , row){
		if (row.isNewRecord){
	        $('#cdg').datagrid('deleteRow',index);
	    }
	},
	onClickCell: onClickCell,
	onEndEdit: 	onEndEdit,
	remoteSort:	false,
	idField:	"id",
	fitColumns:	true,
	singleSelect:true,
	sortName:	"name",
	sortOrder: 	"asc",
	loadMsg:	"<?php echo TEXT_PLEASE_WAIT?>",
	toolbar: 	"#PurchaseToolbar",
});

var editIndex = undefined;
function endEditing(){
    if (editIndex == undefined){return true}
    if ($('#purdg').datagrid('validateRow', editIndex)){
        $('#purdg').datagrid('endEdit', editIndex);
        editIndex = undefined;
        return true;
    } else {
        return false;
    }
}
function onClickCell(index, field){
    if (editIndex != index){
        if (endEditing()){
            $('#purdg').datagrid('selectRow', index)
                    .datagrid('beginEdit', index);
            var ed = $('#purdg').datagrid('getEditor', {index:index,field:field});
            if (ed){
                ($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
            }
            editIndex = index;
        } else {
            setTimeout(function(){
                $('#purdg').datagrid('selectRow', editIndex);
            },0);
        }
    }
}
function onEndEdit(index, row){
    var ed = $(this).datagrid('getEditor', {
        index: index,
        field: 'productid'
    });
    row.productname = $(ed.target).combobox('getText');
}
function append(){
    if (endEditing()){
        $('#purdg').datagrid('appendRow',{status:'P'});
        editIndex = $('#purdg').datagrid('getRows').length-1;
        $('#purdg').datagrid('selectRow', editIndex)
                .datagrid('beginEdit', editIndex);
    }
}
function removeit(){
    if (editIndex == undefined){return}
    $('#purdg').datagrid('cancelEdit', editIndex)
            .datagrid('deleteRow', editIndex);
    editIndex = undefined;
}
function accept(){
    if (endEditing()){
        $('#purdg').datagrid('acceptChanges');
    }
}
function reject(){
    $('#purdg').datagrid('rejectChanges');
    editIndex = undefined;
}
function getChanges(){
    var rows = $('#purdg').datagrid('getChanges');
    alert(rows.length+' rows are changed!');
}
</script>
