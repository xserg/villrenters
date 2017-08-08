{searchForm_javascript}
<div id="adv-search-container" class="rbgrade">
<div class="roundedBox">
	
	<h2 class="rbtitle"><span class="adv-heading">Расширенный поиск</span></h2>
	<div class="clear"></div> 
	<div class="rbcontent">
		<div class="rbinner">
			<form id="adv-search-form" name="searchForm" action="" method="get" onsubmit="try { var myValidator = validate_searchForm; } catch(e) { return true; } return myValidator(this);">
			{searchForm_op_html}
			{searchForm_act_html}
			<fieldset>
			<div class="hr">&nbsp;</div>
				<div class="columns">
					<h3 class="title">Где бы вы хотели отдохнуть?</h3> 	
					<div class="column">
					<div class="label"><label for="searchKeywords">Страна</label></div>
					<div class="element">{searchForm_region_html}</div>
					</div>
					<div class="column">
					<div class="label"><label for="searchKeywords">Ключевые слова</label></div>
					<div class="element">{searchForm_keyword_html}</div>
					</div>
				</div>
				<div class="hr">&nbsp;</div>
				
				<div class="columns" id="price-range-fields">
					<div class="column">
						<div class="label"><label for="startDateInput">Дата заезда:</label></div>
						<div class="element">{searchForm_startDateInput_html}</div>
					</div>

					<div class="column">
						<div class="label"><label for="endDateInput">Дата отъезда:</label></div>
						<div class="element">{searchForm_endDateInput_html}</div>
					</div>

				</div>
				<div class="hr">&nbsp;</div>
				<div class="columns">
					<h3 class="title">Спальных мест:</h3>
					<div class="column">
						<div class="label"><label for="sleeps"></label></div>
						<div class="element">
							{searchForm_sleeps_html}
						</div>

					<div class="clear"></div>
				</div>
			</fieldset>

			<input src="img/search.png" name="find_button" class="search-submit-button" height="23" type="image" width="65">
		</form>
		</div>
	</div>
</div>
</div>

    </div>
