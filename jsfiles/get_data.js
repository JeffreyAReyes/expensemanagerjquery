$(document).ready(function(){
	
	$.post('phpfiles/get_income_expense_summary.php', $("form").serialize(), function(data) {
    
    //alert(data.length);  
		
	var JSONObject = JSON.parse(data);
	console.log(JSONObject);      // Dump all data of the Object in the console
	
	$('#TodayIncome').textbox('setValue',JSONObject[0]["DailyIncome"]);	
	$('#MonthIncome').textbox('setValue',JSONObject[0]["MonthlyIncome"]);	
	$('#YearIncome').textbox('setValue',JSONObject[0]["YearlyIncome"]);	
	
	$('#TodayExpense').textbox('setValue',JSONObject[0]["DailyExpense"]);	
	$('#MonthExpense').textbox('setValue',JSONObject[0]["MonthlyExpense"]);	
	$('#YearExpense').textbox('setValue',JSONObject[0]["YearlyExpense"]);	
});
	
});