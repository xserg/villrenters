
function unavaildate(pdate){
alert("���� " + pdate + " ��� �������������!");
}

function myDate(y1, m1, d1){
var date_OK
date_OK = false;
var days;

with(document.forms.calendar){
		if(date1.value == '' && date2.value == ''){
			date1.value = y1 + "/" + m1 +"/" + d1; //pick;
			start_date.value = d1 + "." + m1 +"." +y1;
			}
		else if(date1.value != '' && date2.value ==''){
			date2.value = y1 + "/" + m1 +"/" + d1; //pick;
			end_date.value = d1 + "." + m1 + "." + y1;
			date_OK = true;
			var t1 = new Date(date1.value);
			var t2 = new Date(date2.value);
			var dt1 = new Date();
			var dt2 = new Date();
			var diff = new Date();
			dt1.setTime(t1.getTime());
			dt2.setTime(t2.getTime());
			diff.setTime((dt2.getTime() - dt1.getTime()) );
			timediff = diff.getTime();
			days = timediff / (1000 * 60 * 60 * 24 );
			numdays.value = days;
			if (minp > 0)
			{
				if (days < minp)
				{
					date_OK = false;
					alert("�������� ����� ����������� ������ ����������� " + minp + " ����");
					date1.value = '';
					date2.value = '';
					start_date.value = '';
					end_date.value = '';
					numdays.value = '';
				}
			}
		}
		else if (date1.value != '' && date2.value != ''){
			date1.value = y1 + "/" + m1 +"/" + d1; //pick;
			start_date.value = d1 + "." + m1 + "." + y1;
			date2.value = '';
			end_date.value = '';
			}
			
		if ( days < 1 && date_OK ){
				date_OK = false;
				alert(" ������: ��������� ���� ������ ��������, �������� ��� ���");
			date1.value = '';
			date2.value = '';
			start_date.value = '';
			end_date.value = '';
			numdays.value = '';
		}
			
	}// end of with
	
}

function temp_prices(pval)
{
// this sets the price forthe text box for the mouse hover
	document.forms.calendar.temp_price.value = pval;
}