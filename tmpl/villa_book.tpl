<div id="location-bar" class="anchor-links roundedBox">
{VILLA_NAV}
</div>
<div id="availability" class="main">
	<div id="availabilityCalendars">
<h2 class="propertySubHead"><span>{BOOKING_TITLE}</span></h2>
<!-- BEGIN HELP -->
������:
<b>{date1} - {date2}, {people} �������(�)</b><br><br>
<!-- BEGIN FIRST_PRICE -->
���� ����������: <b>{first_price} {currency}</b><br>
����� �� �����: {breakage}<br>
<!-- �����: {cost} --><br>
<br>
<br> ��������� ���������� �� ������ ��� ������� �������� ������� ����� ������ ������.<br><br>
<!-- END FIRST_PRICE -->
<!--  
�� ������ �������������� ������������� � �������� ������ � ������������� <a href="{rs_url}">���������� �� ���������� �����</a>,<br> 
��� ��������� ������ � <a href="{query_url}">������� ������</a>, �� ������� ��� � �����������.
-->

<a href="{query_url}">������� � ����������</a>

<br><br>
<!-- 
��, �����, ������ ��������� <a href="/pages/booking" target=_blank>������� ���������� �� ������������</a> (� ����� ����)
 -->
 <!-- END HELP -->
<!-- BEGIN CALENDAR -->
<div class="calendars">
	<div class="cal-content">
        
       <div class="clear"></div>

        <div>
		<!-- BEGIN BF -->
		<b>��� ������ ������� ������������, �������� ���� �� ���������:</b><br><br>
		{BOOKING_FORM}
		<!-- ��� ����, ����� ������� ����, �������� ������ �� �����. -->
		<br>��� ������� ����, �������� ������ ������������ � ������� "���������"
		<br><br>
		<!-- END BF -->
		{CALENDAR}
		</div>
		<div class="clear"></div>

	</div>
	<div class="legend-content">
		<dl class="legend">
			<dt class="a"></dt>
			<dd>��������</dd>
			<dt class="u">&nbsp;&nbsp;</dt>
			<dd>������</dd>
			<!--dt class="s"></dt>
			<dd>Special Offer</dd-->
		</dl>
    </div>
	<div class="clear"></div>
</div>
<!-- END CALENDAR -->
<br class="clear">
    </div>
</div>
<div id="location-bar" class="anchor-links roundedBox">
{VILLA_NAV}
</div>