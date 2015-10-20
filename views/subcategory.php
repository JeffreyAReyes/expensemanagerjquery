<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>Expense Manager - Sub-Category</title>
    <link rel="stylesheet" type="text/css" href="../themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="../themes/icon.css">
    <link rel="stylesheet" type="text/css" href="demo.css">
    <script type="text/javascript" src="../jsfiles/jquery.min.js"></script>
    <script type="text/javascript" src="../jsfiles/jquery.easyui.min.js"></script>
</head>

<body>
		
	<h2>Expense Manager - Account Sub-Categories</h2>
	<p>Click the buttons on datagrid toolbar to do actions.</p>
		
	<table id="dg" title="Categories" class="easyui-datagrid" style="width:85%;height:95%"
			url="../phpfiles/get_subcategory.php"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
				<th field="SubCatID" width="1" hidden="true">SubCatID</th>
				<th field="CatID" width="1" hidden="true">CatID</th>
				<th field="CategoryName" width="50">Category Name</th>
				<th field="SubCategoryName" width="50">Sub-Category Name</th>
				
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newSubCategory()">New Sub-Category</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editSubCategory()">Edit Sub-Category</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeSubCategory()">Remove Sub-Category</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-refresh" plain="true" onclick="refreshDatagrid()">Refresh</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="window.print()">Print</a>
		<a href="../main.php" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" >Close</a>
	</div>
	
	
	<div id="dlg" class="easyui-dialog" style="width:400px;height:300px;padding:10px 20px"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Sub-Category</div>
		<form id="fm" method="post" novalidate>
			<div class="fitem">
				<label>Category:</label>
				<input id="CatID" class="easyui-combobox" name="CatID" 
				data-options="valueField:'CatID',textField:'CategoryName',url:'../phpfiles/get_data_generic.php?WhatToLoad=ALL'" required="true">								
			</div>
			
			<div class="fitem">				
				<label>Sub-Category:</label>
				<input name="SubCategoryName" class="easyui-textbox" required="true">
			</div>
			
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveSubCategory()" style="width:90px">Save</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
	</div>
	
	<script type="text/javascript">
		var url;
		function newSubCategory(){
			$('#dlg').dialog('open').dialog('setTitle','New Sub-Category');
			$('#fm').form('clear');
			url = '../phpfiles/save_subcategory.php';
		}
		
		function editSubCategory(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Edit Sub-Category');
				$('#fm').form('load',row);
				url = '../phpfiles/update_subcategory.php?SubCatID='+row.SubCatID;
			}
		}
		
		function saveSubCategory(){
			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(result){
					var result = eval('('+result+')');
					if (result.errorMsg){
						$.messager.show({
							title: 'Error',
							msg: result.errorMsg
						});
					} else {
						$('#dlg').dialog('close');		// close the dialog
						$('#dg').datagrid('reload');	// reload the grid data
					}
				}
			});
		}
		
		function removeSubCategory(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('Confirm','Are you sure you want to delete this sub-category?',function(r){
					if (r){
						$.post('../phpfiles/delete_subcategory.php',{id:row.id},function(result){
							if (result.success){
								$('#dg').datagrid('reload');	// reload the user data
							} else {
								$.messager.show({	// show error message
									title: 'Error',
									msg: result.errorMsg
								});
							}
						},'json');
					}
				});
			}
		}
		
		function refreshDatagrid () {
			$('#dg').datagrid('reload');	// reload the grid data
		}
		
	</script>
	<style type="text/css">
		#fm{
			margin:0;
			padding:10px 30px;
		}
		.ftitle{
			font-size:14px;
			font-weight:bold;
			padding:5px 0;
			margin-bottom:10px;
			border-bottom:1px solid #ccc;
		}
		.fitem{
			margin-bottom:5px;
		}
		.fitem label{
			display:inline-block;
			width:100px;
		}
		.fitem input{
			width:240px;
		}
	</style>
	<div>
	<a href="#top">Go to top</a>
	</div>
</body>
</html>