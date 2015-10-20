
//Miscellaneous functions
/* 
	1. formatPrice - formats textbox text into readable display
	
	*/

function formatPrice(val){
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