<div id="adv-search-container" class="rbgrade">
<div class="roundedBox">
	<h2 class="rbtitle"><span class="adv-heading">Расширенный поиск</span></h2>
	<div class="clear"></div>
	<div class="rbcontent">
		<div class="rbinner">
			<form id="adv-search-form" name="searchForm" action="/search/" method="get">
			<fieldset>
			<div class="hr">&nbsp;</div>
				<div>
					<h3 class="title">Где бы вы хотели отдохнуть?</h3> 	
					<div class="label">
						<label for="searchKeywords">Место расположения, ключевые слова</label>
					</div>
					<div class="element">
						<!--input autocomplete="off" id="searchKeywords" name="keyword" tabindex="1" class="text input-keyword default ac_input" autocompletion="off"-->
						{searchForm_keyword_html}
					</div>
				</div>
				<div class="hr">&nbsp;</div>
				<!--div class="columns">
					<h3 class="title">When would you like to go?</h3>
					<div class="column">
						<div class="label"><label for="startDateInput">Arrival</label></div>
						<div class="element"><input id="startDateInput" name="startDateInput" value="dd/mm/yyyy" class="datepicker text" maxlength="10" onkeydown="return false;" type="text"></div>
						<div class="clear"></div>
					</div>
					<div class="column">
						<div class="label"><label for="endDateInput">Departure</label></div>
						<div class="element"><input id="endDateInput" name="endDateInput" value="dd/mm/yyyy" class="datepicker text" maxlength="10" onkeydown="return false;" type="text"></div>		
						<div class="clear"></div>
					</div>
				</div>
<div class="hr">&nbsp;</div-->
<div class="columns" id="price-range-fields">
	<h3 class="title">Цена в неделю (Евро)</h3>
	<div class="column" id="price-from-column">
		<div class="label"><label for="priceFrom">Минимальная</label></div>
		<div class="element">
			{searchForm_minprice_html}
		</div>
		<div class="clear"></div>
	</div>
	<div class="column" id="price-to-column">
		<div class="label"><label for="priceTo">Максимальная</label></div>
		<div class="element">
			{searchForm_maxprice_html}
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<div class="form-row hidden" id="price-range-vaidation">
		<p>Price from cannot exceed price to</p>
	</div>
</div>
				<div class="hr">&nbsp;</div>
				<div class="columns">
					<h3 class="title">Какой тип недвижимости вам подойдет?</h3>
					<div class="column">
						<div class="label"><label for="sleeps">Спальных мест:</label></div>
						<div class="element">
							{searchForm_sleeps_html}
						</div>
						<!--div class="label"><label for="bedrooms">Bedrooms</label></div>
						<div class="element">
							<select name="refinements" id="bedrooms">
								<option selected="selected" value="">All</option>
									<option value="Bedrooms:Studio">Studio</option>								
									<option value="Bedrooms:1">1 bedroom</option>								
									<option value="Bedrooms:2">2 bedrooms</option>								
									<option value="Bedrooms:3">3 bedrooms</option>								
									<option value="Bedrooms:4">4 bedrooms</option>								
									<option value="Bedrooms:5*">5+ bedrooms</option>								
							</select>
						</div-->
					</div>
					<div class="column">
						<div class="label"><label for="propertyType">Тип</label></div>	
						<div class="element">
							{searchForm_proptype_html}
						</div>		
						<div class="label"><label for="user_id">Владелец</label></div>	
						<div class="element">
							{searchForm_user_id_html}
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</fieldset>
			<input src="img/search.png" class="search-submit-button" height="23" type="image" width="65">
			
		</form></div>
	</div>
</div>
</div>
</div>