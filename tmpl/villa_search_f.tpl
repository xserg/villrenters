<form id="refineSearchform" name="refineSearchForm" method="get" action="">
			{searchForm_op_html}
			{searchForm_act_html}
			{searchForm_action_html}
			{searchForm_viewstate_html}
			{searchForm_eventvalidation_html}
Страна:
{searchForm_region_html}
Ключевое&nbsp;слово:
{searchForm_keyword_html}

		<div class="clear"></div>
					<div class="form-row">
						<label for="priceFrom">Дата&nbsp;заезда:</label>
						{searchForm_startDateInput_html}
					</div>
					<div class="form-row">
						<label for="priceFrom">Дата&nbsp;отъезда:</label>
						{searchForm_endDateInput_html}
					</div>
		<div class="clear"></div>
		<div id="price-range">
			<div class="container">
				<div class="content show">
					<div id="price-range-fields">

					<div class="form-row">
						<label for="priceTo">Мест:</label>
						{searchForm_sleeps_html}
					</div>
					<div class="form-row">
						<label for="priceTo">Тип:</label>
						{searchForm_proptype_html}
					</div>
				</div>
					<div class="clear"></div>
				<div class="form-row hidden" id="price-range-vaidation">
					<p>Цена мин. должна быть меньше макс.</p>
				</div>
			</div>
			</div>
		</div>


	<div id="findByDateButton" class="findByDateButton">
			<input src="/resources/9734/images/skin/orange-go-button1.png" class="search-submit-button" height="24" width="45" type="image">
		</div>
	</form>

