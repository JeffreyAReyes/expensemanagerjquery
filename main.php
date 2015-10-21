

<?php 
	require 'includes/sessionchecker.php';	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />		
	 <title>Expense Manager</title>
    <link rel="stylesheet" type="text/css" href="themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="themes/icon.css">
    <link rel="stylesheet" type="text/css" href="views/demo.css">
    <script type="text/javascript" src="jsfiles/jquery.min.js"></script>
    <script type="text/javascript" src="jsfiles/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="jsfiles/get_data.js"></script>
	<script type="text/javascript" src="jsfiles/misc_procs.js"></script>
</head>

<body class="easyui-layout">
		<div region="north" border="false" class="rtitle">
			Expense Manager
		</div>
	
		<div class="easyui-panel" style="padding:5px;width:100%;background:#fafafa;">
			<h2>Expense Manager</h2>
			<h1>WELCOME, <?php echo $_SESSION['fname'];?></h1>        
		</div>
     
    <div class="easyui-panel" style="padding:5px;width:100%">
        <a href="main.php" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-home'">Home</a>
		<a href="#" class="easyui-menubutton" data-options="menu:'#mmsystem',iconCls:'icon-setup'">System</a>
        <a href="#" class="easyui-menubutton" data-options="menu:'#mmsetup',iconCls:'icon-setup'">Set-up</a>
        <a href="#" class="easyui-menubutton" data-options="menu:'#mmtrans',iconCls:'icon-trans'">Transactions</a>
		<a href="#" class="easyui-menubutton" data-options="menu:'#mmreports',iconCls:'icon-report'">Reports</a>
        <a href="#" class="easyui-menubutton" data-options="menu:'#mmhelp',iconCls:'icon-help'">Help</a>
    </div>
	
    <div id="mmsetup" style="width:250px;">
        <div a href="views/category.php" data-options="iconCls:'icon-cat'">Category</div>
        <div a href="views/subcategory.php"  data-options="iconCls:'icon-subcat'">Sub-Category</div>
        <div class="menu-sep"></div>
        <div a href="views/payee.php"  data-options="iconCls:'icon-subcat'">Payee</div>	   
		<div a href="views/banks.php"  data-options="iconCls:'icon-subcat'">Banks</div>		
        <div class="menu-sep"></div>
		
		<div>
			<span>Investments and Bank Accounts</span>
			<div style="width:220px;">
				<div>Investments</div>
				
				<div a href="views/bank_accounts.php"  data-options="iconCls:'icon-subcat'">Bank Accounts</div>		
			</div>
		</div>
		
    </div>
	<div id="mmsystem" style="width:100px;">
        <div a href="index.php">Login</div>
		<div a href="index.php">Logout</div>        
        <div a href="index.php">Exit</div> 
    </div>
    <div id="mmtrans" style="width:100px;">
        <div a href="views/income.php">Income</div>
		<div a href="views/expenses.php">Expense</div>        
        
    </div>
	 <div id="mmreports" style="width:150px;">
        <div>Income</div>
        <div>Expense</div>
        <div  a href="views/income_expense.php"  data-options="iconCls:'icon-subcat'">Income-Expense</div>
		<div  a href="views/bank_account_ledger.php"  data-options="iconCls:'icon-subcat'">Bank Accounts</div>
    </div>
	<div id="mmhelp" style="width:100px;">
        <div>About</div>
        <div>User Guides</div>
        
    </div>
			
		<div class="easyui-panel" title="Dashboard" style="padding:5px;width:100%;height:400px;background:#fafafa;">
		<div class="easyui-layout" data-options="fit:true">
			<div data-options="region:'west'" style="width:35%">
				<div class="easyui-panel" title="Income" style="width:100%;height:45%;background:#fafafa;padding:5px">
					
					<div class="fitem">
						<label>Today's Income:</label>
						<input name="TodayIncome"   id="TodayIncome" class="easyui-numberbox" value="0"  data-options="precision:2,readonly:true">						
						<a href="views/income_expense.php" class="easyui-linkbutton" >Details</a>
						<label>Month-to-Date Income:</label>
						<input name="MonthIncome"  id="MonthIncome" class="easyui-numberbox" value="0"  data-options="precision:2,groupSeparator:',',readonly:true">
						<a href="views/income_expense.php" class="easyui-linkbutton" >Details</a>
						<label>Year-to-Date Income:</label>
						<input name="YearIncome"  id="YearIncome"  class="easyui-numberbox" value="0"  data-options="precision:2,readonly:true">
						<a href="views/income_expense.php" class="easyui-linkbutton" >Details</a>
					</div>
				</div>
				<div class="easyui-panel" title="Expense" style="width:100%;height:45%;background:#fafafa;padding:5px">
				
					<div class="fitem">
						<label >Today's Expense:</label>
						<input name="TodayExpense"  id="TodayExpense"  class="easyui-numberbox" value="0"  data-options="min:0,precision:2,readonly:true">
						<a href="views/income_expense.php" class="easyui-linkbutton" >Details</a>
						<label>Month-to-Date Expense:</label>
						<input name="MonthExpense"   id="MonthExpense" class="easyui-numberbox" value="0"  data-options="min:0,precision:2,readonly:true">
						<a href="views/income_expense.php" class="easyui-linkbutton" >Details</a>
						<label>Year-to-Date Expense:</label>
						<input name="YearExpense"   id="YearExpense" class="easyui-numberbox" value="0"  data-options="min:0,precision:2,readonly:true">
						<a href="views/income_expense.php" class="easyui-linkbutton" >Details</a>
					</div>
				</div>
			</div>
			<div data-options="region:'east'" style="width:25%">
				
			</div>
			<div data-options="region:'center'" style="width:35%">
				<table id="dg" title="Bank Accounts" class="easyui-datagrid" style="width:100%;height:100%"
					url="phpfiles/get_data_no_params.php?sql_query=GetBankAccounts()" 
					toolbar="#toolbar" fitColumns="true" singleSelect="true">
					<thead>
						<tr>
							<th field="BAID" width="1" hidden="true">BAID</th>
							<th field="BID" width="1" hidden="true">BID</th>
							<th field="BankSymbol" width="30%">Bank Symbol</th>							
							<th field="AccountType" width="30%">Account Type</th>							
							<th field="CurrentBalance" width="30%"  align="right"  formatter="formatPrice">Current Balance</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
    </div>
	
	<script>

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
			width:200px;
			font-size:14px;
		}
		.fitem input{
			width:150px;
			font-size:14px;
		}
				
		.numberbox .textbox-text{
			text-align: right;
			color: black;
			font-size:14px;

		}
		
		.rtitle{
			font-size:18px;
			font-weight:bold;
			padding:5px 10px;
			background:#336699;
			color:#fff;
		}
	
	</style>
	
</body>
</html>