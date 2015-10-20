/* ******************************************** Miscellaneous functions ***************************************************************/
		
		var today ;		
		var firstday ;	
		
		$(document).ready(function setValueOfDatebox() {
			
			today = new Date();
			firstday = new Date();
			
			/* var dd = today.getDate(); */
			var dd1 = 1;
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();

			if(dd<10) {
				dd='0'+dd
			} 

			if(mm<10) {
				mm='0'+mm
			} 
			
			if(dd1<10) {
				dd='0'+dd
			} 

			if(mm<10) {
				mm='0'+mm
			} 

			today = mm+'/'+dd+'/'+yyyy;
			firstday = mm+'/'+dd1+'/'+yyyy;

			$('#StartDate').datebox('setValue', firstday);	// set datebox value
			$('#EndDate').datebox('setValue', today);		// set datebox value	

			//window.alert(today);
			
			//$('#dg').datagrid({
			//url:"../phpfiles/get_data_no_params.php?sql_query=GetBankAccounts()"});
	  
			//refreshDatagrid ();
			 //$( "p" ).text( "The DOM is now loaded and can be manipulated." );
			//$( window ).load( addTotal );
		});
		
		
		
		function reloadData($BAID) {
				
			var startdate = $('#StartDate').datebox('getValue');
			var enddate = $('#EndDate').datebox('getValue');
			
			$('#dg').datagrid({
				url:"../phpfiles/get_bank_account_ledger.php?BAID="  + $BAID
			});
	  
			//refreshDatagrid ();
			//alert($BAID + " - reloadData($BAID)");
			//addTotal();
		}
		
		//function setValueOfDatebox() {
			
		//	today = new Date();
		//	var dd = today.getDate();
		//	var mm = today.getMonth()+1; //January is 0!
		//	var yyyy = today.getFullYear();

		//	if(dd<10) {
		//		dd='0'+dd
		//	} 

		//	if(mm<10) {
		//		mm='0'+mm
		//	} 

		//	today = mm+'/'+dd+'/'+yyyy;

		//	$('#StartDate').datebox('setValue', today);	// set datebox value
		//	$('#EndDate').datebox('setValue', today);	// set datebox value				
		//}
		
		 //$(function(){
         //   $('#dg').datagrid({
		//	rowStyler: function(index,row){
		//	if (row.CatID==1 || row.CatID==2){
				//return 'color:#fff;'; // return inline style
			// the function can return predefined css class and inline style
			// return {class:'r1', style:{'color:#fff'}};	
		//			}
		//		}
		//	});
        //});
		
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
				
		function addTotal() {
			
			var totalSum = 0;
			var totalExpense = 0;
			
			var rows = $('#dg').datagrid('getRows');		
			
			for(var i=0; i<rows.length; i++){
				
				totalSum=totalSum + parseFloat(rows[i].Amount);
				totalExpense=totalExpense + parseFloat(rows[i].ExpenseAmount);
				}
			alert (rows.length + totalSum);
			
			$('#dg').datagrid('appendRow',{
			CatID: '',
			CategoryName: '',
			SubCategoryName: '',
			CatSubcat: 'TOTAL',
			RefNum: '',
			TransDate: '',
			Amount: totalSum,
			ExpenseAmount: totalExpense,
			Remarks: ''
			});
			
			//$('#dg').datagrid('freezeRow',rows.length-1);
			
		}
		
		function calcTotal () {
						
			var totalSum = 0;
			var totalExpense = 0;
			
			var rows = $('#dg').datagrid('getRows');		
			
			for(var i=0; i<rows.length; i++){
				
				totalSum=totalSum + parseFloat(rows[i].Amount);
				totalExpense=totalSum + parseFloat(rows[i].ExpenseAmount);
				}			
		}
				
		// Function to print spaces
		function printSpaces(intNumOfSpaces)
			
			{
			var spaces="";
			for(var i=0; i<intNumOfSpaces; i++){
				//document_print.document.write("&nbsp");
				//alert("hello");
				spaces=spaces+"&nbsp";
			}
			return spaces;
		}
		
		// Function to pad text with space at the right
		function spacePad(textData, width) {
			var string = (textData);
			while (string.length < width)
			string =  string + "0";
			return string;
		}
		
		// Function to pad text with space at the left
		function spacePadLeft(textData, width) {
			var string = (textData);
			while (string.length < width)
			string =  "0" + string ;
			return string;
		}
		
		function printTest() {
			
			var divContents = $("#dg").html();
            var printWindow = window.open('', '', 'height=400,width=800');
            printWindow.document.write('<html><head><title>DIV Contents</title>');
            printWindow.document.write('</head><body >');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
		}
		
		function printData()
			{  
  
				var display_setting="toolbar=yes,location=no,directories=yes,menubar=yes,";  
				display_setting+="scrollbars=yes,width=750, height=600, left=100, top=25";  
  
				var content_innerhtml = document.getElementById("dg").innerHTML;  
				var document_print=window.open("","",display_setting);  
				document_print.document.open();  
				//document_print.document.write('<html><head><title>Income-Expense Report</title></head>');  
				document_print.document.write('<body style="font-family:sans serif; font-size:8px;" onLoad="self.print();self.close();" >');  
				
				document_print.document.write("Income-Expense Report<br/>"); 
				document_print.document.write("---------------------------------------------------------------------------------------------------------------");
				document_print.document.write("-----------------------<br/>");
				//document_print.document.write("<br/>");
				document_print.document.write("Account &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ref. Num<br/>");
				document_print.document.write("---------------------------------------------------------------------------------------------------------------");
				document_print.document.write("-----------------------<br/>");
				document_print.document.write("<br/>");
				
				var rows = $('#dg').datagrid('getRows');		
				
				var accountTitle="";
				var refNum="";
				var dtDate="";
				
				for(var i=1; i<rows.length; i++){
				
					if ((rows[i].CatSubcat)== "TOTAL"){
						
					}
					
					else{
						accountTitle=spacePad((rows[i].SubCategoryName),20);
						RefNum=spacePad((rows[i].RefNum),2);
						dtDate=spacePadLeft((rows[i].TransDate),15);
						//accountTitle=(rows[i].SubCategoryName).padRight(20, "!");
						//RefNum=(rows[i].RefNum).padRight(10, "!");
						//dtDate=(rows[i].dtDate).padRight(10, "!");
						if ((accountTitle.length)<20) {
							accountTitle=spacePad(accountTitle,20-accountTitle.length)
						}
						document_print.document.write(accountTitle   + printSpaces(10) + RefNum  + dtDate + "<br/>");
					}											
				}
								
				document_print.document.write("<br/>");
				document_print.document.write('</body></html>');  
				document_print.print();  
				document_print.document.close();  
				return false;  
		}  

		$('#BID').combogrid({
			panelWidth:410,
			value:'006',
			idField:'BAID',
			textField:'CompanyName',
			url:'../phpfiles/get_data_no_params.php?sql_query=GetBankAccounts()',
			columns:[[
				{field:'BAID',title:'BAID',hidden:'true',width:1},
				{field:'BankSymbol',title:'Bank Symbol',width:100},
				{field:'CompanyName',title:'Company Name',width:200},
				{field:'AccountType',title:'Account Type',width:100}
				]],
				onSelect: function(BID){
						//alert($('#BID').textbox('getValue'));
						reloadData($('#BID').textbox('getValue'));
						
						}
		});
		
		// Function to convert datagrid to JSON data
		function tableToJson() { 
			
			var data = []; // first row needs to be headers var headers = [];
			
			try {
							
			var rows = $('#dg').datagrid('getRows');		
			
			for(var i=0; i<rows.length; i++){
				
				//totalSum=totalSum + parseFloat(rows[i].Amount);
				data.push({
					RefNumber: rows[i].RefNumber,
					TransDate: rows[i].TransDate,
					Debit: rows[i].Debit,
					Credit: rows[i].Credit,
					Run_Bal: rows[i].Run_Bal
					});
				}
				var json = JSON.stringify(data);
				console.log(json);
				return json;
				
			}
			catch(err) {
				//Block of code to handle errors
				alert("Error: " + err + ".");
			} 
			finally {
				//Block of code to be executed regardless of the try / catch result
			}
								
		}
			
		/* Print using fpdf library */
		
		function printData() {
			
			document.getElementById('BankName').value = $('#BID').textbox('getText');
			
			document.getElementById('JsonData').value = tableToJson();
			window.open('', 'TheWindow');
			document.getElementById('TheForm').submit();			
		}
		/* Print using fpdf library */

		/* ******************************************** Miscellaneous functions ***************************************************************/
		
		/* ******************************************** Data functions ********************************************************************** */
		var url;
		var curValue;
		var curText;
		
		function newData(){
			
			var tt = $('#BID');
			curValue = tt.textbox('getValue');
			curText = tt.textbox('getText');
						
			$('#dlg').dialog('open').dialog('setTitle','New Transaction - ' + curText);
			$('#fm').form('clear');						
			$('#BAIDHide').textbox('setValue', curText);	
			$('#BAID').textbox('setValue', curValue);					
			url = '../phpfiles/save_bank_ledger_data.php?PACTION=0&BALID=0';
		}
		
		function editData(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Edit Transaction');
				$('#fm').form('load',row);
				url = '../phpfiles/save_bank_ledger_data.php?BALID='+row.BALID  + '&PACTION=1';
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
		
		function deleteData(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('Confirm','Are you sure you want to delete this income?',function(r){
					if (r){
						$.post('../phpfiles/SaveBankAccountsLedger.php',{BALID:row.BALID},function(result){
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
			//var v = $('#StartDate').datebox('getValue');
			//window.alert(today + v);
		}
						
		/* ******************************************** Data functions ****************************************************************** */
		