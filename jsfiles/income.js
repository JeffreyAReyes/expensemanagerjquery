
/* js file for income.php*/

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
			url:"../phpfiles/get_income.php?StartDate=" + firstday + "&EndDate=" + today});
	  
			refreshDatagrid ();
		});
		
		function reloadData() {
				
			var startdate = $('#StartDate').datebox('getValue');
			var enddate = $('#EndDate').datebox('getValue');
			
			$('#dg').datagrid({
			url:"../phpfiles/get_income.php?StartDate=" + startdate + "&EndDate=" + enddate});
	  
			refreshDatagrid ();
		}
		
		function setValueOfDatebox() {
			
			today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();

			if(dd<10) {
				dd='0'+dd
			} 

			if(mm<10) {
				mm='0'+mm
			} 

			today = mm+'/'+dd+'/'+yyyy;

			$('#StartDate').datebox('setValue', today);	// set datebox value
			$('#EndDate').datebox('setValue', today);	// set datebox value				
		}
		
		var url;
		function newData(){
			$('#dlg').dialog('open').dialog('setTitle','New Income');
			$('#fm').form('clear');
			url = '../phpfiles/save_income.php?IID=0';
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
			var v = $('#StartDate').datebox('getValue');
			//window.alert(today + v);
		}