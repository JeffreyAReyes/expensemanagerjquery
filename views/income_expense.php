<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>Transactions-Income</title>
    <link rel="stylesheet" type="text/css" href="../themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="../themes/icon.css">
    <link rel="stylesheet" type="text/css" href="demo.css">
    <script type="text/javascript" src="../jsfiles/jquery.min.js"></script>
    <script type="text/javascript" src="../jsfiles/jquery.easyui.min.js"></script>
</head>

<body>
	
	<h2>Expense Manager (Report: Income-Expense)</h2>	
	<p>Not loaded yet.</p>	
	 <div class="easyui-panel" style="padding:5px;width:100%">
        <div id ="dateselectors" >	
			Date From: <input id="StartDate"  type="text" class="easyui-datebox"  style="width:110px" name="StartDate">
			Date To:<input id="EndDate"  type="text" class="easyui-datebox" style="width:110px"  name="EndDate">
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search"  onclick="reloadData()">Load</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search"  onclick="addTotal()">Calculate</a>
		</div>	
    </div>
			
	<table id="dg" title="Income-Expense Details" class="easyui-datagrid" style="width:100%;height:80%;padding:10px;"
			rownumbers="true" fitColumns="true" singleSelect="true"
			toolbar="#toolbar" data-options="onLoadSuccess:function(){addTotal()}"	>				
			
		<thead>
			<tr>

				<th field="CatID" width="1"  hidden="true">CatID</th>
				<th field="CategoryName" width="50"  hidden="true">Cat Name</th>
				<th field="SubCategoryName" width="50"  hidden="true">Sub-Cat Name</th>
				<th field="CatSubcat" width="100"  >Account</th>
				<th field="RefNum" width="60">Ref Num</th>
				<th field="TransDate" width="60">Date</th>							
				<th field="Amount" width="50" align="right"  formatter="formatPrice">Debit</th>
				<th field="ExpenseAmount" width="50" align="right"  formatter="formatPrice">Credit</th>				
				<th field="Remarks" width="150">Remarks</th>
			</tr>
		</thead>
	</table>
	
	<div id="toolbar"  style="padding:2px 5px;">
		
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="printData()">Print</a>		
		<a href="../main.php" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" >Close</a>
	</div>
		
	<div id="dlg" class="easyui-dialog" style="width:700px;height:380px;padding:10px 20px"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Expenses</div>
		<form id="fm" method="post" novalidate>
			<div class="fitem">
				<label>Category:</label>				
				<input id="CatID" class="easyui-combobox"  name="CatID" data-options="
					valueField: 'CatID',
					textField: 'CategoryName',
					url: '../phpfiles/get_category_expense.php',
					onSelect: function(rec){
						var url = '../phpfiles/get_subcategorybyid.php?CatID='+rec.CatID;
						$('#SubCatID').combobox('reload', url);
						}"  required="true">		
			</div>
			<div class="fitem">
				<label>Sub-Category:</label>
				<input id="SubCatID" class="easyui-combobox"  name="SubCatID" 
				data-options="valueField:'SubCatID',textField:'SubCategoryName'" required="true">								
			</div>
			<div class="fitem">
				<label>Date:</label>
				<input id="TransDate" type="text" class="easyui-datebox"  name="TransDate" required="required">							
			</div>
			<div class="fitem">				
				<label>Payee:</label>
				<input id="Payee" class="easyui-combobox"  name="Payee" 
				data-options="valueField:'PayeeName',textField:'PayeeName',url:'../phpfiles/get_all_payee.php'" required="true">	
			</div>
			<div class="fitem">				
				<label>Ref. Num:</label>
				<input id="RefNum" class="easyui-textbox"  name="RefNum" required="true">
			</div>
			<div class="fitem">				
				<label>Amount:</label>
				<input id="Amount" class="easyui-numberbox"   name="Amount" data-options="min:0,precision:2" required="true">
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
	
	<form id="TheForm" method="post" action="../fpdf/print_income_expense.php" target="TheWindow">
		<input type="hidden" id="ReportTitle" name="ReportTitle" value="" />
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
	<script type="text/javascript" src="../jsfiles/income.expense.js"></script>
</body>
</html>