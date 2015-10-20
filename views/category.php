<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>Expense Manager - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="../themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="../themes/icon.css">
    <link rel="stylesheet" type="text/css" href="demo.css">
    <script type="text/javascript" src="../jsfiles/jquery.min.js"></script>
    <script type="text/javascript" src="../jsfiles/jquery.easyui.min.js"></script>
</head>

<body>

		<ul id="nav">
			<li><a href="../main.php">Home</a></li>
			
		</ul>
		
	<h2>Expense Manager - Account Categories</h2>
	<p>Click the buttons on datagrid toolbar to do actions.</p>
		
	<table id="dg" title="Categories" class="easyui-datagrid" style="width:1000px;height:500px"
			url="../phpfiles/get_category.php"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
				<th field="CatID" width="50">CatID</th>
				<th field="CategoryName" width="50">Category Name</th>
				
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">New Category</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Edit Category</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Remove Category</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-refresh" plain="true" onclick="refreshDatagrid()">Refresh</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="window.print()">Print</a>
		<a href="../main.php" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" >Close</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px"
			closed="true" buttons="#dlg-buttons">
		<div class="ftitle">Accounts Title Category</div>
		<form id="fm" method="post" novalidate>
			<div class="fitem">
				<label>Category:</label>
				<input name="CategoryName" class="easyui-textbox" required="true">
			</div>
			
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Save</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
	</div>
	<script type="text/javascript">
		var url;
		function newUser(){
			$('#dlg').dialog('open').dialog('setTitle','New Category');
			$('#fm').form('clear');
			url = '../phpfiles/save_category.php';
		}
		
		function editUser(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Edit Category');
				$('#fm').form('load',row);
				url = '../phpfiles/update_category.php?CatID='+row.CatID;
			}
		}
		
		function saveUser(){
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
						$('#dg').datagrid('reload');	// reload the user data
					}
				}
			});
		}
		
		function destroyUser(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('Confirm','Are you sure you want to delete this category?',function(r){
					if (r){
						$.post('../phpfiles/destroy_user.php',{id:row.id},function(result){
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
			width:80px;
		}
		.fitem input{
			width:300px;
		}
	</style>
</body>
</html>