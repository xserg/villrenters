<!-- BEGIN SORT -->
<div>����������� ��:
	<!-- BEGIN SORTI -->
		<!-- BEGIN SITEM --><a href="{SORT_LINK}?s={SVAR}">{SNAME}</a>{SEPARATOR}<!-- END SITEM -->
		<!-- BEGIN SAITEM --><b>{SNAME}</b>{SEPARATOR}<!-- END SAITEM -->
	<!-- END SORTI -->
<br><br></div>
<!-- END SORT -->
<!-- BEGIN COL -->
<div class="col">
<!-- BEGIN USER_LIST -->
<ol class="comments">
<!-- BEGIN USER -->
	<li><a href="/user/{user_id}.html"><img src="{AVAT_URL}{user_avatar}" class="thumb" alt="" /></a>
	<div class="comm">
		<p class="p"><a href="/user/{user_id}.html">{username}</a>&nbsp;<span class=online>{online}</span><br />{stat_city}<br><strong>{stat_gender}</strong></p>
		<p>��������:<br>{stat_interes}</p>
	</div>	
	</li>
<!-- END USER -->
</ol>
<!-- END USER_LIST -->
</div>
<!-- END COL -->
<dl>
<dt>�����: {CNT}</dt> <dd>{PAGES}</dd>
</dl>
