<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>Expense Manager (Report: Bank Account Ledger)</title>
    <link rel="stylesheet" type="text/css" href="../themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="../themes/icon.css">
    <link rel="stylesheet" type="text/css" href="demo.css">
    <script type="text/javascript" src="../jsfiles/jquery.min.js"></script>
    <script type="text/javascript" src="../jsfiles/jquery.easyui.min.js"></script>
</head>

<body  >
	
	<h2>Expense Manager (Report: Bank Account Ledger)</h2>	
	
	<div class="easyui-panel" style="padding:5px;width:100%">
        <div id ="dateselectors" >
			Bank Account: <input id="BID" name="BID" value="01" >
			Date From: <input id="StartDate"  type="text" class="easyui-datebox"  style="width:110px" name="StartDate">
			Date To:<input id="EndDate"  type="text" class="easyui-datebox" style="width:110px"  name="EndDate">
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search"  onclick="reloadData()">Load</a>
			
		</div>	
    </div>
	
		<table id="dg" title="Bank Account Ledger Details" class="easyui-datagrid" style="width:100%;height:90%;padding:10px;"
						 fitColumns="true" singleSelect="true" toolbar="#toolbar" 	>			
			<thead>
				<tr>
					<th field="BALID" width="1"  hidden="true">BALID</th>
					<th field="BAID" width="50"  hidden="true">BAID</th>								
					<th field="RefNumber" width="15%"  >Ref Number</th>
					<th field="TransDate" width="15%">Trans Date</th>
					<th field="Debit" width="10%" align="right"  formatter="formatPrice">Debit</th>						
					<th field="Credit" width="10%" align="right"  formatter="formatPrice">Credit</th>
					<th field="Run_Bal" width="10%" align="right"  formatter="formatPrice">Balance</th>
					<th field="Remarks" width="40%"  >Remarks</th>
				</tr>
			</thead>								
		
	<div id="toolbar"  style="padding:2px 5px;">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newData()">New Data</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editData()">Edit Data</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeData()">Remove Data</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-refresh" plain="true" onclick="refreshDatagrid()">Refresh</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="printData()">Print</a>		
		<a href="../main.php" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" >Close</a>
	</div>
		
	<div id="dlg" class="easyui-dialog" style="width:500px;height:380px;padding:10px 20px"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Add Transactions</div>
		<form id="fm" method="post" novalidate>
			
			<div class="fitem">
				<label>ID:</label>				
				<input id="BAID" class="easyui-textbox"  name="BAID"  required="true"  readonly="true" >		
			</div>
			<div class="fitem">
				<label>Bank Account:</label>				
				<input id="BAIDHide" class="easyui-textbox"  name="BAIDHide"  required="true" readonly="true" >		
			</div>
			<div class="fitem">				
				<label>Ref Number:</label>
				<input id="RefNumber" class="easyui-textbox"  name="RefNumber"  required="true">	
			</div>
			<div class="fitem">
				<label>Date:</label>
				<input id="TransDate" type="text" class="easyui-datebox"  name="TransDate" required="required">							
			</div>
						
			<div class="fitem">				
				<label>Debit:</label>
				<input id="Debit" class="easyui-numberbox"   name="Debit" data-options="min:0,precision:2" value="0.00" required="true">
			</div>
			<div class="fitem">				
				<label>Credit:</label>
				<input id="Credit" class="easyui-numberbox"   name="Credit" data-options="min:0,precision:2"  value="0.00" required="true">
			</div>
			<div class="fitem">				
				<label>Remarks:</label>
				<input id="Remarks" class="easyui-textbox"   name="Remarks" >
			</div>
		</form>
	</div>
	
	<div id="dlg-buttons">
		<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveData()" style="width:90px">Save</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
	</div>
	
	<form id="TheForm" method="post" action="../fpdf/print_bank_account_ledger.php" target="TheWindow">
		<input type="hidden" id="BankName" name="BankName" value="" />
		<input type="hidden"  id="JsonData" name="JsonData" value="" />
		<input type="hidden" name="other" value="something" />
	</form>
		
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
	<script type="text/javascript" src="../jsfiles/bank.account.ledger.js"></script>
</body>
</html>