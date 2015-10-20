<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>Expense Manager - Bank Accounts</title>
    <link rel="stylesheet" type="text/css" href="../themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="../themes/icon.css">
    <link rel="stylesheet" type="text/css" href="demo.css">
    <script type="text/javascript" src="../jsfiles/jquery.min.js"></script>
    <script type="text/javascript" src="../jsfiles/jquery.easyui.min.js"></script>
</head>

<body>
		
	<h2>Expense Manager -  Bank Accounts</h2>
	
	<table id="dg" title="Banks" class="easyui-datagrid" style="width:100%;height:95%"
			url="../phpfiles/get_data_no_params.php?sql_query=GetBankAccounts()" 
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
				<th field="BAID" width="1" hidden="true">BAID</th>
				<th field="BID" width="1" hidden="true">BID</th>
				<th field="BankSymbol" width="10%">Bank Symbol</th>
				<th field="CompanyName" width="20%">Company Name</th>
				<th field="AccountType" width="10%">Account Type</th>
				<th field="AccountDetails" width="45%">Account Details</th>
				<th field="CurrentBalance" width="10%"  align="right"  formatter="formatPrice">Current Balance</th>
			</tr>
		</thead>
	</table>
	
	<div id="toolbar">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newData()">New </a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editData()">Edit </a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeData()">Remove </a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-refresh" plain="true" onclick="refreshDatagrid()">Refresh</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="window.print()">Print</a>
		<a href="../main.php" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" >Close</a>
	</div>
		
	<div id="dlg" class="easyui-dialog" style="width:400px;height:300px;padding:10px 20px"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle"> Bank Accounts</div>
		<form id="fm" method="post" novalidate>
			<div class="fitem">				
				<label>Select Bank:</label>
				<input id="BID" name="BID" value="01"  required="true">
		
			</div>
			<div class="fitem">				
				<label>Account Type:</label>
				<input id="AccountType" class="easyui-combobox"  name="AccountType" 
				data-options="valueField:'ATID',textField:'AccountType',url:'../phpfiles/get_data_no_params.php?sql_query=GetAccountTypes()'" required="true">	
			</div>
			
			<div class="fitem">
				<label>Account Details:</label>
				<input name="AccountDetails" class="easyui-textbox" required="true">							
			</div>
			
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveData()" style="width:90px">Save</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
	</div>
	
	<script type="text/javascript">
		var url;
		function newData(){
			$('#dlg').dialog('open').dialog('setTitle','New Bank Account');
			$('#fm').form('clear');
			url = '../phpfiles/save_bank_account.php?PACTION=0&BAID=0';
		}
		
		function editData(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Edit Bank Account');
				$('#fm').form('load',row);
				url = '../phpfiles/save_bank_account.php?BAID='+row.BAID + '&PACTION=1';
			}
		}
		
		function saveData(){
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
		
		function removeData(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('Confirm','Are you sure you want to delete this Bank Account?',function(r){
					if (r){
						$.post('../phpfiles/save_bank_account.php',{PACTION:2,id:row.BAID},function(result){
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
	
	$('#BID').combogrid({
    panelWidth:600,
    value:'006',
    idField:'BID',
    textField:'BankSymbol',
    url:'../phpfiles/get_data_no_params.php?sql_query=GetBanks()',
    columns:[[
        {field:'BID',title:'BID',width:1},
        {field:'BankSymbol',title:'Bank Symbol',width:100},
        {field:'CompanyName',title:'Company Name',width:400}
		]]
	});

	function formatPrice(val,row){
		if (val <= 0){
			return '<span style="color:red;">('+val+')</span>';
			//return ''
		} else {
			val += '';
			x = val.split('.');
			x1 = x[0];
			x2 = x.length > 1 ? '.' + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + ',' + '$2');
			}
			return x1 + x2;
			//return val;
			}
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
	
</body>
</html>