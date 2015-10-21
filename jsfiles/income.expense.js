
/* Corresponding js file for income_expense.php*/

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
			
			$('#dg').datagrid({
			url:"../phpfiles/get_income_expense.php?StartDate=" + firstday + "&EndDate=" + today});
	  
			//refreshDatagrid ();
			 $( "p" ).text( "The DOM is now loaded and can be manipulated." );
			//$( window ).load( addTotal );
		});
						
		function reloadData() {
				
			var startdate = $('#StartDate').datebox('getValue');
			var enddate = $('#EndDate').datebox('getValue');
			
			$('#dg').datagrid({
				url:"../phpfiles/get_income_expense.php?StartDate=" + startdate + "&EndDate=" + enddate
			});
	  
			//refreshDatagrid ();
			
			addTotal();
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
			//alert (rows.length + totalSum);
			
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
						
		
	// Function to convert datagrid to JSON data
		function tableToJson() { 
			
			var data = []; // first row needs to be headers var headers = [];
			
			try {
							
			var rows = $('#dg').datagrid('getRows');		
			
			for(var i=0; i<rows.length-1; i++){
				
				//totalSum=totalSum + parseFloat(rows[i].Amount);
				data.push({
					CatSubcat: rows[i].SubCategoryName,
					RefNum: rows[i].RefNum,
					TransDate: rows[i].TransDate,
					Amount: rows[i].Amount,
					ExpenseAmount: rows[i].ExpenseAmount,
					Remarks: rows[i].Remarks
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
			
			document.getElementById('ReportTitle').value = "For the Date: " + $('#StartDate').datebox('getValue') + " - "  + $('#EndDate').datebox('getValue') ;
			document.getElementById('JsonData').value = tableToJson();
			window.open('', 'TheWindow');
			document.getElementById('TheForm').submit();			
		}
		/* Print using fpdf library */
		
		/* ******************************************** Miscellaneous functions ***************************************************************/
		
		/* ******************************************** Data functions ********************************************************************** */
		var url;
		function newData(){
			$('#dlg').dialog('open').dialog('setTitle','New Income');
			$('#fm').form('clear');
			url = '../phpfiles/save_expense.php?IID=0';
		}
		
		function editData(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Edit Income');
				$('#fm').form('load',row);
				url = '../phpfiles/update_subcategory.php?IID='+row.IID;
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
			//var v = $('#StartDate').datebox('getValue');
			//window.alert(today + v);
		}
		
		/* ******************************************** Data functions ********************************************************************** */